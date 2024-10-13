<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class BuscarCuotasVigentes extends Component
{
    public $deudor;
    public $nro_doc;
    public $tipo_acuerdo;
    public $responsable;
    public $nro_operacion;
    public $mes;

    public function recargarBusqueda()
    {
        $this->reset(['deudor', 'nro_doc', 'tipo_acuerdo', 'responsable', 'nro_operacion', 'mes']);
    }

    public function terminosBusquedaCuotasVigentes()
    {
        $this->emit('busquedaCuotasVigentes', $this->deudor, $this->nro_doc, $this->tipo_acuerdo, $this->responsable, $this->nro_operacion, $this->mes);
    }

    public function render()
    {
        $responsables=User::all();

        return view('livewire.pagos.buscar-cuotas-vigentes',[
            'responsables'=>$responsables
        ]);
    }
}
