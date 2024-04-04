<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

class CrearCliente extends Component
{
    public $nombre;
    public $contacto;
    public $telefono;
    public $email;
    public $domicilio;
    public $localidad;
    public $codigo_postal;
    public $provincia;

    protected $rules = [
        'nombre'=> 'required',
        'contacto'=> 'required',
        'telefono'=> 'required',
        'email'=> 'required',
        'domicilio'=> 'required',
        'localidad'=> 'required',
        'codigo_postal'=> 'required',
        'provincia'=> 'required',
    ];

    public function crearCliente()
    {
        $datos = $this->validate();

        Cliente::create([
        'nombre'=> $datos['nombre'],
        'contacto'=>$datos['contacto'],
        'telefono'=>$datos['telefono'],
        'email'=>$datos['email'],
        'domicilio'=>$datos['domicilio'],
        'localidad'=>$datos['localidad'],
        'codigo_postal'=>$datos['codigo_postal'],
        'provincia'=>$datos['provincia'],
        'estado'=> 1,
        'creado'=>now(),
        'usuario_ultima_modificacion_id'=>auth()->id(),
        'fecha_ultima_modificacion'=>now(),
        ]);
        
        session()->flash('successMessage', 'Cliente agregado correctamente');
        session()->flash('messageType', 'cliente');
        return redirect('clientes');
    }

    public function render()
    {
        return view('livewire.crear-cliente');
    }
}
