<?php

namespace App\Http\Livewire\Gestiones\Cuota\RendidaParcial;

use Livewire\Component;

class CuotaAdministradorRendidaParcial extends Component
{
    public $cuota;
    
    public function render()
    {
        return view('livewire.gestiones.cuota.rendida-parcial.cuota-administrador-rendida-parcial');
    }
}
