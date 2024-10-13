<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use Livewire\Component;

class BuscarCartera extends Component
{
    public $deudor;
    public $nro_doc;
    public $agente;
    public $nro_operacion;
    public $producto;
    public $situacion;

    public function leerTerminoBusquedaCartera()
    {
        $this->emit('terminosDeBusquedaCartera',
            $this->deudor,
            $this->nro_doc,
            $this->agente,
            $this->nro_operacion,
            $this->producto,
            $this->situacion);
    }

    public function recargarBusqueda()
    {
        $this->reset(['deudor', 'nro_doc', 'agente', 'nro_operacion', 'producto', 'situacion']);
    }

    public function render()
    {
        $productos=Producto::all();
        $agentes=User::all();

        return view('livewire.operaciones.buscar-cartera',[
            'productos'=>$productos,
            'agentes'=>$agentes,
        ]);
    }
}
