<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Operacion;
use App\Models\Politica;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductoController extends Controller
{
    public function index()
    {
        return view('productos.productos');
    }

    public function create()
    {
        $clientes = Cliente::all();

        return view('productos.crear-producto',[
            'clientes'=>$clientes
        ]);
    }

    public function update(Producto $producto)
    {
        $clientes = Cliente::all();

        return view('productos.actualizar-producto',[
            'producto'=> $producto,
            'clientes'=> $clientes
        ]);
    }

    public function perfil(Producto $producto)
    {
        $cliente = Operacion::where('cliente_id', $producto->cliente_id)->first();
        $operaciones = Operacion::where('producto_id', $producto->id)->get();
        $politicas = Politica::where('producto_id', $producto->id)->paginate(12);
        $cantidadOperaciones = $operaciones->count();
        $operacionesActivas = $operaciones->where('situacion', 1)->count();
        $sumaOperacionesActivas = $operaciones->where('situacion', 1)->sum('deuda_capital');
        $totalDeudaCapital = $operaciones->sum('deuda_capital');

        return view('productos.perfil-producto',[
            'producto'=> $producto,
            'cantidadOperaciones'=> $cantidadOperaciones,
            'totalDeudaCapital'=> $totalDeudaCapital,
            'operacionesActivas'=> $operacionesActivas,
            'sumaOperacionesActivas'=> $sumaOperacionesActivas,
            'cliente'=> $cliente,
            'politicas'=> $politicas,
        ]);
    }

    public function politica(Producto $producto)
    {
        $propiedadesOperacion = Schema::getColumnListing('operacions');
        sort($propiedadesOperacion);

        return view('productos.generar-politica',[
            'producto'=>$producto,
            'propiedadesOperacion'=>$propiedadesOperacion,
        ]);
    }

    public function actualizarPolitica(Politica $politica)
    {
        $propiedadesOperacion = Schema::getColumnListing('operacions');
        sort($propiedadesOperacion);

        return view('productos.actualizar-politica',[
            'politica'=>$politica,
            'propiedadesOperacion'=>$propiedadesOperacion,
        ]);
    }

}
