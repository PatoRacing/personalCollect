<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Politica;
use App\Models\Producto;
use Livewire\Component;

class Productos extends Component
{
    public $nombre;
    public $cliente_id;
    protected $listeners = ['terminosDeBusquedaProductos'=>'buscarProducto'];
    public $productoId;
    public $confirmaEliminacionProducto;
    public $productoConPoliticas;

    public function estadoProducto(Producto $producto)
    {
        if($producto->estado === 1)
        {
            $producto->estado = 2;
            $producto->usuario_ultima_modificacion_id =  auth()->id();

        } else {
            $producto->estado = 1;
            $producto->usuario_ultima_modificacion_id =  auth()->id();
        }
        
        $producto->save();
        $this->emit('estadoActualizado');
    }

    public function eliminarProducto($productoId)
    {
        $this->productoId = $productoId;
        $politicas = Politica::where('producto_id', $productoId)->get();
        if($politicas->isEmpty()) {
            $this->confirmaEliminacionProducto = true;
        } else {
            $this->productoConPoliticas = true;
        }
    }

    public function confirmaEliminacionProducto()
    {
        dd($this->productoId);
        Producto::find($this->productoId)->delete();
        $this->confirmaEliminacionProducto = false;
        return redirect('productos')->with('message', 'Producto eliminado correctamente');
    }

    public function cancelarEliminacionProducto()
    {
        $this->confirmaEliminacionProducto = false;
        $this->productoConPoliticas = false;
    }

    public function buscarProducto($nombre, $cliente_id)
    {
        $this->nombre = $nombre;
        $this->cliente_id = $cliente_id;
    }

    public function render()
    {
        //Busqueda por nombre
        $productos=Producto::when($this->nombre, function($query){
            $query->where('nombre', 'LIKE', "%" . $this->nombre . "%");
        
        //Busqueda por cliente
        })->when($this->cliente_id, function($query) {
            $clienteId = Cliente::where('id', $this->cliente_id)
                ->pluck('id')
                ->first();
            $query->where('cliente_id', $clienteId);

        //Vista General
        })
        ->orderBy('created_at', 'desc')->paginate(24);

        return view('livewire.productos',[
            'productos'=>$productos
        ]);
    }
}
