<?php

namespace App\Http\Livewire\Gestiones\Cancelacion\Vigente;

use Livewire\Component;

class CancelacionAdministradorVigenteSinGestionesDePago extends Component
{
    public $cuota;

    protected $listeners = ['nuevaGestionDePagoIngresadaAdministradorCancelacion'=>'guardarNuevaGestionDePago'];

    public function guardarNuevaGestionDePago()
    {
        dd('es una nueva gestion de cancelacion');
    }
    
    public function render()
    {
        return view('livewire.gestiones.cancelacion.vigente.cancelacion-administrador-vigente-sin-gestiones-de-pago');
    }
}
