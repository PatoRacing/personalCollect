<?php

namespace App\Http\Livewire\Gestiones\Cuota\Observada;

use Livewire\Component;

class CuotaAdministradorObservada extends Component
{
    public $cuota;
    
    public function render()
    {
        return view('livewire.gestiones.cuota.observada.cuota-administrador-observada');
    }
}
