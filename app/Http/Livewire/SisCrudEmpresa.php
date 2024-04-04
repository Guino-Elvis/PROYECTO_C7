<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SisCrudEmpresa extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $isOpen = false;
    public $ruteCreate = false;
    public $search, $empresa, $image;
    protected $listeners = ['render', 'delete' => 'delete'];

    protected $rules = [
        'empresa.ra_social' => 'required',
        'empresa.ruc' => 'required',
        'empresa.direccion' => 'required',
        'empresa.telefono' => 'required',
        'empresa.correo' => 'required',
        //  'empresa.user' => 'required'
    ];

    public function render()
    {
        $empresas = Empresa::where('ruc', 'like', '%' . $this->search . '%')->latest('id')->paginate(5);
        return view('admin.pages.empresa-page-crud', compact('empresas'));
    }

    public function create()
    {

        $this->isOpen = true;
        $this->ruteCreate = true;
        $this->reset('empresa', 'image');
        $this->resetValidation();

    }

    public function store()
    {

        $this->validate();

        if (!isset($this->empresa['id'])) {

            $empresa = Empresa::create($this->empresa);
            if ($this->image) {
                $image = Storage::disk('public')->put('galery', $this->image);
                $empresa->image()->create([
                    'url' => $image
                ]);
            }
            $this->emit('alert', 'Registro creado satisfactoriamente');
        } else {
            $empresa = Empresa::find($this->empresa['id']);
            $empresa->update(Arr::except($this->empresa, 'image'));
            if ($this->image) {
                $image = Storage::disk('public')->put('galery', $this->image);
                if ($empresa->image) {
                    Storage::disk('public')->delete('galery', $empresa->image->url);
                    $empresa->image()->update([
                        'url' => $image
                    ]);
                } else {
                    $empresa->image()->create([
                        'url' => $image
                    ]);
                };
            };
            $this->emit('alert', 'Registro actualizado satisfactoriamente');
        }

        $this->reset(['isOpen', 'empresa', 'image']);
        $this->emitTo('SisCrudEmpresa', 'render');
    }

    public function edit($empresa)
    {
        $this->reset('image');
        $this->empresa = array_slice($empresa, 0, 8);
        $this->isOpen = true;
        $this->ruteCreate = false;
    }

    public function delete($id)
    {
        Empresa::find($id)->delete();
    }

}
