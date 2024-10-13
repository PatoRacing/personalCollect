<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Politica;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class Productos extends Component
{
    use WithPagination;

    public $nombre;
    public $cliente_id;
    public $modalEstado = false;
    public $modalEliminar = false;
    public $productoSeleccionado;
    public $alertaMensaje;
    public $alertaTipo;
    protected $listeners = ['terminosDeBusquedaProductos'=>'buscarProducto'];

    //Función mostrar modal cambiar estado
    public function mostrarModalEstado($productoId)
    {
        $this->productoSeleccionado=Producto::find($productoId);
        $this->modalEstado = true;
    }

    //Función cambiar estado
    public function confirmarCambiarEstado()
    {
        if($this->productoSeleccionado->estado == 1)
        {
            $this->productoSeleccionado->estado = 2;
        } else {
            $this->productoSeleccionado->estado = 1;
        }
        $this->productoSeleccionado->usuario_ultima_modificacion_id = auth()->id();
        $this->productoSeleccionado->save();
        $this->modalEstado = false;
        $this->alertaMensaje = 'Producto actualizado correctamente';
        $this->alertaTipo = 'green';
    }

    //Funcion cerrar modal estado
    public function cerrarModalEstado()
    {
        $this->modalEstado = false;
    }

    //Función mostrar modal eliminar producto
    public function mostrarModalEliminar($productoId)
    {
        $this->productoSeleccionado=Producto::find($productoId);
        $this->modalEliminar = true;
    }

    //Función eliminar producto
    public function confirmarEliminarUsuario()
    {
        $this->productoSeleccionado->delete();
        $this->modalEliminar = false;
        $this->alertaMensaje = 'Producto eliminado correctamente';
        $this->alertaTipo = 'red';
    }

    //Funcion cerrar modal eliminar
    public function cerrarModalEliminar()
    {
        $this->modalEliminar = false;
    }

    //Funcion para terminos de busqueda
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
        ->orderBy('created_at', 'desc')->paginate(30);

        return view('livewire.productos.productos',[
            'productos'=>$productos
        ]);
    }
}
