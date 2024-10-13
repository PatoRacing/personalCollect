<?php

namespace App\Http\Livewire;

use App\Models\Politica;
use Livewire\Component;

class Politicas extends Component
{
    public $politica;
    public $modalEstado = false;
    public $modalEliminar = false;
    public $politicaSeleccionada;
    public $alertaMensaje;
    public $alertaTipo;

    //Función mostrar modal cambiar estado
    public function mostrarModalEstado($politicaId)
    {
        $this->politicaSeleccionada=Politica::find($politicaId);
        $this->modalEstado = true;
    }

    //Función cambiar estado
    public function confirmarCambiarEstado()
    {
        if($this->politicaSeleccionada->estado == 1)
        {
            $this->politicaSeleccionada->estado = 2;
        } else {
            $this->politicaSeleccionada->estado = 1;
        }
        $this->politicaSeleccionada->usuario_ultima_modificacion_id = auth()->id();
        $this->politicaSeleccionada->save();
        $this->modalEstado = false;
        return redirect()->to(route('perfil.producto',['producto'=>$this->politicaSeleccionada->producto_id]))
                        ->with('message', 'Politica actualizada correctamente');
    }

    //Funcion cerrar modal estado
    public function cerrarModalEstado()
    {
        $this->modalEstado = false;
    }

    //Función mostrar modal eliminar cliente
    public function mostrarModalEliminar($politicaId)
    {
        $this->politicaSeleccionada=Politica::find($politicaId);
        $this->modalEliminar = true;
    }

    //Función eliminar politica
    public function confirmarEliminarPolitica()
    {
        $this->politicaSeleccionada->delete();
        $this->modalEliminar = false;
        return redirect()->to(route('perfil.producto',['producto'=>$this->politicaSeleccionada->producto_id]))
                        ->with('message', 'Politica eliminada correctamente');
    }

    //Funcion cerrar modal eliminar
    public function cerrarModalEliminar()
    {
        $this->modalEliminar = false;
    }

    public function render()
    {
        return view('livewire.productos.politicas', []);
    }
}
