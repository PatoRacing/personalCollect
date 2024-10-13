<?php

namespace App\Http\Livewire;

use App\Models\Telefono;
use Livewire\Component;

class TelefonosOperacion extends Component
{
    public $operacion;
    public $tipo;
    public $contacto;
    public $numero;
    public $email;
    public $estado;
    public $modalNuevoTelefono;
    public $modalEstado;
    public $modalEliminar;
    public $alertaMensaje;
    public $alertaTipo;
    public $telefonoSeleccionado;
    public $modalActualizarTelefono = false;
    public $telefonoId;

    protected $rules = [
        'tipo' => 'required|max:255',
        'contacto' => 'required|max:255',
        'numero' => 'required_without_all:email|max:255',
        'email' => 'required_without_all:numero|max:255',
        'estado' => 'required|max:255',
    ];

    public function modalNuevoTelefono()
    {
        $this->modalNuevoTelefono = true;
    }

    public function nuevoTelefono()
    {
        $this->validate([
            'tipo' => 'required|max:255',
            'contacto' => 'required|max:255',
            'numero' => 'required_without_all:email|max:255',
            'email' => 'required_without_all:numero|max:255',
            'estado' => 'required|max:255',
        ]);
        $telefono = Telefono::create([
            'deudor_id'=>$this->operacion->deudor_id,
            'tipo'=>$this->tipo,
            'contacto'=>$this->contacto,
            'numero'=>$this->numero,
            'email'=>$this->email,
            'estado'=>$this->estado,
            'usuario_ultima_modificacion_id'=>auth()->id(),
        ]);
        $this->alertaMensaje = 'Teléfono generado correctamente';
        $this->alertaTipo = 'green';
        $this->reset(['tipo', 'contacto', 'numero', 'email', 'estado']);
        $this->modalNuevoTelefono = false;
    }

    public function cerrarModalNuevoTelefono()
    {
        $this->modalNuevoTelefono = false;
        $this->reset(['tipo', 'contacto', 'numero', 'email', 'estado']);
        $this->resetValidation();
    }

    public function cerrarModalActualizarTelefono()
    {
        $this->modalActualizarTelefono = false;
        $this->reset(['tipo', 'contacto', 'numero', 'email', 'estado']);
        $this->resetValidation();
    }

    public function mostrarModalActualizarTelefono($telefonoId)
    {
        $telefono = Telefono::find($telefonoId);
        $this->telefonoSeleccionado = $telefono;
        $this->tipo = $telefono->tipo;
        $this->contacto = $telefono->contacto;
        $this->numero = $telefono->numero;
        $this->email = $telefono->email;
        $this->estado = $telefono->estado;
        $this->modalActualizarTelefono = true;
    }

    public function actualizarTelefono()
    {
        $datos = $this->validate([
            'tipo' => 'required|max:255',
            'contacto' => 'required|max:255',
            'numero' => 'required_without_all:email|max:255',
            'email' => 'required_without_all:numero|max:255',
            'estado' => 'required|max:255',
        ]);
        $telefono = $this->telefonoSeleccionado;
        $telefono->tipo = $datos['tipo'];
        $telefono->contacto = $datos['contacto'];
        $telefono->numero = $datos['numero'] ?? null;
        $telefono->email = $datos['email'] ?? null;
        $telefono->estado = $datos['estado'];
        $telefono->usuario_ultima_modificacion_id=auth()->id();
        $telefono->save();
        $this->modalActualizarTelefono = false;
        $this->alertaMensaje = 'Información actualizada correctamente';
        $this->alertaTipo = 'green';
    }

    public function mostrarModalCambiarEstado($telefonoId)
    {
        $this->telefonoSeleccionado=Telefono::find($telefonoId);
        $this->modalEstado = true;
    }

    //Función cambiar estado
    public function confirmarCambiarEstado()
    {
        if($this->telefonoSeleccionado->estado == 1)
        {
            $this->telefonoSeleccionado->estado = 2;
        } else {
            $this->telefonoSeleccionado->estado = 1;
        }
        $this->telefonoSeleccionado->usuario_ultima_modificacion_id = auth()->id();
        $this->telefonoSeleccionado->save();
        $this->modalEstado = false;
        $this->alertaMensaje = 'Contacto actualizado correctamente';
        $this->alertaTipo = 'green';
    }

    //Funcion cerrar modal estado
    public function cerrarModalEstado()
    {
        $this->modalEstado = false;
    }

    //Función mostrar modal eliminar telefono
    public function mostrarModalEliminar($telefonoId)
    {
        $this->telefonoSeleccionado=Telefono::find($telefonoId);
        $this->modalEliminar = true;
    }

    //Función eliminar usuario
    public function confirmarEliminarTelefono()
    {
        $this->telefonoSeleccionado->delete();
        $this->modalEliminar = false;
        $this->alertaMensaje = 'Contacto eliminado correctamente';
        $this->alertaTipo = 'red';
    }

    //Funcion cerrar modal eliminar
    public function cerrarModalEliminar()
    {
        $this->modalEliminar = false;
    }

    public function render()
    {
        $deudorId = $this->operacion->deudor_id;
        $telefonos = Telefono::where('deudor_id', $deudorId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('livewire.operaciones.telefonos-operacion',[
            'telefonos'=>$telefonos
        ]);
    }
}
