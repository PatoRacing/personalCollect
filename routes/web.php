<?php

use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DeudorController;
use App\Http\Controllers\OperacionController;
use App\Http\Controllers\PagoController;
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

//Administradores
//Usuarios
Route::get('/usuarios',[UsuarioController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('usuarios');
Route::get('crear-usuario', [RegisteredUserController::class, 'create'])->middleware(['auth', 'verified', 'rol.administrador'])->name('crear.usuario');
Route::post('crear-usuario', [RegisteredUserController::class, 'store'])->middleware(['auth', 'verified', 'rol.administrador']);
Route::get('actualizar-usuario/{id}', [UsuarioController::class, 'edit'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.usuario');
Route::post('actualizar-usuario/{id}', [UsuarioController::class, 'store'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.usuario.store');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware(['auth', 'verified'])->name('logout');
//Clientes
Route::get('/clientes',[ClienteController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('clientes');
Route::get('/crear-cliente',[ClienteController::class, 'create'])->middleware(['auth', 'verified', 'rol.administrador'])->name('crear.cliente');
Route::get('/actualizar-cliente/{cliente}',[ClienteController::class, 'edit'])->middleware(['auth', 'verified', 'rol.administrador'])->name('actualizar.cliente');
Route::get('/perfil-cliente/{cliente}',[ClienteController::class, 'show'])->middleware(['auth', 'verified', 'rol.administrador'])->name('perfil.cliente');
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
//Operaciones
Route::get('/operaciones',[OperacionController::class, 'index'])->middleware(['auth', 'verified'])->name('operaciones');
Route::get('/generar-operacion' ,[OperacionController::class, 'generarOperacion'])->middleware(['auth', 'verified', 'rol.administrador'])->name('generar.operacion');
Route::get('/asignar-operaciones',[OperacionController::class, 'asignarOperaciones'])->middleware(['auth', 'verified', 'rol.administrador'])->name('asignar.operaciones');
Route::post('/asignar-operaciones',[OperacionController::class, 'almacenarOperacionesAsignadas'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.operaciones.asignadas');
Route::get('/deudor-perfil/{deudor}',[OperacionController::class, 'deudorPerfil'])->middleware(['auth', 'verified'])->name('deudor.perfil');
Route::get('/actualizar-deudor/{deudor}',[OperacionController::class, 'actualizarDeudor'])->middleware(['auth', 'verified'])->name('actualizar.deudor');
Route::get('/nueva-gestion/{operacion}',[OperacionController::class, 'nuevaGestion'])->middleware(['auth', 'verified'])->name('nueva.gestion');
//Propuestas
Route::get('/propuestas',[PropuestaController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('propuestas');
Route::get('/propuesta-manual',[PropuestaController::class, 'propuestaManual'])->middleware(['auth', 'verified', 'rol.administrador'])->name('propuesta.manual');
//Acuerdos
Route::get('/acuerdos',[AcuerdoController::class, 'index'])->middleware(['auth', 'verified', 'rol.administrador'])->name('acuerdos');
Route::get('/importar-acuerdos',[AcuerdoController::class, 'importarAcuerdos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('importar.acuerdos');
Route::post('/importar-acuerdos',[AcuerdoController::class, 'almacenarAcuerdos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.acuerdos');

//Cuotas index
Route::get('/cuotas',[PagoController::class, 'index'])->middleware(['auth', 'verified'])->name('cuotas');
Route::get('/gestion-cuota/{cuota}',[PagoController::class, 'gestionCuota'])->middleware(['auth', 'verified'])->name('gestion.cuota');

//Vistas de gestion de cuotas para administradores 
Route::get('/gestion-cuota/adm/cuota/{cuota}',[PagoController::class, 'gestionCuotaAdm'])->middleware(['auth', 'verified', 'rol.administrador'])->name('gestion.cuota.administrador');
Route::get('/gestion-cuota/adm/cancelacion/{cuota}',[PagoController::class, 'gestionCancelacionAdm'])->middleware(['auth', 'verified', 'rol.administrador'])->name('gestion.cancelacion.administrador');
Route::get('/gestion-cuota/adm/cse/{cuota}',[PagoController::class, 'gestionCuotaSaldoExcedenteAdm'])->middleware(['auth', 'verified', 'rol.administrador'])->name('gestion-saldo-excedente.administrador');
//Vistas de gestion de cuotas para agentes 
Route::get('/gestion-cuota/agt/cuota/{cuota}',[PagoController::class, 'gestionCuotaAgt'])->middleware(['auth', 'verified', 'rol.agente'])->name('gestion.cuota.agente');
Route::get('/gestion-cuota/agt/cancelacion/{cuota}',[PagoController::class, 'gestionCancelacionAgt'])->middleware(['auth', 'verified', 'rol.agente'])->name('gestion.cancelacion.agente');
Route::get('/gestion-cuota/agt/cse/{cuota}',[PagoController::class, 'gestionCuotaSaldoExcedenteAgt'])->middleware(['auth', 'verified', 'rol.agente'])->name('gestion-saldo-excedente.agente');

Route::get('/importar-pagos',[PagoController::class, 'importarPagos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('importar.pagos');
Route::post('/importar-pagos',[PagoController::class, 'almacenarPagos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('almacenar.pagos');
Route::get('/informar-pagos/{pagoId}',[PagoController::class, 'informarPagos'])->middleware(['auth', 'verified', 'rol.administrador'])->name('informar.pagos');




Route::get('/cartera',[DeudorController::class, 'index'])->middleware(['auth', 'verified'])->name('cartera');
Route::get('/deudor-nueva-gestion/{deudor}',[DeudorController::class, 'edit'])->middleware(['auth', 'verified'])->name('deudor.nueva.gestion');
Route::get('/deudor-historial/{deudor}',[DeudorController::class, 'historial'])->middleware(['auth', 'verified'])->name('deudor.historial');
Route::get('/deudor-actualizar-gestion/{gestionesDeudores}',[DeudorController::class, 'actualizarGestion'])->middleware(['auth', 'verified'])->name('deudor.actualizar.gestion');
Route::get('/deudor-nuevo-telefono/{deudor}',[DeudorController::class, 'nuevoTelefono'])->middleware(['auth', 'verified'])->name('deudor.nuevo.telefono');
Route::get('/deudor-actualizar-telefono/{telefono}',[DeudorController::class, 'actualizarTelefono'])->middleware(['auth', 'verified'])->name('deudor.actualizar.telefono');
Route::get('/nueva-propuesta/{operacion}',[DeudorController::class, 'propuesta'])->middleware(['auth', 'verified'])->name('propuesta');
Route::get('/propuesta-incobrable/{operacion}',[DeudorController::class, 'propuestaIncobrable'])->middleware(['auth', 'verified'])->name('propuesta.incobrable');
Route::get('/historial-propuesta/{operacion}',[DeudorController::class, 'historialPropuesta'])->middleware(['auth', 'verified'])->name('historial.propuesta');




Route::get('/acuerdo/{acuerdo}',[AcuerdoController::class, 'show'])->middleware(['auth', 'verified', 'rol.administrador'])->name('acuerdo');

Route::get('/subir-comprobante/{pago}',[AcuerdoController::class, 'subirComprobante'])->middleware(['auth', 'verified', 'rol.administrador'])->name('subir.comprobantes');




//Agenda
Route::get('/agenda',[AgendaController::class, 'index'])->middleware(['auth', 'verified'])->name('agenda');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
