<?php

namespace App\Http\Livewire\Gestiones\Cuota\Vigente;

use App\Models\GestionCuota;
use Livewire\Component;

class CuotaAdministradorVigente extends Component
{
    public $cuota;
    public $cuotaVigenteSinGestionesDePago = false;
    public $cuotaVigenteConPagosInformados = false;

    //Escucha el evento y llama a gestionarSobranteDeCuota
    protected $listeners = ['enviarSobranteDeCuota'=>'gestionarSobranteDeCuota'];

    public function gestionarSobranteDeCuota($sobranteDeCuota)
    {
        dd('desde gestionar sobrante '. $sobranteDeCuota);
    }
    
    public function render()
    {
        //Obtengo todas las gestiones de pago de un anticipo/cuota/csp que esten vigentes
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

        return view('livewire.gestiones.cuota.vigente.cuota-administrador-vigente');
    }
}
