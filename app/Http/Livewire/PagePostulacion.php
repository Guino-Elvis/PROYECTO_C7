<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PagePostulacion extends Component
{
    public function render()
    {
        return view('pages.page-postulacion');
    }
     // public function obtenerDetallesOferta(Request $request)
    // {
    //     $idDeseado = $request->input('id');
    //     $detalles = OfertaLaboral::findOrFail($idDeseado);
    //     return view('pages.detalles-oferta', compact('detalles'));
    // }
}
