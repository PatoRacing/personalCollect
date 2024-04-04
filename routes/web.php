<?php

use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DeudorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropuestaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

//Log in
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/', [AuthenticatedSessionController::class, 'store']);
Route::get('olvide-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('olvide-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

//Usuarios
Route::get('/usuario',[UsuarioController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('usuario');
Route::get('crear-usuario', [RegisteredUserController::class, 'create'])->middleware(['auth', 'verified', 'rol.administrador'])->name('crear.usuario');
Route::post('crear-usuario', [RegisteredUserController::class, 'store'])->middleware(['auth', 'verified', 'rol.administrador']);
Route::get('actualizar-usuario/{id}', [UsuarioController::class, 'edit'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.usuario');
Route::post('actualizar-usuario/{id}', [UsuarioController::class, 'store'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.usuario.store');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware(['auth', 'verified'])->name('logout');

//Modulo de cliente
Route::get('/clientes',[ClienteController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('clientes');
Route::get('/crear-cliente',[ClienteController::class, 'create'])->middleware(['auth', 'verified', 'rol.administrador'])->name('crear.cliente');
Route::get('/actualizar-cliente/{cliente}',[ClienteController::class, 'edit'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.cliente');
Route::get('/perfil-cliente/{cliente}',[ClienteController::class, 'show'])->middleware(['auth', 'verified', 'rol.administrador'])->name('perfil.cliente');
Route::get('/generar-operacion' ,[ClienteController::class, 'generarOperacion'])->middleware(['auth', 'verified', 'rol.administrador'])->name('generar.operacion');
Route::get('/importar-deudores' ,[ClienteController::class, 'importarDeudores'])->middleware(['auth', 'verified', 'rol.administrador'])->name('importar.deudores');
Route::post('/importar-deudores',[ClienteController::class, 'almacenarDeudores'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.deudores');
Route::get('/importar-informacion' ,[ClienteController::class, 'importarInformacion'])->middleware(['auth', 'verified', 'rol.administrador'])->name('importar.informacion');
Route::post('/importar-informacion',[ClienteController::class, 'almacenarInformacion'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.informacion');
Route::get('/importar-operaciones/{cliente}',[ClienteController::class, 'importarOperaciones'])->middleware(['auth', 'verified', 'rol.administrador'])->name('importar.operaciones');
Route::post('/importar-operaciones/{cliente}',[ClienteController::class, 'almacenarOperaciones'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.operaciones');


//Productos
Route::get('/productos',[ProductoController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('productos');
Route::get('/crear-producto',[ProductoController::class, 'create'])->middleware(['auth', 'verified', 'rol.administrador'])->name('crear.producto');
Route::get('/perfil-producto/{producto}',[ProductoController::class, 'perfil'])->middleware(['auth', 'verified', 'rol.administrador'])->name('perfil.producto');
Route::get('/generar-politica/{producto}',[ProductoController::class, 'politica'])->middleware(['auth', 'verified', 'rol.administrador'])->name('generar.politica');
Route::get('/actualizar-politica/{politica}',[ProductoController::class, 'actualizarPolitica'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.politica');
Route::get('/actualizar-producto/{producto}',[ProductoController::class, 'update'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.producto');

//Gestion Deudores 
Route::get('/cartera',[DeudorController::class, 'index'])->middleware(['auth', 'verified'])->name('cartera');
Route::get('/deudor-perfil/{deudor}',[DeudorController::class, 'show'])->middleware(['auth', 'verified'])->name('deudor.perfil');
Route::get('/deudor-nueva-gestion/{deudor}',[DeudorController::class, 'edit'])->middleware(['auth', 'verified'])->name('deudor.nueva.gestion');
Route::get('/deudor-historial/{deudor}',[DeudorController::class, 'historial'])->middleware(['auth', 'verified'])->name('deudor.historial');
Route::get('/deudor-actualizar-gestion/{gestionesDeudores}',[DeudorController::class, 'actualizarGestion'])->middleware(['auth', 'verified'])->name('deudor.actualizar.gestion');
Route::get('/deudor-nuevo-telefono/{deudor}',[DeudorController::class, 'nuevoTelefono'])->middleware(['auth', 'verified'])->name('deudor.nuevo.telefono');
Route::get('/deudor-actualizar-telefono/{telefono}',[DeudorController::class, 'actualizarTelefono'])->middleware(['auth', 'verified'])->name('deudor.actualizar.telefono');
Route::get('/nueva-propuesta/{operacion}',[DeudorController::class, 'propuesta'])->middleware(['auth', 'verified'])->name('propuesta');
Route::get('/propuesta-incobrable/{operacion}',[DeudorController::class, 'propuestaIncobrable'])->middleware(['auth', 'verified'])->name('propuesta.incobrable');
Route::get('/historial-propuesta/{operacion}',[DeudorController::class, 'historialPropuesta'])->middleware(['auth', 'verified'])->name('historial.propuesta');

//Gestión de propuestas
Route::get('/propuestas',[PropuestaController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('propuestas');

//Gestion de Acuerdos
Route::get('/acuerdos',[AcuerdoController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('acuerdos');
Route::get('/acuerdo/{acuerdo}',[AcuerdoController::class, 'show'])->middleware(['auth', 'verified', 'rol.administrador'])->name('acuerdo');
Route::get('/importar-acuerdos',[AcuerdoController::class, 'importar'])->middleware(['auth', 'verified', 'rol.administrador'])->name('importar.acuerdos');
Route::post('/importar-acuerdos',[AcuerdoController::class, 'almacenar'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.acuerdos');
Route::get('/subir-comprobante/{pago}',[AcuerdoController::class, 'subirComprobante'])->middleware(['auth', 'verified', 'rol.administrador'])->name('subir.comprobantes');
Route::get('/pagos',[AcuerdoController::class, 'pagos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('pagos');
Route::get('/importar-pagos',[AcuerdoController::class, 'importarPagos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('importar.pagos');
Route::post('/importar-pagos',[AcuerdoController::class, 'almacenarPagos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.pagos');
Route::get('/informar-pagos/{pagoId}',[AcuerdoController::class, 'informarPagos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('informar.pagos');

//Agenda
Route::get('/agenda',[AgendaController::class, 'index'])->middleware(['auth', 'verified'])->name('agenda');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
