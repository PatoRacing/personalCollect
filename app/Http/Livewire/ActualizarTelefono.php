<?php

namespace App\Http\Livewire;

use App\Models\Telefono;
use Livewire\Component;

class ActualizarTelefono extends Component
{
    public $deudorId;
    public $telefono;
    public $telefono_id;
    public $tipo;
    public $contacto;
    public $numero;
    public $email;
    public $estado;
    public $mostrarModal;


    public function mount(Telefono $telefono)
    {
        $this->telefono_id = $telefono->id;
        $this->tipo = $telefono->tipo;
        $this->contacto = $telefono->contacto;
        $this->numero = $telefono->numero;
        $this->email = $telefono->email;
        $this->estado = $telefono->estado;
    }

    public function modalActualizarTelefono()
    {
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->resetValidation(); 
        $this->reset([ 
            'tipo',
            'contacto',
            'numero',
            'email',
            'estado'
        ]);
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

        $telefono = Telefono::find($this->telefono_id);
        $telefono->tipo = $datos['tipo'];
        $telefono->contacto = $datos['contacto'];
        $telefono->numero = $datos['numero'];
        $telefono->email = $datos['email'];
        $telefono->estado = $datos['estado'];
        $telefono->usuario_ultima_modificacion_id = auth()->id();
        $telefono->save();

        return redirect()->route('deudor.perfil', ['deudor' => $telefono->deudor_id])->with('message', 'Contacto actualizado correctamente');
    }


    public function render()
    {
        return view('livewire.actualizar-telefono');
    }
}
