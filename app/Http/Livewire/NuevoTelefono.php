<?php

namespace App\Http\Livewire;

use App\Models\Telefono;
use Livewire\Component;

class NuevoTelefono extends Component
{
    public $deudorId;
    public $deudor;
    public $tipo;
    public $contacto;
    public $numero;
    public $email;
    public $estado;
    public $modalNuevoTelefono;

     
    
    public function modalNuevoTelefono()
    {
        $this->modalNuevoTelefono = true;
    }

    public function cerrarModalNuevoTelefono()
    {
        $deudorId = $this->deudorId;
        return redirect()->route('deudor.perfil', ['deudor' => $deudorId]);
    }

    protected $rules = [
        'tipo' => 'required|max:255',
        'contacto' => 'required|max:255',
        'numero' => 'required_without_all:email|max:255',
        'email' => 'required_without_all:numero|max:255',
        'estado' => 'required|max:255',
    ];

    public function nuevoTelefono()
    {
        $this->validate([
            'tipo' => 'required|max:255',
            'contacto' => 'required|max:255',
            'numero' => 'required_without_all:email|max:255',
            'email' => 'required_without_all:numero|max:255',
            'estado' => 'required|max:255',
        ]);

        $deudorId = $this->deudorId;

        $telefono = Telefono::create([
            'deudor_id'=> $deudorId,
            'tipo'=>$this->tipo,
            'contacto'=>$this->contacto,
            'numero'=>$this->numero,
            'email'=>$this->email,
            'estado'=>$this->estado,
            'usuario_ultima_modificacion_id'=>auth()->id(),
        ]);
        
        session()->flash('message', 'Contacto agregado correctamente');

        $this->reset([
            'tipo',
            'contacto',
            'numero',
            'email',
            'estado'
        ]);

        return redirect()->route('deudor.perfil', ['deudor' => $deudorId]);
    }


    public function render()
    {
        return view('livewire.nuevo-telefono');
    }
}
