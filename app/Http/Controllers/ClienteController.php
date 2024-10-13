<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use RuntimeException;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use App\Models\ImportacionTemporal;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreClienteRequest;
use App\Imports\ImportacionTemporalImport;
use App\Http\Requests\UpdateClienteRequest;
use App\Imports\ImportacionTemporalCuilImport;
use App\Imports\ImportacionTemporalDeudoresImport;
use App\Imports\ImportacionTemporalInformacionImport;
use App\Imports\ImportacionTemporalOperacionImport;
use App\Models\Deudor;
use App\Models\ImportacionTemporalCuil;
use App\Models\ImportacionTemporalDeudor;
use App\Models\ImportacionTemporalInformacion;
use App\Models\ImportacionTemporalOperacion;
use App\Models\Operacion;
use App\Models\Producto;
use App\Models\Telefono;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\HeadingRowImport;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes.clientes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.crear-cliente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClienteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClienteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $totalCasos = $cliente->operaciones->count();
        $casosActivos = $cliente->operaciones->where('situacion', 1)->count();
        $totalDNI = $cliente->operaciones->unique('nro_doc')->count();
        $deudaActiva = $cliente->operaciones->where('situacion', 1)->sum('deuda_capital');

        return view('clientes.perfil-cliente', [
            'totalCasos'=>$totalCasos,
            'casosActivos'=>$casosActivos,
            'totalDNI'=>$totalDNI,
            'deudaActiva'=>$deudaActiva,
            'cliente'=>$cliente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.actualizar-cliente', [
            'cliente'=>$cliente,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClienteRequest  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }

    public function importarDeudores()
    {
        return view('clientes.importar-deudores');
    }

    public function almacenarDeudores(HttpRequest $request)
    {
        $request->validate([
            'importar'=> 'required|mimes:xls,xlsx|max:2048'
        ]);

        //Se establece que el maximo de ejecución es de 20 minutos
        ini_set('max_execution_time', 1200);
        $inicioImportacion = microtime(true);
        $excelImportacion = $request->file('importar');

        //Se verifica que los encabezados esten correctos
        $encabezadosEsperados = ['nombre', 'tipo_doc', 'nro_doc', 'cuil', 'domicilio', 'localidad', 'codigo_postal'];
        $encabezadosExcel = (new HeadingRowImport)->toArray($request->file('importar'))[0][0];
        foreach ($encabezadosEsperados as $encabezadoEsperado) {
            if (!in_array($encabezadoEsperado, $encabezadosExcel)) {
                return back()->withErrors(['error' => "Existe un error en un encabezado del archivo que estas importando. Revisa en el excel el nombre de la columna que corresponde a '$encabezadoEsperado'."]);
            } 
        }
        try {
            DB::beginTransaction();
            $importacionTemporal = new ImportacionTemporalDeudoresImport();
            Excel::import($importacionTemporal, $excelImportacion);

            //Se consulta a los registros temporales y se inician los contadores de cada nueva instancia
            $excelSinDocumento = $importacionTemporal->excelSinDocumento;
            $sumaDeudores = 0;
            $registrosTemporales = ImportacionTemporalDeudor::all();
            $incioNuevosRegistros = microtime(true);

            //Se itera sobre cada uno de los registros temporales
            foreach($registrosTemporales as $registroTemporal) {

                //Se identifica al deudor de la BD por su nro_doc. Si no existe en BD se crea uno nuevo
                $deudorExistente = Deudor::where('nro_doc', $registroTemporal->nro_doc)->first();
                if(!$deudorExistente) {
                    $deudor = new Deudor([
                        'nombre' => $registroTemporal->nombre,
                        'tipo_doc' => $registroTemporal->tipo_doc,
                        'nro_doc' => $registroTemporal->nro_doc,
                        'cuil'=>$registroTemporal->cuil,
                        'domicilio' => $registroTemporal->domicilio,
                        'localidad' => $registroTemporal->localidad,
                        'codigo_postal' => $registroTemporal->codigo_postal,
                        'usuario_ultima_modificacion_id'=> auth()->id()
                    ]);
                    $deudor->save();
                    $sumaDeudores ++;
                } 
            }
            $finNuevosRegistros = microtime(true);
            $duracionNuevosRegistros = $finNuevosRegistros - $incioNuevosRegistros;
            $maximoNuevosRegistros = 1140; //Maximo para la creacion de nuevos registros 940 segundos (9 minutos)
            if($duracionNuevosRegistros > $maximoNuevosRegistros) {
                DB::rollBack();
                return back()->withErrors(['error' => "Superaste el máximo de tiempo almacenar nuevos registros"]);
            }
            DB::commit();
            ImportacionTemporalDeudor::truncate();
            $finImportacion = microtime(true);
            $duracionImportacion = $finImportacion - $inicioImportacion;

            //Mensajes
            $mensajes = [];
            $mensajeDuracion = '';
            if ($duracionImportacion > 0) {
                $duracionMinutos = floor($duracionImportacion / 60);
                $duracionSegundos = $duracionImportacion % 60;
                $mensajeDuracion .= $duracionMinutos > 0 ? ($duracionMinutos == 1 ? "1 minuto" : "$duracionMinutos minutos") : '';
                $mensajeDuracion .= $duracionSegundos > 0 ? ($mensajeDuracion ? " " : "") . ($duracionSegundos == 1 ? "1 segundo" : "$duracionSegundos segundos") : '';
                if ($mensajeDuracion) {
                    $mensajes[] = "Importación realizada en $mensajeDuracion";
                }
            }

            //Mensaje de excel sin nro_doc
            if ($excelSinDocumento === 1) {
                $mensajes[] = "Se omitió un registro del archivo excel porque no tiene número de documento";
            } elseif ($excelSinDocumento > 1) {
                $mensajes[] = "Se omitieron {$excelSinDocumento} registros del archivo excel porque no tienen número de documento";
            }

            //Mensaje de nuevos deudores
            if ($sumaDeudores === 0) {
                $mensajes[] = "No se crearon deudores porque ya existían en la BD";
            } elseif ($sumaDeudores === 1) {
                $mensajes[] = "Se creó un nuevo deudor";
            } else {
                $mensajes[] = "Se crearon {$sumaDeudores} nuevos deudores";
            }
            $mostrarMensajeImportacion = true;
            if ($mostrarMensajeImportacion) {
                session()->flash('successMessage', implode('<br>', $mensajes));
                session()->flash('messageType', 'import');
            }
            return redirect()->route('clientes');
        } catch(\Exception $e) {
            DB::rollBack();
            $errorImportacion = 'Ocurrió un error inesperado en la importación: ' . $e->getMessage();
            return back()->withErrors(['error' => $errorImportacion]);

        }
    }

    public function importarInformacion()
    {
        return view('clientes.importar-informacion');
    }

    public function almacenarInformacion(HttpRequest $request)
    {
        $request->validate([
            'importar'=> 'required|mimes:xls,xlsx|max:2048'
        ]);
        //Se establece que el maximo de ejecución es de 20 minutos
        ini_set('max_execution_time', 1200);
        $inicioImportacion = microtime(true);
        $excelImportacion = $request->file('importar');

        //Se verifica que los encabezados esten correctos
        $encabezadosEsperados = ['documento', 'cuil', 'email', 'telefono_uno', 'telefono_dos', 'telefono_tres'];
        $encabezadosExcel = (new HeadingRowImport)->toArray($request->file('importar'))[0][0];
        foreach ($encabezadosEsperados as $encabezadoEsperado) {
            if (!in_array($encabezadoEsperado, $encabezadosExcel)) {
                return back()->withErrors(['error' => "Existe un error en un encabezado del archivo que estas importando. Revisa en el excel el nombre de la columna que corresponde a '$encabezadoEsperado'."]);
            }
        }
        
        try{
            //Se realiza la importación a la tabla temporal
            DB::beginTransaction();
            $importacionTemporal = new ImportacionTemporalInformacionImport();
            Excel::import($importacionTemporal, $excelImportacion);

            //Se consulta a los registros temporales y se inician los contadores de cada nueva instancia
            $excelSinDocumento = $importacionTemporal->excelSinDocumento;
            $nuevosCuils = 0;
            $nuevosEmails = 0;
            $nuevosTelefonos = 0;
            $registrosTemporales = ImportacionTemporalInformacion::all();
            $incioNuevosRegistros = microtime(true);

            //Se itera sobre cada uno de los registros temporales
            foreach($registrosTemporales as $registroTemporal) {

                //Se identifica al deudor por su nro_doc. 
                $deudor = Deudor::where('nro_doc', $registroTemporal->documento)->first();
                if($deudor && !$deudor->cuil) {
                    //Si hay deudor y no tiene cuil, se asigna, si es que existe, el cuil de la importacion
                    if($registroTemporal->cuil) {
                        $deudor->cuil = $registroTemporal->cuil;
                        $nuevosCuils ++;
                    }
                    $deudor->update();
                }

                //Si hay deudor y email en la importacion: ubicamos el deudor Id y lo buscamos en la tabla telefono
                if($deudor && $registroTemporal->email) {
                    $deudorId = $deudor->id;
                    $telefonos = Telefono::where('deudor_id', $deudorId)->pluck('email');

                    //Si el deudor no tiene email se crea uno nuevo con el valor importado
                    if($telefonos->count() === 0) {
                        $telefono = new Telefono ([
                            'deudor_id' => $deudorId,
                            'tipo' => 'Desconocido',
                            'contacto' => 'Referencia',
                            'email' => $registroTemporal->email,
                            'estado' => 2,
                            'usuario_ultima_modificacion_id' => auth()->user()->id,
                        ]);
                        $telefono->save();
                        $nuevosEmails ++;
                    } else {
                        //Si el deudor tiene un email distinto al que se importa se crea uno nuevo con el valor importado
                        if(!$telefonos->contains($registroTemporal->email)){
                            $telefono = new Telefono ([
                                'deudor_id' => $deudorId,
                                'tipo' => 'Desconocido',
                                'contacto' => 'Referencia',
                                'email' => $registroTemporal->email,
                                'estado' => 2,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $telefono->save();
                            $nuevosEmails ++;
                        }
                    }
                }

                //Mismo proceder que el paso anterior pero para los casos telefonoUno, telefonoDos y telefonoTres
                if($deudor && $registroTemporal->telefono_uno) {
                    $deudorId = $deudor->id;
                    $telefonos = Telefono::where('deudor_id', $deudorId)->pluck('numero');
                    if($telefonos->count() === 0) {
                        $telefono = new Telefono ([
                            'deudor_id' => $deudorId,
                            'tipo' => 'Referencia',
                            'contacto' => 'Provisto por Administración',
                            'numero' => $registroTemporal->telefono_uno,
                            'estado' => 2,
                            'usuario_ultima_modificacion_id' => auth()->user()->id,
                        ]);
                        $telefono->save();
                        $nuevosTelefonos ++;
                    } else {
                        if(!$telefonos->contains($registroTemporal->telefono_uno)){
                            $telefono = new Telefono ([
                                'deudor_id' => $deudorId,
                                'tipo' => 'Desconocido',
                                'contacto' => 'Referencia',
                                'numero' => $registroTemporal->telefono_uno,
                                'estado' => 2,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $telefono->save();
                            $nuevosTelefonos ++;
                        }
                    }
                }

                if($deudor && $registroTemporal->telefono_dos) {
                    $deudorId = $deudor->id;
                    $telefonos = Telefono::where('deudor_id', $deudorId)->pluck('numero');
                    if($telefonos->count() === 0) {
                        $telefono = new Telefono ([
                            'deudor_id' => $deudorId,
                            'tipo' => 'Desconocido',
                            'contacto' => 'Referencia',
                            'numero' => $registroTemporal->telefono_dos,
                            'estado' => 2,
                            'usuario_ultima_modificacion_id' => auth()->user()->id,
                        ]);
                        $telefono->save();
                        $nuevosTelefonos ++;
                    } else {
                        if(!$telefonos->contains($registroTemporal->telefono_dos)){
                            $telefono = new Telefono ([
                                'deudor_id' => $deudorId,
                                'tipo' => 'Desconocido',
                                'contacto' => 'Referencia',
                                'numero' => $registroTemporal->telefono_dos,
                                'estado' => 2,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $telefono->save();
                            $nuevosTelefonos ++;
                        }
                    }
                }

                if($deudor && $registroTemporal->telefono_tres) {
                    $deudorId = $deudor->id;
                    $telefonos = Telefono::where('deudor_id', $deudorId)->pluck('numero');
                    if($telefonos->count() === 0) {
                        $telefono = new Telefono ([
                            'deudor_id' => $deudorId,
                            'tipo' => 'Desconocido',
                            'contacto' => 'Referencia',
                            'numero' => $registroTemporal->telefono_tres,
                            'estado' => 2,
                            'usuario_ultima_modificacion_id' => auth()->user()->id,
                        ]);
                        $telefono->save();
                        $nuevosTelefonos ++;
                    } else {
                        if(!$telefonos->contains($registroTemporal->telefono_tres)){
                            $telefono = new Telefono ([
                                'deudor_id' => $deudorId,
                                'tipo' => 'Desconocido',
                                'contacto' => 'Referencia',
                                'numero' => $registroTemporal->telefono_tres,
                                'estado' => 2,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $telefono->save();
                            $nuevosTelefonos ++;
                        }
                    }
                }
            }
            $finNuevosRegistros = microtime(true);
            $duracionNuevosRegistros = $finNuevosRegistros - $incioNuevosRegistros;
            $maximoNuevosRegistros = 1140; //Maximo para la creacion de nuevos registros 940 segundos (9 minutos)
            if($duracionNuevosRegistros > $maximoNuevosRegistros) {
                DB::rollBack();
                return back()->withErrors(['error' => "Superaste el máximo de tiempo almacenar nuevos registros"]);
            }
            DB::commit();
            ImportacionTemporalInformacion::truncate();
            $finImportacion = microtime(true);
            $duracionImportacion = $finImportacion - $inicioImportacion;

            //Mensajes
            $mensajes = [];

            //Mensaje de excel sin nro_doc
            if ($excelSinDocumento === 1) {
                $mensajes[] = "Se omitió un registro del archivo excel porque no tiene número de documento";
            } elseif ($excelSinDocumento > 1) {
                $mensajes[] = "Se omitieron {$excelSinDocumento} registros del archivo excel porque no tienen número de documento";
            }
            
            $mensajeDuracion = '';
            if ($duracionImportacion > 0) {
                $duracionMinutos = floor($duracionImportacion / 60);
                $duracionSegundos = $duracionImportacion % 60;
                $mensajeDuracion .= $duracionMinutos > 0 ? ($duracionMinutos == 1 ? "1 minuto" : "$duracionMinutos minutos") : '';
                $mensajeDuracion .= $duracionSegundos > 0 ? ($mensajeDuracion ? " " : "") . ($duracionSegundos == 1 ? "1 segundo" : "$duracionSegundos segundos") : '';
                if ($mensajeDuracion) {
                    $mensajes[] = "Importación realizada en $mensajeDuracion";
                }
            }
            //Mensaje de nuevos cuils
            if ($nuevosCuils === 0) {
                $mensajes[] = "No se importaron CUILS (ya existen en la BD o no coinciden con el documento del deudor";
            } elseif ($nuevosCuils === 1) {
                $mensajes[] = "Se actualizó la información de un cuil correspondiente a un deudor";
            } else {
                $mensajes[] = "Se actualizó la información de {$nuevosCuils} cuils correspondientes a {$nuevosCuils} deudores";
            }

            //Mensaje de nuevos emails
            if ($nuevosEmails === 0) {
                $mensajes[] = "No se importaron emails (ya existen en la BD o no coinciden con el documento del deudor";
            } elseif ($nuevosEmails === 1) {
                $mensajes[] = "Se creó un nuevo registro de email";
            } else {
                $mensajes[] = "Se guardaron {$nuevosEmails} nuevos emails";
            }

            //Mensaje de nuevos telefonos
            if ($nuevosTelefonos === 0) {
                $mensajes[] = "No se importaron teléfonos (ya existen en la BD o no coinciden con el documento del deudor";
            } elseif ($nuevosTelefonos === 1) {
                $mensajes[] = "Se guardó un nuevo registro de teléfono correspondiente a un deudor";
            } else {
                $mensajes[] = "Se guardaron {$nuevosTelefonos} nuevos teléfonos";
            }

            $mostrarMensajeImportacion = true;
            if ($mostrarMensajeImportacion) {
                session()->flash('successMessage', implode('<br>', $mensajes));
                session()->flash('messageType', 'import');
            }            
            return redirect()->route('clientes');
        } catch (\Exception $e) {
            DB::rollBack();
            $errorImportacion = 'Ocurrió un error inesperado en la importación: ' . $e->getMessage();
            return back()->withErrors(['error' => $errorImportacion]);
        }
    }

    public function importarOperaciones(Cliente $cliente)
    {
        return view('clientes.importar-operaciones', [
            'cliente'=>$cliente,
        ]);
    }

    public function almacenarOperaciones(Cliente $cliente, HttpRequest $request)
    {
        //Se valida el archivo que se esta importando
        $request->validate([
            'importar'=> 'required|mimes:xls,xlsx|max:2048'
        ]);
        //Se inicia el proceso de importación
        $inicioImportacion = microtime(true);

        //Aumentar el max_execution_time a 1860 segundos (31 minutos) y obtener clienteId y el archivo que paso la validacion
        ini_set('max_execution_time', 1860);
        $clienteId = $request->input('cliente_id');
        $excelImportacion = $request->file('importar');

        //Se verifica que los encabezados esten correctos
        $encabezadosEsperados = [
            'segmento', 'producto', 'operacion','nro_doc', 'fecha_apertura','cant_cuotas','sucursal',
            'fecha_atraso',	'dias_atraso', 'fecha_castigo', 'deuda_total', 'monto_castigo', 'deuda_capital',
            'fecha_ult_pago', 'estado','fecha_asignacion', 'ciclo', 'acuerdo', 'sub_producto', 'compensatorio',
            'punitivos'
        ];
        $encabezadosExcel = (new HeadingRowImport)->toArray($request->file('importar'))[0][0];
        foreach ($encabezadosEsperados as $encabezadoEsperado) {
            if (!in_array($encabezadoEsperado, $encabezadosExcel)) {
                return back()->withErrors(['error' => "Existe un error en un encabezado del archivo que estas importando. Revisa en el excel el nombre de la columna que corresponde a '$encabezadoEsperado'."]);
            }
        }
        try {
            //Se inicia la importacion.
            DB::beginTransaction();
            $importacionTemporal = new ImportacionTemporalOperacionImport($clienteId);
            Excel::import($importacionTemporal, $excelImportacion);
            $docOmitidos = $importacionTemporal->docOmitidos;
            $operacionesOmitidas = $importacionTemporal->operacionesOmitidas;
            $productoOmitidos = $importacionTemporal->productoOmitidos;
            $deudaCapitalOmitidas = $importacionTemporal->deudaCapitalOmitidas;
            
            //Obtener registros temporales y desactivar las operaciones almacenadas que estan en BD pero no en la nueva importacion
            $inicioDesactivacion = microtime(true);
            $registrosTemporales = ImportacionTemporalOperacion::all();
            $operacionesEnBD = Operacion::where('cliente_id', $clienteId)
                                        ->pluck('operacion')
                                        ->toArray();
            $operacionesEnImportacion = $registrosTemporales->pluck('operacion')->toArray();
            $operacionesSinImportacion = array_diff($operacionesEnBD, $operacionesEnImportacion);
            $operacionesDesactivadas = 0;
            foreach ($operacionesSinImportacion as $operacionSinImportacion) {
                $operacion = Operacion::where('operacion', $operacionSinImportacion)
                    ->where('cliente_id', $clienteId)
                    ->first();
                if ($operacion && $operacion->situacion != 2) {
                    $operacionesDesactivadas ++;
                    $operacion->update(['situacion' => 2]);
                }
            }
            $finDesactivacion = microtime(true);
            $tiempoDesactivacion = $finDesactivacion - $inicioDesactivacion;
            $tiempoMaximoDesactivacion = 600; //El máximo para desactivar es de 600 segundos (10 minutos)
            if($tiempoDesactivacion > $tiempoMaximoDesactivacion) {
                DB::rollBack();
                return back()->withErrors(['error' => "Superaste el máximo de tiempo permitido para desactivar operaciones"]);
            }

            //Se inicia el bucle para crear deudores y operaciones
            $inicioOperaciones = microtime(true);
            $errorProducto = [];
            $numeroFila = 0;
            $operacionesNuevas = 0;
            $operacionesActualizadas = 0;
            $operacionSinDeudor = 0;
            foreach($registrosTemporales as $registroTemporal) {

                //Verificar que el producto exista para el cliente
                $numeroFila ++;
                $numeroFilaExcel =  $numeroFila + 1;
                $nombreCliente = $registroTemporal->cliente->nombre;
                $productoTemporal = $registroTemporal->producto;
                $producto = Producto::where('nombre', $productoTemporal)
                            ->where('cliente_id', $clienteId)
                            ->first();
                if(!$producto || $producto->estado === 2) {
                    $errorProducto[] = "El producto de la fila $numeroFilaExcel del archivo excel está inactivo o no pertenece al cliente $nombreCliente";
                    if(!empty($errorProducto)) {
                        DB::rollBack();
                        return back()->withErrors(['error' => $errorProducto]);
                    }
                }

                //Se cosulta a las operaciones almacenadas en la BD
                $operacion = Operacion::where('operacion', $registroTemporal->operacion)
                                        ->where('cliente_id', $clienteId)
                                        ->first();
                $productoId = $producto->id;
                $deudor = Deudor::where('nro_doc', $registroTemporal->nro_doc)->first();
                if($deudor) {
                    $deudorId = $deudor->id;
                    if (!$operacion) {
                        //Si existe deudor y no hay operación se crea una nueva
                        $operacionesNuevas ++;
                        $operacion = new Operacion ([
                            'segmento'=>$registroTemporal->segmento,
                            'producto_id'=>$productoId,
                            'operacion'=>$registroTemporal->operacion,
                            'nro_doc'=>$registroTemporal->nro_doc,
                            'fecha_apertura'=>$registroTemporal->fecha_apertura,
                            'cant_cuotas'=>$registroTemporal->cant_cuotas,
                            'sucursal'=>$registroTemporal->sucursal,
                            'fecha_atraso'=>$registroTemporal->fecha_atraso,
                            'dias_atraso'=>$registroTemporal->dias_atraso,
                            'fecha_castigo'=>$registroTemporal->fecha_castigo,
                            'deuda_total'=>$registroTemporal->deuda_total,
                            'monto_castigo'=>$registroTemporal->monto_castigo,
                            'deuda_capital'=>$registroTemporal->deuda_capital,
                            'fecha_ult_pago'=>$registroTemporal->fecha_ult_pago,
                            'estado'=>$registroTemporal->estado,
                            'fecha_asignacion'=>$registroTemporal->fecha_asignacion,
                            'ciclo'=>$registroTemporal->ciclo,
                            'acuerdo'=>$registroTemporal->acuerdo,
                            'sub_producto'=>$registroTemporal->sub_producto,
                            'compensatorio'=>$registroTemporal->compensatorio,
                            'punitivos'=>$registroTemporal->punitivos,
                            'situacion'=> 1,
                            'cliente_id'=>$clienteId,
                            'deudor_id'=>$deudorId,
                            'usuario_asignado_id'=>100,
                            'usuario_ultima_modificacion_id' => auth()->user()->id
                            ]);
                    } else {
                        //Si hay deudor y hay operacion se actualiza
                        $operacionesActualizadas ++;
                        $atributosNuevos = [
                            'segmento' => $registroTemporal->segmento,
                            'producto_id' => $productoId,
                            'operacion' => $registroTemporal->operacion,
                            'nro_doc' => $registroTemporal->nro_doc,
                            'fecha_apertura' => $registroTemporal->fecha_apertura,
                            'cant_cuotas' => $registroTemporal->cant_cuotas,
                            'sucursal' => $registroTemporal->sucursal,
                            'fecha_atraso' => $registroTemporal->fecha_atraso,
                            'dias_atraso' => $registroTemporal->dias_atraso,
                            'fecha_castigo' => $registroTemporal->fecha_castigo,
                            'deuda_total' => $registroTemporal->deuda_total,
                            'monto_castigo' => $registroTemporal->monto_castigo,
                            'deuda_capital' => $registroTemporal->deuda_capital,
                            'fecha_ult_pago' => $registroTemporal->fecha_ult_pago,
                            'estado' => $registroTemporal->estado,
                            'fecha_asignacion' => $registroTemporal->fecha_asignacion,
                            'ciclo' => $registroTemporal->ciclo,
                            'acuerdo' => $registroTemporal->acuerdo,
                            'sub_producto' => $registroTemporal->sub_producto,
                            'compensatorio' => $registroTemporal->compensatorio,
                            'punitivos' => $registroTemporal->punitivos,
                            'situacion' => 1,
                            'cliente_id' => $clienteId,
                            'deudor_id' => $deudorId,
                            'usuario_ultima_modificacion_id' => auth()->user()->id,
                        ];
                        foreach ($atributosNuevos as $atributo => $valorNuevo) {
                            if ($operacion->$atributo != $valorNuevo) {
                                $operacion->$atributo = $valorNuevo;
                            }
                        }
                    }
                    $operacion->save();
                } else {
                    $operacionSinDeudor ++;
                }                                                                                                              
            }
            $finOperaciones = microtime(true);
            $tiempoDeudoresTelefonosOperaciones = $finOperaciones - $inicioOperaciones;
            $tiempoMaximoDeudoresTelefonosOperaciones = 1200; //El tiempo máximo para deudores, telefonos y operaciones es de 1200 segundos (20 minutos)
            if($tiempoDeudoresTelefonosOperaciones > $tiempoMaximoDeudoresTelefonosOperaciones) {
                DB::rollBack();
                return back()->withErrors(['error' => "Superaste el máximo de tiempo almacenar nuevos deudores y/o operaciones"]);
            }
            //Si todo es correcto se realiza el commit, se trunca Importacion y se redirige con mensaje
            DB::commit();
            ImportacionTemporalOperacion::truncate();
            $finImportacion = microtime(true);
            $duracionImportacion = $finImportacion - $inicioImportacion;
            $mensajes = [];
            
            //Mensaje de duracion
            $mensajeDuracion = '';
            if ($duracionImportacion > 0) {
                $duracionMinutos = floor($duracionImportacion / 60);
                $duracionSegundos = $duracionImportacion % 60;
                $mensajeDuracion .= $duracionMinutos > 0 ? ($duracionMinutos == 1 ? "1 minuto" : "$duracionMinutos minutos") : '';
                $mensajeDuracion .= $duracionSegundos > 0 ? ($mensajeDuracion ? " " : "") . ($duracionSegundos == 1 ? "1 segundo" : "$duracionSegundos segundos") : '';
                if ($mensajeDuracion) {
                    $mensajes[] = "Importación realizada en $mensajeDuracion";
                }
            }

            //Mensaje de documentos omitidos
            if ($docOmitidos === 1) {
                $mensajes[] = "Se omitió un registro porque no tenía número de documento";
            } elseif ($docOmitidos > 1) {
                $mensajes[] = "Se omitieron {$docOmitidos} registros porque no tenían número de documento";
            }

            //Mensaje de operaciones omitidas
            if ($operacionesOmitidas === 1) {
                $mensajes[] = "Se omitió un registro porque no tenía número de operación";
            } elseif ($operacionesOmitidas > 1) {
                $mensajes[] = "Se omitieron {$operacionesOmitidas} registros porque no tenían número de operación";
            }

            //Mensaje de productos omitidos
            if ($productoOmitidos === 1) {
                $mensajes[] = "Se omitió un registro porque no tenía nombre de producto";
            } elseif ($productoOmitidos > 1) {
                $mensajes[] = "Se omitieron {$productoOmitidos} registros porque no tenían no tenía nombre de producto";
            }

            //Mensaje de deudas capitales omitidas
            if ($deudaCapitalOmitidas === 1) {
                $mensajes[] = "Se omitió un registro porque no tenía valor en deuda capital";
            } elseif ($deudaCapitalOmitidas > 1) {
                $mensajes[] = "Se omitieron {$deudaCapitalOmitidas} registros porque no tenían no tenían valor de deuda capital";
            }

            //Mensaje de operaciones desactivadas
            if ($operacionesDesactivadas === 0) {
                $mensajes[] = "No se desactivaron operaciones de la Base de Datos";
            } elseif ($operacionesDesactivadas === 1) {
                $mensajes[] = "Se desactivó una operación de la Base de Datos porque no forma parte de la nueva importación";
            } else {
                $mensajes[] = "Se desactivaron una {$operacionesDesactivadas} operaciones de la Base de Datos porque no forman parte de la nueva importación";
            }

            //Mensaje de operaciones sin deudor
            if ($operacionSinDeudor === 1) {
                $mensajes[] = "Se omitió una operación porque no tiene deudor asociado";
            } elseif($operacionSinDeudor > 1) {
                $mensajes[] = "Se omitieron {$operacionSinDeudor} porque no tienen deudor asociado";
            } else {
                //Mensaje de operaciones creadas
                if ($operacionesNuevas === 0) {
                    $mensajes[] = "No se crearon nuevas operaciones";
                } elseif ($operacionesNuevas === 1) {
                    $mensajes[] = "Se creó una nueva operación";
                } else {
                    $mensajes[] = "Se crearon {$operacionesNuevas} nuevas operaciones";
                }

                //Mensaje de operaciones actualizadas
                if ($operacionesActualizadas === 0) {
                    $mensajes[] = "No se actualizó la información de ninguna operación";
                } else {
                    $mensajes[] = "Se actualizó la información de {$operacionesActualizadas} operaciones";
                }
            }
            return redirect()->route('perfil.cliente', ['cliente' => $cliente->id])->with('message', implode('<br>', $mensajes));
        } catch (\Exception $e) {
            DB::rollBack();
            $errorImportacion = 'Ocurrió un error inesperado en la importación. (' . $e->getMessage() . ')';
            return redirect()->route('importar.operaciones', ['cliente' => $cliente->id])->withErrors(['error' => $errorImportacion]);
        }
    }
}

