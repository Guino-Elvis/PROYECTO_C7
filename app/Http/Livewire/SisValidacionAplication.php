<?php

namespace App\Http\Livewire;

use App\Models\Application;
use Livewire\Component;
use Illuminate\Http\Request;
class SisValidacionAplication extends Component
{


    public function render($id)

    {
        $aplicationdetail = Application::findOrFail($id);
        $details = $aplicationdetail->postulante()->paginate(6);

        // Utiliza la propiedad $isOpen en lugar de definir una variable local $isOpen
        return view('admin.pages.sis-crud-aplication-show', compact('aplicationdetail', 'details'));
    }

        //edicion de formularios
        public function editar_aplication($aplicationId)
        {
            // Obtén el aplication existente para editar
            $aplication = Application::find($aplicationId);

            // Verifica si el aplication existe
            if ($aplication) {
                return view('admin.modals.aplication', compact('aplication'));
            } else {
                // Redirige con un mensaje de error si el aplication no se encuentra
                return redirect()->back()->with('mensaje', 'Error al editar el aplication. aplication no encontrado.');
            }
        }


        public function guardar_edicion_aplication(Request $request, $aplicationId)
        {
            // Obtén el aplication existente para editar
            $aplication = Application::find($aplicationId);

            // Verifica si el aplication existe
            if ($aplication) {
                // Actualiza los campos del aplication con los valores del formulario
                $aplication->status = $request->get('status');
                $aplication->save();

                return redirect()->route('registro-de-postulaciones.show', ['id' => $aplicationId])->with('mensaje', 'aplication editado exitosamente.');
            } else {
                // Redirige con un mensaje de error si el aplication no se encuentra
                return redirect()->back()->with('mensaje', 'Error al editar el aplication. aplication no encontrado.');
            }
        }
}
