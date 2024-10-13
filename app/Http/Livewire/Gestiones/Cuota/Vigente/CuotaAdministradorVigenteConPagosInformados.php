<?php

namespace App\Http\Livewire\Gestiones\Cuota\Vigente;

use App\Models\GestionCuota;
use Livewire\Component;

class CuotaAdministradorVigenteConPagosInformados extends Component
{
    public $cuota;
    
    public function render()
    {
        $pagosDeCuota = GestionCuota::where('pago_id', $this->cuota->id)   
                                    ->orderBy('created_at', 'desc') 
                                    ->get();
        return view('livewire.gestiones.cuota.vigente.cuota-administrador-vigente-con-pagos-informados',[
            'pagosDeCuota'=>$pagosDeCuota
        ]);
    }
}
