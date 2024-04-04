<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $usuarios = User::orderBy('created_at', 'desc')->paginate(10);
        foreach ($usuarios as $usuario) {
            $usuario->fecha_de_ingreso_formateada = Carbon::parse($usuario->fecha_de_ingreso)->format('d/m/Y');
        }

        return view('usuarios.index', [
            'usuarios'=>$usuarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($request->id),],
            'rol' => ['required', 'string'],
            'dni' => ['required', 'string', 'max:12'],
            'domicilio' => ['required', 'string', 'max:255'],
            'localidad' => ['required', 'string', 'max:255'],
            'codigo_postal' => ['required', 'string', 'max:20'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:20'],
            'fecha_de_ingreso' => ['required', 'date', 'after_or_equal:1970-01-01'],
        ]);

        $usuario_autenticado_id = Auth::id();
        $usuario = User::findOrFail($request->id);
        $usuario->update(array_merge($request->all(), ['usuario_ultima_modificacion_id' => $usuario_autenticado_id]));

        return redirect('usuario')->with('message', 'Usuario actualizado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        $fechaIngreso = Carbon::parse($usuario->fecha_de_ingreso)->toDateString();

        return view('usuarios.actualizar-usuario', [
            "usuario"=> $usuario,
            "fechaIngreso"=> $fechaIngreso
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

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
}
