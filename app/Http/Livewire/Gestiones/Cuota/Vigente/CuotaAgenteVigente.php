<?php

namespace App\Http\Livewire\Gestiones\Cuota\Vigente;

use App\Models\GestionCuota;
use Livewire\Component;

class CuotaAgenteVigente extends Component
{
    public $cuota;
    public $cuotaVigenteSinGestionesDePago = false;
    public $cuotaVigenteConPagosInformados = false;
    
    public function render()
    {
        $gestionesDeCuota = GestionCuota::where('pago_id', $this->cuota->id)->get();
        //El anticipo/cuota/csp no tiene gestiones
        if($gestionesDeCuota->isEmpty())
        {
            $this->cuotaVigenteSinGestionesDePago = true;
        }
        //El anticipo/cuota/csp tiene gestiones
        else
        {
            $this->cuotaVigenteConPagosInformados = true;
        }
        return view('livewire.gestiones.cuota.vigente.cuota-agente-vigente');
    }
}
