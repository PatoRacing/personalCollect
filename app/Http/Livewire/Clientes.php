<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;

class Clientes extends Component
{
    public $modalEstado = false;
    public $modalEliminar = false;
    public $clienteSeleccionado;
    public $alertaMensaje;
    public $alertaTipo;

    //Función mostrar modal cambiar estado
    public function mostrarModalEstado($clienteId)
    {
        $this->clienteSeleccionado=Cliente::find($clienteId);
        $this->modalEstado = true;
    }

    //Función cambiar estado
    public function confirmarCambiarEstado()
    {
        if($this->clienteSeleccionado->estado == 1)
        {
            $this->clienteSeleccionado->estado = 2;
        } else {
            $this->clienteSeleccionado->estado = 1;
        }
        $this->clienteSeleccionado->usuario_ultima_modificacion_id = auth()->id();
        $this->clienteSeleccionado->save();
        $this->modalEstado = false;
        $this->alertaMensaje = 'Cliente actualizado correctamente';
        $this->alertaTipo = 'green';
    }

    //Funcion cerrar modal estado
    public function cerrarModalEstado()
    {
        $this->modalEstado = false;
    }

    //Función mostrar modal eliminar cliente
    public function mostrarModalEliminar($clienteId)
    {
        $this->clienteSeleccionado=Cliente::find($clienteId);
        $this->modalEliminar = true;
    }

    //Función eliminar usuario
    public function confirmarEliminarUsuario()
    {
        $this->clienteSeleccionado->delete();
        $this->modalEliminar = false;
        $this->alertaMensaje = 'Cliente eliminado correctamente';
        $this->alertaTipo = 'red';
    }

    //Funcion cerrar modal eliminar
    public function cerrarModalEliminar()
    {
        $this->modalEliminar = false;
    }

    public function render()
    {
        $clientes = Cliente::orderBy('creado', 'desc')->paginate(12);
        return view('livewire.clientes.clientes',[
            'clientes'=>$clientes
        ]);
    }
}
