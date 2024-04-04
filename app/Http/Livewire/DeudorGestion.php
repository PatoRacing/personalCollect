<?php

namespace App\Http\Livewire;

use App\Models\GestionesDeudores;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeudorGestion extends Component
{
    public $deudor;
    public $accion;
    public $resultado;
    public $usuarioNombre;
    public $observaciones;

    protected $rules = [
        'accion'=> 'required',
        'resultado'=> 'required',
        'observaciones'=> 'required|max:255',
    ];

    public function deudorGestion()
    {
        $datos = $this->validate();

        $deudorId = $this->deudor['id'];

        $gestion = GestionesDeudores::create([
            'deudor_id'=> $deudorId,
            'accion'=>$datos['accion'],
            'resultado'=>$datos['resultado'],
            'observaciones'=>$datos['observaciones'],
            'usuario_ultima_modificacion_id'=>auth()->id(),
            ]);
        
            return redirect()->route('deudor.perfil', ['deudor' => $gestion->deudor_id])
                ->with('message', 'Gestión agregada correctamente');
    }

    public function render()
    {
        $usuario = Auth::user();
        $this->usuarioNombre = $usuario->name . " " . $usuario->apellido;
        return view('livewire.deudor-gestion');
    }
}
