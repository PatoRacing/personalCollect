<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BuscarPagosVigentes extends Component
{
    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;
    public $estado;

    public function recargarBusqueda()
    {
        $this->reset(['deudor', 'nro_doc', 'responsable', 'nro_operacion', 'mes', 'estado']);
        $this->emit('recargarPagina');
    }

    public function terminosBusquedaPagosVigentes()
    {
        $this->emit('busquedaPagosVigentes', $this->deudor, $this->nro_doc, $this->responsable, $this->nro_operacion, $this->mes, $this->estado);
    }

    public function render()
    {
        $responsables=User::all();

        return view('livewire.buscar-pagos-vigentes',[
            'responsables'=>$responsables
        ]);
    }
}
