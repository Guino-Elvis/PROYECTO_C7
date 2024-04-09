<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class SisCrudEmpresa extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $isOpen = false;
    public $ruteCreate = false;
    public  $amount = 5;
    public $search, $empresa, $image;
    protected $listeners = ['render', 'delete' => 'delete'];

    protected $rules = [
        'empresa.ra_social' => 'required',
        'empresa.ruc' => 'required',
        'empresa.direccion' => 'required',
        'empresa.telefono' => 'required',
        'empresa.correo' => 'required',
        // 'empresa.user_id' => 'required'
    ];

    public function render()
    {
        $empresas = Empresa::query()
            ->with('user.roles')
            ->where(function ($query) {
                $query->where('ra_social', 'like', '%' . $this->search . '%')
                    ->orWhere('ruc', 'like', '%' . $this->search . '%')
                    ->orWhere('correo', 'like', '%' . $this->search . '%');
            })


            ->latest('id')
            ->paginate($this->amount);

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
        $empresaData = $this->empresa;

        if (!isset($empresaData['id'])) {
            $empresaData['user_id'] = auth()->id();
            $empresa = Empresa::create($empresaData);
            if ($this->image) {
                $image = Storage::disk('public')->put('galery', $this->image);
                $empresa->image()->create([
                    'url' => $image
                ]);
            }
            $this->emit('alert', 'Registro creado satisfactoriamente');
        } else {

            $empresa = Empresa::find($empresaData['id']);
            // Si no tiene un ID de usuario, asigna el ID del usuario actual
            $empresaData['user_id'] = $empresa->user_id ?? auth()->id();
            $empresa->update(Arr::except($empresaData, 'image'));
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

    public function destroy(string $id)
    {
        try {
            $empresas = Empresa::findOrFail($id);
            $empresas->delete();

            return redirect()
                ->back()
                ->with('success', '¡item eliminado !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el item de la lista ');
        }
    }


    public function createPDF()
    {
        $total = Empresa::count();

        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $empresas = Empresa::all();
        $pdf = FacadePdf::loadView('reports/pdf_empresa', compact('empresas', 'total', 'date', 'hour'));
        $pdf->setPaper('a4', 'landscape');
        //return $pdf->download('pdf_file.pdf');    //desacarga automaticamente
        return $pdf->stream('reports/pdf_empresa'); //abre en una pestaña como pdf
    }

    public function createCSV()
    {

        $data = DB::table('empresas')->select('id', 'ra_social', 'ruc', 'direccion', 'telefono', 'correo', 'created_at', 'updated_at')->get();


        $filename = 'reporte_empresas.csv';
        $filePath = storage_path('app/' . $filename);

        $file = fopen($filePath, 'w');
        fputcsv($file, ['ID', 'RAZON SOCIAL', 'RUC', 'DIRECCION', 'TELEFONO','CORREO', 'Creacion', 'Actualizado']);
        foreach ($data as $item) {
            fputcsv($file, [$item->id, $item->ra_social, $item->ruc, $item->direccion, $item->telefono,$item->correo, $item->created_at, $item->updated_at]);
        }

        fclose($file);
        return response()->download($filePath, $filename)->deleteFileAfterSend();
    }

    public function createEXCEL()
    {

        $data = DB::table('empresas')->select('id', 'ra_social', 'ruc', 'direccion', 'telefono', 'correo', 'created_at', 'updated_at')->get()->toArray();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer los encabezados de las columnas
        $encabezados = ['ID', 'RAZON SOCIAL', 'RUC', 'DIRECCION', 'TELEFONO', 'CORREO', 'Creacion', 'Actualizado'];
        foreach ($encabezados as $key => $encabezado) {
            $columna = chr(65 + $key); // Convertir el índice en letra de columna (A, B, C, ...)
            $celda = $columna . '1'; // Construir la referencia de celda (por ejemplo, A1, B1, C1, ...)
            $sheet->setCellValue($celda, $encabezado); // Establecer el valor del encabezado
        }

        // Aplicar estilo al encabezado
        $headerStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF426EBE',
                ],
            ],
            'font' => [
                'color' => [
                    'argb' => Color::COLOR_WHITE,
                ],
                'bold' => true, // Hacer que el texto esté en negrita
            ],
        ];

        // Aplicar el estilo al encabezado
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Aplicar formato y color a los datos
        $dataStyle1 = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFE6E6FA', // Celeste
                ],
            ],
        ];

        $dataStyle2 = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_WHITE,
                ],
            ],
        ];

        $row = 2;
        foreach ($data as $empresa) {
            $style = ($row % 2 == 0) ? $dataStyle1 : $dataStyle2;
            $sheet->fromArray((array)$empresa, null, 'A' . $row); // Escribir los datos en la fila actual
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray($style); // Aplicar el estilo a la fila actual
            $row++;
        }

        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Crear un objeto Writer y guardar el archivo
        $writer = new Xlsx($spreadsheet);
        $filename = 'reporte_empresas.xlsx';
        $filePath = storage_path('app/' . $filename);
        $writer->save($filePath);

        // Devolver el archivo como respuesta
        return response()->download($filePath, $filename)->deleteFileAfterSend();
    }

}