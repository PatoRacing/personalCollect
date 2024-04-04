<?php

namespace App\Http\Livewire;

use App\Models\GestionesDeudores;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeudorActualizarGestion extends Component
{
    public $gestionDeudor_id;
    public $gestionesDeudores;
    public $accion;
    public $resultado;
    public $observaciones;
    public $usuarioNombre;

    protected $rules = [
        'accion'=> 'required',
        'resultado'=> 'required',
        'observaciones'=> 'required|max:255'
    ];

    public function mount(GestionesDeudores $gestionesDeudores)
    {
        $this->gestionDeudor_id = $gestionesDeudores->id;
        $this->accion = $gestionesDeudores->accion;
        $this->resultado = $gestionesDeudores->resultado;
        $this->observaciones = $gestionesDeudores->observaciones;
    }

    public function deudorActualizarGestion()
    {
        $datos = $this->validate();
        $gestionDeudor = GestionesDeudores::find($this->gestionDeudor_id);
        $gestionDeudor->accion = $datos['accion'];
        $gestionDeudor->resultado = $datos['resultado'];
        $gestionDeudor->observaciones = $datos['observaciones'];
        $gestionDeudor->usuario_ultima_modificacion_id = auth()->id();

        $gestionDeudor->save();

        return redirect()->route('deudor.historial', ['deudor' => $gestionDeudor->deudor_id])->with('message', 'Gestión actualizada correctamente');
    }

    public function render()
    {
        $usuario = Auth::user();
        $this->usuarioNombre = $usuario->name . " " . $usuario->apellido;
        return view('livewire.deudor-actualizar-gestion');
    }
}
