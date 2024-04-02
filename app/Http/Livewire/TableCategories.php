<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class TableCategories extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $ruteCreate = false;
    public $amount = 5;
    public $search, $category;
    protected $listeners = ['render', 'delete' => 'delete'];

    protected $rules = [
        'category.name' => 'required',
        'category.slug' => 'required',
        'category.state' => 'required',
    ];

    public function render()
    {
        $this->category['user_id'] = auth()->user()->id;

        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->latest('id')
            ->paginate($this->amount);
        return view('admin.pages.table-categories', compact('categories'));
    }

    public function create()
    {
        $this->isOpen = true;
        $this->ruteCreate = true;
        $this->reset('category');
    }

    public function store()
    {
        $this->validate();
        if (!isset($this->category['id'])) {
            $category = Category::create($this->category);
            $this->emit('alert', 'Registro creado satisfactoriamente');
        } else {
            $category = Category::find($this->category['id']);
            $category->update($this->category);
            $this->emit('alert', 'Registro actualizado satisfactoriamente');
        }
        $this->reset(['isOpen', 'category']);
        $this->emitTo('categorys', 'render');
    }

    public function updatedCategoryName()
    {
        $this->category['slug'] = Str::slug($this->category['name']);
    }

    public function edit($category)
    {
        $this->category = array_slice($category, 0, 7);
        $this->isOpen = true;
        $this->ruteCreate = false;
    }

    public function delete($id)
    {
        Category::find($id)->delete();
    }
}
