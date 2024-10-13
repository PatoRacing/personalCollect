<?php

namespace App\Http\Livewire;

use App\Models\Producto;
use Livewire\Component;

class ActualizarProducto extends Component
{
    public $producto_id;
    public $nombre;
    public $honorarios;
    public $comision_cliente;
    public $clientes;
    public $cliente_id;
    public $acepta_cuotas_variables;

    protected $rules = [
        'nombre'=> 'required',
        'honorarios'=> 'required',
        'comision_cliente'=> 'required',
        'cliente_id'=> 'required',
        'acepta_cuotas_variables'=> 'required',
    ];

    public function mount(Producto $producto)
    {
        $this->producto_id = $producto->id;
        $this->nombre = $producto->nombre;
        $this->honorarios = $producto->honorarios;
        $this->comision_cliente = $producto->comision_cliente;
        $this->cliente_id = $producto->cliente_id;
        $this->acepta_cuotas_variables = $producto->acepta_cuotas_variables;
    }

    public function actualizarProducto()
    {
        $datos = $this->validate();
        $producto = Producto::find($this->producto_id);

        $producto->nombre = $datos['nombre'];
        $producto->honorarios = $datos['honorarios'];
        $producto->comision_cliente = $datos['comision_cliente'];
        $producto->cliente_id = $datos['cliente_id'];
        $producto->acepta_cuotas_variables = $datos['acepta_cuotas_variables'];
        $producto->usuario_ultima_modificacion_id = auth()->id();
        $producto->save();

        return redirect()->route('perfil.producto', ['producto'=>$this->producto_id])->with('message', 'Producto actualizado correctamente');
    }

    public function render()
    {
        return view('livewire.productos.actualizar-producto');
    }
}
