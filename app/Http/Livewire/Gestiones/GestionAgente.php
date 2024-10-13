<?php

namespace App\Http\Livewire\Gestiones;
use App\Http\Livewire\Gestiones\GlobalGestiones;
use App\Models\GestionCuota;

class GestionAgente extends GlobalGestiones
{
    protected function procesarInformacionFormularioAgente($datosComunes)
    {
        $datosComunes['situacion'] = 1; // Pago informado
        $nuevoPagoInformado = new GestionCuota($datosComunes);
        $nuevoPagoInformado->save();  
    }
    
}



