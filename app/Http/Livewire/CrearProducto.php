<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Operacion;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class CrearProducto extends Component
{
    public $nombre;
    public $clientes;
    public $cliente_id;
    public $honorarios;
    public $comision_cliente;
    public $acepta_cuotas_variables;
    
    
    public function crearProducto()
    {
        $datos = $this->validate([
            'nombre'=> 'required',
            'cliente_id'=> 'required',
            'honorarios'=> 'required',
            'comision_cliente'=> 'required',
            'acepta_cuotas_variables'=> 'required'
        ]);
        Producto::create([
            'nombre'=> $datos['nombre'],
            'cliente_id'=> $datos['cliente_id'],
            'honorarios'=> $datos['honorarios'],
            'comision_cliente'=> $datos['comision_cliente'],
            'acepta_cuotas_variables'=> $datos['acepta_cuotas_variables'],
            'usuario_ultima_modificacion_id'=> $datos['comision_cliente'],
            'estado'=> 1,
            'usuario_ultima_modificacion_id'=>auth()->id(),
        ]);
        return redirect('productos')->with('message', 'Producto agregado correctamente');
    }

    public function render()
    {
        return view('livewire.crear-producto');
    }
}
