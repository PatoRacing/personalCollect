<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Deudor;
use App\Models\Operacion;
use App\Models\Producto;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Operaciones extends Component
{
    use WithPagination;
    
    public $modalAsignar;
    public $operacionSeleccionada;
    public $usuarios;
    public $usuario_asignado_id;
    public $deudor;
    public $nro_doc;
    public $agente;
    public $nro_operacion;
    public $producto;
    public $situacion;
    protected $listeners = ['terminosDeBusquedaCartera'=>'buscarOperacion'];

    public function mostrarModalAsignar($operacioId)
    {
        $this->operacionSeleccionada=Operacion::find($operacioId);
        $this->modalAsignar = true;
        $this->usuarios = User::all();
    }

    public function asignarOperacion($operacionSeleccionadaId)
    {
        $this->validate([
            'usuario_asignado_id'=> 'required'
        ]);
        $operacionAsignada = Operacion::find($operacionSeleccionadaId);
        $operacionAsignada->usuario_asignado_id = $this->usuario_asignado_id;
        $operacionAsignada->usuario_ultima_modificacion_id = auth()->id();
        $operacionAsignada->save();
        $this->modalAsignar = false; 
        $this->usuario_asignado_id = null;
    }

    public function cerrarModalAsignar()
    {
        $this->modalAsignar = false; 
        $this->usuario_asignado_id = null;
        $this->resetErrorBag(); 
    }

    public function buscarOperacion($deudor, $nro_doc, $agente, $nro_operacion, $producto, $situacion)
    {
        $this->deudor = $deudor;
        $this->nro_doc = $nro_doc;
        $this->agente = $agente;
        $this->nro_operacion = $nro_operacion;
        $this->producto = $producto;
        $this->situacion = $situacion;
    }

    public function render()
    {
        //Busqueda por nro_doc
        $operaciones = Operacion::when($this->nro_doc, function($query){
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

        //Busqueda por cliente
        })->when($this->agente, function($query) {
            $agenteId = User::where('id', $this->agente)
                ->pluck('id')
                ->first();
            $query->where('usuario_asignado_id', $agenteId);

        //Busqueda por Producto
        })->when($this->producto, function($query) {
            $productoId = Producto::where('id', $this->producto)
                ->pluck('id')
                ->first();
            $query->where('producto_id', $productoId);

        //Busqueda por situacion
        })->when($this->situacion, function($query){
            if ($this->situacion == 100) {
                $query->where('usuario_asignado_id', 100);
            } else {
                $query->where('usuario_asignado_id', '!=', 100);
            }

        //Vista principal
        })->paginate(30);

        return view('livewire.operaciones.operaciones',[
            'operaciones'=>$operaciones
        ]);
    }
}
