<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use App\Models\Operacion;
use App\Models\User;
use Livewire\Component;

class OperacionesCliente extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;
    public $cliente;
    public $situacion;
    protected $listeners = ['terminosDeBusqueda'=>'buscarOperacion'];
    public $operacionCliente;
    public $asignarOperacion = false;
    public $usuarios;
    public $usuario_asignado_id;
    
    public function asignarOperacion($operacionClienteId)
    {
        $this->asignarOperacion = true; 
        $this->operacionCliente = Operacion::findOrFail($operacionClienteId); 
        $this->usuarios = User::all();
    }

    public function guardarUsuarioAsignado()
    {
        $this->validate([
            'usuario_asignado_id'=> 'required'
        ]);
        
        $operacionCliente = Operacion::findOrFail($this->operacionCliente->id);
        $operacionCliente->usuario_asignado_id = $this->usuario_asignado_id;
        $operacionCliente->usuario_ultima_modificacion_id = auth()->id();
        $operacionCliente->save();
        $this->asignarOperacion = false; 
        $this->emit('operacionAsignada');
    }

    public function cancelarAsignacion()
    {
        $this->asignarOperacion = false; 
    }

    public function buscarOperacion($nro_doc, $nro_operacion, $deudor, $situacion)
    {
        $this->nro_doc = $nro_doc;
        $this->nro_operacion = $nro_operacion;
        $this->deudor = $deudor;
        $this->situacion = $situacion;
    }
    
    public function render()
    {
        //Busqueda por nro_doc
        $operacionesCliente = Operacion::when($this->nro_doc, function($query){
            $query->where('nro_doc', $this->nro_doc);

        //Busqueda por nro operacion
        })->when($this->nro_operacion, function($query){
            $query->where('operacion', $this->nro_operacion);

        //Busqueda por deudor
        })->when($this->deudor, function($query) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                ->pluck('id')
                ->first();
            $query->where('deudor_id', $deudorId);

        //Busqueda por situacion
        })->when($this->situacion, function($query){
            if ($this->situacion == 100) {
                $query->where('usuario_asignado_id', 100);
            } else {
                $query->where('usuario_asignado_id', '!=', 100);
            }

        //Vista principal
        })->where('cliente_id', $this->cliente->id)
        ->paginate(30);

        return view('livewire.operaciones-cliente',[
            'operacionesCliente'=>$operacionesCliente,
            'usuarios'=>$this->usuarios
        ]);
    }
}
