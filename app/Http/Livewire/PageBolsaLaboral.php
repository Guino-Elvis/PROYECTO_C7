<?php

namespace App\Http\Livewire;

use App\Models\OfertaLaboral;
use Livewire\Component;
use Illuminate\Http\Request;
class PageBolsaLaboral extends Component
{
    public function render(Request $request)
{
    // Obtener el ID deseado si se proporciona en la solicitud
    $idDeseado = $request->input('id');

    // Obtener todas las ofertas laborales
    $ofertas = OfertaLaboral::where('state', 2)->paginate();

    // Inicializar $detalles como null si no se proporciona un ID específico
    $detalles =OfertaLaboral::where('state', 2)->first();

    // Si se proporciona un ID específico, cargar los detalles de esa oferta
    if ($idDeseado) {
        $detalles = OfertaLaboral::findOrFail($idDeseado);
    }

    return view('pages.page-bolsa-laboral', compact('ofertas', 'detalles'));
}


}
