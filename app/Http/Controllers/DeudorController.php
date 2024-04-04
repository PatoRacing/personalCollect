<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Deudor;
use App\Models\Email;
use App\Models\GestionesDeudores;
use App\Models\Operacion;
use App\Models\Politica;
use App\Models\Producto;
use App\Models\Propuesta;
use App\Models\Telefono;
use Illuminate\Http\Request;

class DeudorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    public function index()
    {
        return view('deudores.cartera');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Deudor $deudor)
    {
        $deudorId = $deudor->id;
        $gestionesDeudor = GestionesDeudores::where('deudor_id', $deudorId)
                                            ->latest('created_at')
                                            ->paginate(1);
        $ultimaGestion = GestionesDeudores::where('deudor_id', $deudorId)
                                        ->latest('created_at')
                                        ->first();
        $telefonos = Telefono::where('deudor_id', $deudorId)
                            ->orderBy('created_at', 'desc')
                            ->get();   
        $operaciones = Operacion::where('deudor_id', $deudorId)->get();
        $ultimaPropuesta = Propuesta::where('deudor_id', $deudorId)
                                    ->latest('created_at')
                                    ->first();
        
                
        return view('deudores.deudor-perfil', [
            'deudor'=>$deudor,
            'deudorId'=>$deudorId,
            'gestionesDeudor'=>$gestionesDeudor,
            'ultimaGestion'=>$ultimaGestion,
            'telefonos'=>$telefonos,
            'operaciones'=>$operaciones,
            'ultimaPropuesta'=>$ultimaPropuesta
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Deudor $deudor)
    {
        return view('deudores.deudor-nueva-gestion',[
            'deudor'=>$deudor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function historial(Deudor $deudor)
    {
        $deudorId = $deudor->id;
        $deudorNombre=$deudor->nombre;
        $historiales = GestionesDeudores::where('deudor_id', $deudorId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('deudores.deudor-historial',[
            'deudorId'=>$deudorId,
            'deudorNombre'=>$deudorNombre,
            'historiales'=>$historiales,
        ]);
    }

    public function actualizarGestion(GestionesDeudores $gestionesDeudores)
    {
        $deudor_id = $gestionesDeudores->deudor_id;
        $deudor = Deudor::find($deudor_id);
        $deudorNombre = $deudor->nombre;

        return view('deudores.deudor-actualizar-gestion',[
            'gestionesDeudores' => $gestionesDeudores,
            'deudorNombre' => $deudorNombre,
        ]);
    }

    public function nuevoTelefono(Deudor $deudor)
    {
        $deudorId = $deudor->id;

        return view('deudores.deudor-nuevo-telefono',[
            'deudorId'=>$deudorId,
            'deudor'=>$deudor,
        ]);
    }

    public function actualizarTelefono(Telefono $telefono)
    {
        $deudor_id = $telefono->deudor_id;
        $deudor = Deudor::find($deudor_id);
        $deudorNombre = $deudor->nombre;

        return view('deudores.deudor-actualizar-telefono',[
            'telefono'=>$telefono,
            'deudorNombre' => $deudorNombre,
            'deudorNombre' => $deudorNombre,
            'deudor_id' => $deudor_id,
        ]);
    }

    public function propuesta(Operacion $operacion)
    {
        $propuestas = Propuesta::where('operacion_id', $operacion->id)
                                ->orderBy('created_at', 'desc')
                                ->paginate(2);

        $deudorId = $operacion->deudor_id;
        $telefonos = Telefono::where('deudor_id', $deudorId)
                            ->orderBy('created_at', 'desc')
                            ->get();
        $ultimaPropuesta = Propuesta::where('deudor_id', $deudorId)
                                    ->latest('created_at')
                                    ->first();
        

        return view('deudores.nueva-propuesta',[
            'operacion' => $operacion,
            'propuestas' => $propuestas,
            'telefonos' => $telefonos,
            'ultimaPropuesta' => $ultimaPropuesta,
            
        ]);
    }

    public function historialPropuesta(Operacion $operacion)
    {
        $operacionId = $operacion->id;
        $propuestas = Propuesta::where('operacion_id', $operacionId)->orderBy('created_at', 'desc')->get();

        return view('deudores.historial-propuesta',[
            'operacion' => $operacion,
            'operacionId' => $operacionId,
            'propuestas' => $propuestas,
        ]);
    }

    public function propuestaIncobrable(Operacion $operacion)
    {
        $deudorId = $operacion->deudor_id;
        $deudor = Deudor::find($deudorId);
        $deudorNombre = $deudor->nombre;
        $productoId = $operacion->producto_id;
        $producto = Producto::find($productoId);
        $honorarios = $producto->honorarios;
        

        return view('deudores.propuesta-incobrable',[
            'deudorNombre' => $deudorNombre,
            'operacion' => $operacion,
            'honorarios' => $honorarios,
            'deudor' => $deudor,
            'deudorId' => $deudorId,
        ]);
    }
}
