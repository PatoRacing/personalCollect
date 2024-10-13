<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    
    public function create(): View
    {
        return view('usuarios.crear-usuario');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string','numeric'],
            'rol' => ['required', 'string'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'domicilio' => ['required', 'string', 'max:255'],
            'localidad' => ['required', 'string', 'max:255'],
            'codigo_postal' => ['required', 'string', 'max:20'],
            'fecha_de_ingreso' => ['required', 'date', 'after_or_equal:1970-01-01'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*])/', 'confirmed', Rules\Password::defaults()],
        ]);

        if(Auth::check())
        {
            $user = User::create([
                'name' => $request->name,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'estado' => 1, //1: Activo 2:Inactivo
                'rol' => $request->rol,
                'dni' => $request->dni,
                'domicilio' => $request->domicilio,
                'localidad' => $request->localidad,
                'codigo_postal' => $request->codigo_postal,
                'telefono' => $request->telefono,
                'fecha_de_ingreso' => $request->fecha_de_ingreso,
                'password' => Hash::make($request->password),
                'usuario_ultima_modificacion_id'=> auth()->id()  
            ]);
        }
        event(new Registered($user));
        return redirect('usuarios')->with('message', 'Usuario agregado correctamente');
    }
}
