<?php

namespace App\Http\Livewire\Gestiones\Cuota\Vigente;

use App\Models\GestionCuota;
use Livewire\Component;

class CuotaAgenteVigenteSinGestionesDePago extends Component
{
    public $cuota;

    public function render()
    {
        return view('livewire.gestiones.cuota.vigente.cuota-agente-vigente-sin-gestiones-de-pago');
    }
}
