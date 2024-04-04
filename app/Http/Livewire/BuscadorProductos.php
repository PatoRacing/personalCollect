<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Producto;
use Livewire\Component;

class BuscadorProductos extends Component
{
    public $nombre;
    public $cliente_id;

    public function busquedaProducto()
    {
        $this->emit('terminosDeBusquedaProductos', $this->nombre, $this->cliente_id);
    }

    public function render()
    {
        $clientes = Cliente::all();
        return view('livewire.buscador-productos',[
            'clientes'=>$clientes
        ]);
    }
}
