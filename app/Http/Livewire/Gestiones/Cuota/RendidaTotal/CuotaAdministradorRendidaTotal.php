<?php

namespace App\Http\Livewire\Gestiones\Cuota\RendidaTotal;

use Livewire\Component;

class CuotaAdministradorRendidaTotal extends Component
{
    public $cuota;
    
    public function render()
    {
        return view('livewire.gestiones.cuota.rendida-total.cuota-administrador-rendida-total');
    }
}
