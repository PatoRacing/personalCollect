<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use App\Models\Operacion;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OperacionesCliente extends Component
{
    use WithPagination;
    
    public $cliente;
    public $modalAsignar = false;
    public $operacionSeleccionada;
    public $usuarios;
    public $usuario_asignado_id;
    public $alertaMensaje;
    public $alertaTipo;
    public $nro_doc;
    public $nro_operacion;
    public $deudor;
    public $situacion;
    protected $listeners = ['terminosDeBusqueda'=>'buscarOperacion'];

    public function mostrarModalAsignar($operacionClienteId)
    {
        $this->operacionSeleccionada=Operacion::find($operacionClienteId);
        $this->modalAsignar = true;
        $this->usuarios = User::all();
    }

    public function asignarOperacion($operacionClienteId)
    {
        $this->validate([
            'usuario_asignado_id'=> 'required'
        ]);
        $operacionCliente = Operacion::find($operacionClienteId);
        $operacionCliente->usuario_asignado_id = $this->usuario_asignado_id;
        $operacionCliente->usuario_ultima_modificacion_id = auth()->id();
        $operacionCliente->save();
        $this->modalAsignar = false; 
        $this->usuario_asignado_id = null; 
        $this->alertaMensaje = 'Operación asignada correctamente';
        $this->alertaTipo = 'green';
    }

    public function cerrarModalAsignar()
    {
        $this->modalAsignar = false; 
        $this->usuario_asignado_id = null;
        $this->resetErrorBag(); 
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

        return view('livewire.clientes.operaciones-cliente',[
            'operacionesCliente'=>$operacionesCliente
        ]);
    }
}
