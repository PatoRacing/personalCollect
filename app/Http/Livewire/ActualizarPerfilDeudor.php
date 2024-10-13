<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use Livewire\Component;

class ActualizarPerfilDeudor extends Component
{
    public $deudor;
    public $deudorId;
    public $nombre;
    public $tipo_doc;
    public $nro_doc;
    public $cuil;
    public $domicilio;
    public $localidad;
    public $codigo_postal;

    protected $rules = [
        'nombre'=> 'required',
        'tipo_doc'=> 'nullable',
        'nro_doc'=> 'required',
        'cuil'=> 'nullable',
        'domicilio'=> 'required',
        'localidad'=> 'required',
        'codigo_postal'=> 'required'
    ];


    public function mount(Deudor $deudor)
    {
        $this->nombre = $deudor->nombre;
        $this->tipo_doc = $deudor->tipo_doc;
        $this->nro_doc = $deudor->nro_doc;
        $this->cuil = $deudor->cuil;
        $this->domicilio = $deudor->domicilio;
        $this->localidad = $deudor->localidad;
        $this->codigo_postal = $deudor->codigo_postal;
    }

    public function actualizarPerfilDeudor()
    {
        $datos = $this->validate();
        //deudor a editar
        $deudorId = $this->deudor->id;
        $deudor = Deudor::find($deudorId);
        //Asignar los valores
        $deudor->nombre = $datos['nombre'];
        $deudor->tipo_doc = $datos['tipo_doc'] ?? $deudor->tipo_doc = null;
        $deudor->nro_doc = $datos['nro_doc'];
        $deudor->cuil = $datos['cuil'] ?? $deudor->cuil = null;
        $deudor->domicilio = $datos['domicilio'];
        $deudor->localidad = $datos['localidad'];
        $deudor->codigo_postal = $datos['codigo_postal'];
        $deudor->usuario_ultima_modificacion_id = auth()->id();
        $deudor->updated_at = now();
        $deudor->save();
        return redirect()->route('deudor.perfil', ['deudor' => $deudor->id])->with('message', 'Perfil actualizado correctamente');;
    }

    public function render()
    {
        return view('livewire.operaciones.actualizar-perfil-deudor');
    }
}
