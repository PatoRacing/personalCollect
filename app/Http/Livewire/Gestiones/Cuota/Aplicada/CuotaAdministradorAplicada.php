<?php

namespace App\Http\Livewire\Gestiones\Cuota\Aplicada;

use Livewire\Component;

class CuotaAdministradorAplicada extends Component
{
    public $cuota;
    
    public function render()
    {
        return view('livewire.gestiones.cuota.aplicada.cuota-administrador-aplicada');
    }
}
