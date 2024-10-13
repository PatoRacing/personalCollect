<?php

namespace App\Http\Livewire\Gestiones\Cuota\Vigente;

use App\Models\GestionCuota;
use Livewire\Component;

class CuotaAgenteVigenteConPagosInformados extends Component
{
    public $cuota;

    public function render()
    {
        $pagosDeCuota = GestionCuota::where('pago_id', $this->cuota->id)->get();
        return view('livewire.gestiones.cuota.vigente.cuota-agente-vigente-con-pagos-informados',[
            'pagosDeCuota'=>$pagosDeCuota
        ]);
    }
}
