<?php

namespace App\Http\Controllers;

use App\Imports\ImportacionTemporalAsignaciones;
use App\Models\Cliente;
use App\Models\Deudor;
use App\Models\GestionesDeudores;
use App\Models\ImportacionTemporalAsignacion;
use App\Models\Operacion;
use App\Models\Propuesta;
use App\Models\Telefono;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class OperacionController extends Controller
{
    public function index()
    {
        return view('operaciones.operaciones');
    }

    public function generarOperacion()
    {
        $clientes = Cliente::all();

        return view('operaciones.generar-operacion', [
            'clientes'=>$clientes
        ]);
    }

    public function asignarOperaciones()
    {
        return view('operaciones.asignar-operaciones');
    }

    public function almacenarOperacionesAsignadas(Request $request)
    {
        $request->validate([
            'importar'=> 'required|mimes:xls,xlsx|max:2048'
        ]);
        //Se establece que el maximo de ejecución es de 20 minutos
        ini_set('max_execution_time', 1200);
        $inicioImportacion = microtime(true);
        $excelImportacion = $request->file('importar');
        //Se verifica que los encabezados esten correctos
        $encabezadosEsperados = ['operacion', 'cliente_id', 'agente_asignado_id'];
        $encabezadosExcel = (new HeadingRowImport)->toArray($request->file('importar'))[0][0];
        foreach ($encabezadosEsperados as $encabezadoEsperado) {
            if (!in_array($encabezadoEsperado, $encabezadosExcel)) {
                return back()->withErrors(['error' => "Existe un error en un encabezado del archivo que estas importando. Revisa en el excel el nombre de la columna que corresponde a '$encabezadoEsperado'."]);
            }
        }
        try {
            //Se realiza la importación a la tabla temporal
            DB::beginTransaction();
            $importacionTemporal = new ImportacionTemporalAsignaciones();
            Excel::import($importacionTemporal, $excelImportacion);
            //Se consulta a los registros temporales y se inician los contadores de cada nueva instancia
            $excelSinOperacion = $importacionTemporal->excelSinOperacion;
            $excelSinAgenteAsignado = $importacionTemporal->excelSinAgenteAsignado;
            $operacionInexistente = 0;
            $usuarioInexistente = 0;
            $nuevasAsignaciones = 0;
            
            $registrosTemporales = ImportacionTemporalAsignacion::all();
            $incioNuevasAsignaciones = microtime(true);
            foreach($registrosTemporales as $registroTemporal) {
                $operacion = Operacion::where('operacion', $registroTemporal->operacion)
                            ->where('cliente_id', $registroTemporal->cliente_id)
                            ->first();
                if($operacion) {
                    $agenteAsignado = User::find($registroTemporal->agente_asignado_id);
                    if($agenteAsignado) {
                        $operacion->usuario_asignado_id = $registroTemporal->agente_asignado_id;
                        $operacion->update();
                        $nuevasAsignaciones ++;
                    } else {
                        $usuarioInexistente ++;
                    }
                } else {
                    $operacionInexistente ++;
                }
            }
            $finNuevasAsignaciones = microtime(true);
            $duracionNuevasAsignaciones = $finNuevasAsignaciones - $incioNuevasAsignaciones;
            $maximoNuevasAsignaciones = 1140; //Maximo para la creacion de nuevos registros 1140 segundos (19 minutos)
            if($duracionNuevasAsignaciones > $maximoNuevasAsignaciones) {
                DB::rollBack();
                return back()->withErrors(['error' => "Superaste el máximo de tiempo asignar operaciones"]);
            }
            DB::commit();
            ImportacionTemporalAsignacion::truncate();
            $finImportacion = microtime(true);
            $duracionImportacion = $finImportacion - $inicioImportacion;

            $mensajes = [];
            //Mensaje de excel sin operacion
            if($excelSinOperacion === 1) {
                $mensajes[] = "Se omitió un registro porque hay un valor incorrecto en columna operación o cliente_id";
            } elseif ($excelSinOperacion > 1) {
                $mensajes[] = "Se omitieron {$excelSinOperacion} registros porque hay valores incorrectos en columnas operación o cliente_id";
            }
            //Mensaje de excel sin agente asignado
            if($excelSinAgenteAsignado === 1) {
                $mensajes[] = "Se omitió un registro porque hay un id de agente asignado incorrecto";
            } elseif ($excelSinAgenteAsignado > 1) {
                $mensajes[] = "Se omitieron {$excelSinAgenteAsignado} porque hay ids de agentes asignados incorrectos";
            }
            //Mensaje de excel operacion Inexistente
            if($operacionInexistente === 1) {
                $mensajes[] = "No se asigno un registro del archivo excel porque no existe la operación en la BD";
            } elseif ($operacionInexistente > 1) {
                $mensajes[] = "No se asignaron {$operacionInexistente} registros del archivo excel porque no existen las operaciones en la BD";
            }
            //Mensaje de excel usuario Inexistente
            if($usuarioInexistente === 1) {
                $mensajes[] = "No se asignó un registro del archivo excel porque no existe el usuario en la BD";
            } elseif ($usuarioInexistente > 1) {
                $mensajes[] = "No se asignaron {$usuarioInexistente} registros del archivo excel porque no existen los usuarios en la BD";
            }
            //Mensaje de nuevas asignaciones
            if ($nuevasAsignaciones === 1) {
                $mensajes[] = "Se asignó una operacion correctamente";
            } elseif ($nuevasAsignaciones > 1) {
                $mensajes[] = "Se asignaron {$nuevasAsignaciones} operaciones correctamente";
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
            return redirect()->route('operaciones')->with('message', implode("\n", $mensajes));
        }  catch (\Exception $e) {
            DB::rollBack();
            $errorImportacion = 'Ocurrió un error inesperado en la importación: ' . $e->getMessage();
            return back()->withErrors(['error' => $errorImportacion]);
        }        
    }
    
    public function deudorPerfil(Deudor $deudor)
    {
        return view('operaciones.deudor-perfil',[
            'deudor'=>$deudor
        ]);
    }

    public function actualizarDeudor(Deudor $deudor)
    {
        return view('operaciones.actualizar-deudor',[
            'deudor'=>$deudor
        ]);
    }

    public function nuevaGestion(Operacion $operacion) 
    {
        return view('operaciones.nueva-gestion',[
            'operacion'=>$operacion
        ]);
    }
}
