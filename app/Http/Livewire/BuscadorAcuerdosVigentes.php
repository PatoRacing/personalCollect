<?php

namespace App\Http\Livewire;

use App\Models\Producto;
use App\Models\User;
use Livewire\Component;

class BuscadorAcuerdosVigentes extends Component
{
    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;

    public function leerTerminoBusquedaAcuerdosVigentes()
    {
        $this->emit('terminosDeBusquedaAcuerdosVigentes',
            $this->deudor,
            $this->nro_doc,
            $this->responsable,
            $this->nro_operacion);
    }

    public function recargarBusqueda()
    {
        $this->reset(['deudor', 'nro_doc', 'responsable', 'nro_operacion']);
    }

    public function render()
    {
        $responsables=User::all();
        $productos=Producto::all();

        return view('livewire.acuerdos.buscador-acuerdos-vigentes',[
            'responsables'=>$responsables,
            'productos'=>$productos,
        ]);
    }
}
