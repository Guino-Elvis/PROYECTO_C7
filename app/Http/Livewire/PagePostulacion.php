<?php
namespace App\Http\Livewire;

use App\Models\Application;
use App\Models\OfertaLaboral;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PagePostulacion extends Component
{
    public $detalles;

    public function mount($id)
    {
        $this->detalles = OfertaLaboral::findOrFail($id);

        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            //$this->mostrarModal('¡Producto agregado al carrito exitosamente!');
            $this->emit('mostrarModal', '¡Para continuar, necesitas Iniciar Sesión!');
            return redirect('/login');
        }
        // Verificar si el correo electrónico del usuario está verificado
        if (Auth::user()->email_verified_at == null) {
            $this->emit('mostrarModalGmail', '¡Para continuar, necesitas verificar tu dirección de correo electrónico!');
            return redirect('/verify-email');
        }

        // Establecer la variable en la sesión
        session(['postulacionIniciado' => true]);
        // Emitir el evento para redirigir
        $this->emit('redirectToPostulacion',$this->detalles->id);
    }

    public function render()
    {
        // Aquí puedes devolver la vista correspondiente
        return view('pages.page-postulacion');
    }

    public function save(Request $request){
        // Validar el formulario
        $request->validate([
            // Otros campos de validación si es necesario
            'documentos' => 'required|mimes:pdf,doc,docx,txt|max:2048', // Permitir PDF, Word, TXT, tamaño máximo de 2MB
        ]);

        // Verificar si la carpeta de documentos existe
        if (!Storage::disk('public')->exists('documentos')) {
            // Si la carpeta no existe, intentar crearla
            if (!Storage::disk('public')->makeDirectory('documentos')) {
                // Si no se pudo crear la carpeta, mostrar un mensaje de error y redirigir
                return back()->with('error', 'No se pudo crear la carpeta para los documentos.');
            }
        }

        $documentos = $request->file('documentos');

        $documentosPath = $documentos->store('documentos', 'public');

        $postular = new Application();
        $postular->status = 'PE';
        $postular->fecha_postulacion = $request->fecha_postulacion;
        $postular->documentos = $documentosPath;
        $postular->oferta_laboral_id = $request->oferta_laboral_id;
        $postular->user_id = $request->user_id;
        $postular->save();
        return redirect()->route('inicio');
    }

    public function redirectToPostulacion($id)
    {
        return redirect()->route('postulacion', ['id' => $id]);
    }
}
