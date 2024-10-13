<?php

namespace App\Http\Livewire\Gestiones\Cancelacion\Vigente;

use App\Models\GestionCuota;
use Livewire\Component;

class CancelacionAdministradorVigente extends Component
{
    public $cuota;
    public $cancelacionVigenteSinGestionesDePago = false;
    public $cancelacionVigenteConPagosInformados = false;

    public function render()
    {
        $gestionesDeCuota = GestionCuota::where('pago_id', $this->cuota->id)->get();

        //La cancelacion no tiene gestiones
        if($gestionesDeCuota->isEmpty())
        {
            $this->cancelacionVigenteSinGestionesDePago = true;
        }
        //La cancelacion tiene gestiones
        else
        {
            $this->cancelacionVigenteConPagosInformados = true;
        }

        return view('livewire.gestiones.cancelacion.vigente.cancelacion-administrador-vigente');
    }
}
