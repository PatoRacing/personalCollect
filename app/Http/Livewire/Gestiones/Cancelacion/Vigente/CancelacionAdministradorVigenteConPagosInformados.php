<?php

namespace App\Http\Livewire\Gestiones\Cancelacion\Vigente;

use Livewire\Component;

class CancelacionAdministradorVigenteConPagosInformados extends Component
{
    public $cuota;
    
    public function render()
    {
        return view('livewire.gestiones.cancelacion.vigente.cancelacion-administrador-vigente-con-pagos-informados');
    }
}
