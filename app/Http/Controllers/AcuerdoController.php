<?php

namespace App\Http\Controllers;

use App\Imports\AcuerdosTemporalesImport;
use App\Imports\ImportacionTemporalPagoImport;
use App\Models\Acuerdo;
use App\Models\AcuerdoTemporal;
use App\Models\Deudor;
use App\Models\ImportacionTemporalPago;
use App\Models\Pago;
use App\Models\Propuesta;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class AcuerdoController extends Controller
{
    public function index()
    {
        return view('acuerdos.acuerdos');
    }

    public function importarAcuerdos()
    {
        return view('acuerdos.importar-acuerdos');
    }

    public function almacenarAcuerdos(Request $request)
    {
        $request->validate([
            'importar'=> 'required|mimes:xls,xlsx|max:2048'
        ]);
        try{
            DB::beginTransaction();
            $excel = $request->file('importar');
            $inicioGeneracionAcuerdos = microtime(true);
            $encabezadosEsperados = ['propuesta_id', 'estado'];
            $encabezadosExcel = (new HeadingRowImport())->toArray($excel)[0];
            $encabezadosExcel = $encabezadosExcel[0];
            if ($encabezadosEsperados !== $encabezadosExcel) {
                return back()->withErrors(['error' => 'Existe un error en un encabezado del archivo que estás importando.']);
            }
            //inicio de la importacion
            ini_set('max_execution_time', 1800);//Maxima duracion: 30 minutos
            $inicioImportacion = microtime(true);
            $acuerdosTemporales = new AcuerdosTemporalesImport;
            Excel::import($acuerdosTemporales, $excel, 500);
            $acuerdosTemp = AcuerdoTemporal::all();
            $acuerdosActivos = Acuerdo::pluck('propuesta_id')->toArray();
            if (!empty($acuerdosActivos)) {
                foreach ($acuerdosTemp as $acuerdoTemp) {
                    if (in_array($acuerdoTemp->propuesta_id, $acuerdosActivos)) {
                        DB::rollBack();
                        return back()->withErrors(['error' => 'Existen acuerdos activos para algunas propuestas que estas importando.']);
                    }
                }
            }
            $propuestasRechazadas = 0;
            $propuestasAcuerdoPago = 0;
            $acuerdosGenerados = 0;
            foreach ($acuerdosTemp as $acuerdoTemp) {
                if ($acuerdoTemp->estado === 2) {
                    $propuesta = Propuesta::where('id', $acuerdoTemp->propuesta_id)->update(['estado' => 'Rechazada']);
                    $propuestasRechazadas++;
                } elseif ($acuerdoTemp->estado === 1) {
                    $propuesta = Propuesta::where('id', $acuerdoTemp->propuesta_id)->update(['estado' => 'Acuerdo de Pago']);
                    $propuestasAcuerdoPago++;
                    $acuerdo = new Acuerdo([
                        'propuesta_id' => $acuerdoTemp->propuesta_id,
                        'estado'=> 1, //1- Vigente
                        'usuario_ultima_modificacion_id' => auth()->user()->id,
                        'responsable'=>$acuerdoTemp->propuesta->operacionId->usuario_asignado_id
                    ]);
                    $html = view('pdf.acuerdo-de-pago', ['acuerdo' => $acuerdo])->render();
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($html);
                    $dompdf->render();
                    $pdfContenido = $dompdf->output();
                    $nombreArchivo = 'acuerdo_' . $acuerdoTemp->propuesta_id . '.pdf';
                    $rutaArchivo = public_path('storage/acuerdos/' . $nombreArchivo);
                    file_put_contents($rutaArchivo, $pdfContenido);
                    $acuerdo->acuerdos_de_pago_pdf = $nombreArchivo;
                    $acuerdo->save();
                    $acuerdosGenerados++;
                    if($acuerdo->propuesta->tipo_de_propuesta === 1) {
                        $cancelacion = new Pago([
                            'acuerdo_id' => $acuerdo->id,
                            'responsable_id' => $acuerdo->responsable,
                            'estado' => 1, 
                            'concepto_cuota' => 'Cancelación',
                            'monto_acordado' => $acuerdo->propuesta->monto_ofrecido,
                            'vencimiento_cuota' => $acuerdo->propuesta->fecha_pago_cuota,
                            'nro_cuota' => 1,
                            'usuario_ultima_modificacion_id' => auth()->user()->id,
                        ]);
                        $cancelacion->save();
                    } elseif($acuerdo->propuesta->tipo_de_propuesta === 2) {
                        $cantidadPagos = $acuerdo->propuesta->cantidad_de_cuotas_uno;
                        $fechaPagoInicial = Carbon::parse($acuerdo->propuesta->fecha_pago_cuota);
                        for ($i = 1; $i <= $cantidadPagos; $i++) {
                            $monto = $acuerdo->propuesta->monto_de_cuotas_uno ?? 0;
                            $vencimiento = $fechaPagoInicial->clone()->addDays(30 * ($i - 1));
                            $pago = new Pago([
                                'acuerdo_id' => $acuerdo->id,
                                'responsable_id' => $acuerdo->responsable,
                                'estado' => 1,
                                'concepto_cuota' => 'Cuota', 
                                'monto_acordado' => $monto,
                                'vencimiento_cuota' => $vencimiento,
                                'nro_cuota' => $i,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $pago->save();
                        }
                        if($acuerdo->propuesta->anticipo) {
                            $anticipo = new Pago([
                                'acuerdo_id' => $acuerdo->id,
                                'responsable_id' => $acuerdo->responsable,
                                'estado' => 1, 
                                'concepto_cuota' => 'Anticipo', 
                                'monto_acordado' => $acuerdo->propuesta->anticipo,
                                'vencimiento_cuota' => $acuerdo->propuesta->fecha_pago_anticipo,
                                'nro_cuota' => 0,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $anticipo->save();
                        }
                    } elseif($acuerdo->propuesta->tipo_de_propuesta === 3) {
                        $cantidadPagos = $acuerdo->propuesta->cantidad_de_cuotas_uno;
                        $fechaPagoInicial = Carbon::parse($acuerdo->propuesta->fecha_pago_cuota);
                        for ($i = 1; $i <= $cantidadPagos; $i++) {
                            $monto = $acuerdo->propuesta->monto_de_cuotas_uno ?? 0;
                            $vencimiento = $fechaPagoInicial->clone()->addDays(30 * ($i - 1));
                            $pago = new Pago([
                                'acuerdo_id' => $acuerdo->id,
                                'responsable_id' => $acuerdo->responsable,
                                'estado' => 1,
                                'concepto_cuota' => 'Cuota', 
                                'monto_acordado' => $monto,
                                'vencimiento_cuota' => $vencimiento,
                                'nro_cuota' => $i,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $pago->save();
                        }
                        if($acuerdo->propuesta->anticipo) {
                            $anticipo = new Pago([
                                'acuerdo_id' => $acuerdo->id,
                                'responsable_id' => $acuerdo->responsable,
                                'estado' => 1,
                                'concepto_cuota' => 'Anticipo', 
                                'monto_acordado' => $acuerdo->propuesta->anticipo,
                                'vencimiento_cuota' => $acuerdo->propuesta->fecha_pago_anticipo,
                                'nro_cuota' => 0,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $anticipo->save();
                        }
                    } elseif($acuerdo->propuesta->tipo_de_propuesta === 4) {
                        $cantidadCuotasUno = $acuerdo->propuesta->cantidad_de_cuotas_uno;
                        $cantidadCuotasDos = $acuerdo->propuesta->cantidad_de_cuotas_dos;
                        $ultimaFechaCuotaUno = null;
                        for ($i = 1; $i <= $cantidadCuotasUno; $i++) {
                            $monto = $acuerdo->propuesta->monto_de_cuotas_uno ?? 0;
                            $ultimaFechaCuotaUno = Carbon::parse($acuerdo->propuesta->fecha_pago_cuota)->addDays(30 * ($i - 1));
                            $vencimiento = $ultimaFechaCuotaUno;
                            $pago = new Pago([
                                'acuerdo_id' => $acuerdo->id,
                                'responsable_id' => $acuerdo->responsable,
                                'estado' => 1,
                                'concepto_cuota' => 'Cuota', 
                                'monto_acordado' => $monto,
                                'vencimiento_cuota' => $vencimiento,
                                'nro_cuota' => $i, 
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $pago->save();
                        }
                        $primerFechaCuotaDos = $ultimaFechaCuotaUno->clone()->addDays(30);
                        for ($i = 1; $i <= $cantidadCuotasDos; $i++) {
                            $monto = $acuerdo->propuesta->monto_de_cuotas_dos ?? 0;
                            $vencimiento = $primerFechaCuotaDos->clone()->addDays(30 * ($i - 1));
                            $pago = new Pago([
                                'acuerdo_id' => $acuerdo->id,
                                'responsable_id' => $acuerdo->responsable,
                                'estado' => 1,
                                'concepto_cuota' => 'Cuota', 
                                'monto_acordado' => $monto,
                                'vencimiento_cuota' => $vencimiento,
                                'nro_cuota' => $i + ($cantidadCuotasUno),
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $pago->save();
                        }
                        $ultimaFechaCuotaDos = Pago::where('acuerdo_id', $acuerdo->id)
                                                ->where('concepto_cuota', 'Cuota')
                                                ->orderBy('vencimiento_cuota', 'desc')
                                                ->first()->vencimiento;

                        if ($acuerdo->propuesta->cantidad_de_cuotas_tres) {
                            $cantidadCuotasTres = $acuerdo->propuesta->cantidad_de_cuotas_tres;
                            $primerFechaCuotaTres = Carbon::parse($ultimaFechaCuotaDos)->addDays(30);
                            for ($i = 1; $i <= $cantidadCuotasTres; $i++) {
                                $monto = $acuerdo->propuesta->monto_de_cuotas_tres ?? 0;
                                $vencimiento = Carbon::parse($primerFechaCuotaTres)->addDays(30 * ($i - 1));
                                $pago = new Pago([
                                    'acuerdo_id' => $acuerdo->id,
                                    'responsable_id' => $acuerdo->responsable,
                                    'estado' => 1,
                                    'concepto_cuota' => 'Cuota', 
                                    'monto_acordado' => $monto,
                                    'vencimiento_cuota' => $vencimiento,
                                    'nro_cuota' => $i + ($cantidadCuotasUno) + ($cantidadCuotasDos),
                                    'usuario_ultima_modificacion_id' => auth()->user()->id,
                                ]);
                                $pago->save();
                            }
                        }
                        if($acuerdo->propuesta->anticipo) {
                            $anticipo = new Pago([
                                'acuerdo_id' => $acuerdo->id,
                                'responsable_id' => $acuerdo->responsable,
                                'estado' => 1,
                                'concepto_cuota' => 'Anticipo', 
                                'monto_acordado' => $acuerdo->propuesta->anticipo,
                                'vencimiento_cuota' => $acuerdo->propuesta->fecha_pago_anticipo,
                                'nro_cuota' => 0,
                                'usuario_ultima_modificacion_id' => auth()->user()->id,
                            ]);
                            $anticipo->save();
                        }
                    }
                }          
            }
            $finImportacion = microtime(true);
            $duracionImportacion = $finImportacion - $inicioImportacion;
            $tiempoMaximoPermitido = 1700;
            if($duracionImportacion > $tiempoMaximoPermitido) {
                DB::rollBack();
                return back()->withErrors(['error' => "Superaste el máximo de tiempo almacenar nuevos acuerdos"]);
            }
            //Mensajes
            $mensajes = [];
            if($propuestasRechazadas === 1) {
                $mensajes[] = "Una propuesta fue rechaza y cambio su estado a 'Rechazada'";
            } elseif ($propuestasRechazadas > 1) {
                $mensajes[] = "Se rechazaron {$propuestasRechazadas} propuestas y cambiaron su estado a 'Rechazada'";
            }
            if($propuestasAcuerdoPago === 1) {
                $mensajes[] = "Una propuesta cambio su estado a 'Acuerdo de Pago'";
            } elseif ($propuestasAcuerdoPago > 1) {
                $mensajes[] = "{$propuestasAcuerdoPago} propuestas cambiaron su estado a 'Acuerdo de Pago'";
            }
            if($acuerdosGenerados === 1) {
                $mensajes[] = "Se generó un nuevo Acuerdo de Pago";
            } elseif ($acuerdosGenerados > 1) {
                $mensajes[] = "Se generaron {$acuerdosGenerados} nuevos Acuerdos de Pago";
            }

            DB::commit();
            AcuerdoTemporal::truncate();
            return redirect()->route('acuerdos')->with('message', implode('<br>', $mensajes));
        } catch(\Exception $e) {
                DB::rollBack();
                $errorImportacion = 'Ocurrió un error inesperado. (' . $e->getMessage() . ')';
                return back()->withErrors(['error' => $errorImportacion]);
        }
        return redirect()->route('acuerdos')->with('message', 'Acuerdos generados correctamente');
    }
    
    public function pagos()
    {
        return view('acuerdos.pagos');
    }

    public function importarPagos()
    {
        return view('acuerdos.importar-pagos');
    }

    public function almacenarPagos(Request $request)
    {
        $request->validate([
            'importar'=> 'required|mimes:xls,xlsx|max:2048'
        ]);
        $inicioImportacion = microtime(true); //Se inicia la importacion
        ini_set('max_execution_time', 1860); //Tiempo máximo 31 minutos
        $excelImportacion = $request->file('importar');
        //Revisar que los encabezados coincidan con lo esperado
        $encabezadosEsperados = ['monto', 'cuil'];
        $encabezadosExcel = (new HeadingRowImport)->toArray($request->file('importar'))[0][0];
        foreach ($encabezadosEsperados as $encabezadoEsperado) {
            if (!in_array($encabezadoEsperado, $encabezadosExcel)) {
                return back()->withErrors(['error' => "Existe un error en un encabezado del archivo que estas importando. Revisa en el excel el nombre de la columna que corresponde a '$encabezadoEsperado'."]);
            }
        }
        try {
            DB::beginTransaction();
            $importacionTemporal = new ImportacionTemporalPagoImport;
            Excel::import($importacionTemporal, $excelImportacion);
            $pagosTemporales = ImportacionTemporalPago::all();
            $pagosAplicados = 0;
            foreach($pagosTemporales as $pagoTemporal) {
                $monto = $pagoTemporal->monto;
                $pago = Pago::where('monto', $monto)
                            ->where('estado', 1)
                            ->first();
                if($pago) {
                    $deudor =Deudor::where('cuil', $pagoTemporal->cuil)->get();
                    if($deudor) {
                        $pago->estado = 3;
                        $pago->usuario_ultima_modificacion_id = auth()->user()->id;
                    }
                    $pago->save();
                    $pagosAplicados ++;
                }
            }
            $finImportacion = microtime(true);
            $tiempoImportacion = $finImportacion - $inicioImportacion;
            $tiempoMaximoDeImportacion = 1200;
            if($tiempoImportacion > $tiempoMaximoDeImportacion) {
                DB::rollBack();
                return back()->withErrors(['error' => "Superaste el máximo de tiempo almacenar nuevos deudores y/o operaciones"]);
            }
            DB::commit();
            ImportacionTemporalPago::truncate();
            $mensajes = [];
            //Mensaje de documentos omitidos
            if ($pagosAplicados === 1) {
                $mensajes[] = "Se aplico correctamente un pago";
            } elseif ($pagosAplicados > 1) {
                $mensajes[] = "Se aplicaron {$pagosAplicados} pagos correctamente";
            } elseif ($pagosAplicados === 0) {
                $mensajes[] = "No se aplicaron pagos.";
            }
            return redirect()->route('pagos')->with('message', implode('<br>', $mensajes));
        } catch(\Exception $e) {
            DB::rollBack();
            $errorImportacion = 'Ocurrió un error inesperado en la importación. (' . $e->getMessage() . ')';
            return redirect()->route('importar.pagos')->withErrors(['error' => $errorImportacion]);
        }

        return view('acuerdos.importar-pagos');
    }

    public function informarpagos($pagoId)
    {
        return view('acuerdos.informar-pagos',[
            'pagoId'=>$pagoId
        ]);
    }

    public function show(Acuerdo $acuerdo)
    {
        $pagos = Pago::where('acuerdo_id', $acuerdo->id)
                 ->orderBy('vencimiento')
                 ->get();

        return view('acuerdos.acuerdo',[
            'pagos'=> $pagos,
            'acuerdo'=>$acuerdo
        ]);
    }

    

    public function subirComprobante(Pago $pago)
    {
        return view('acuerdos.subir-comprobante', [

            'pago'=>$pago
        ]);
    }
}
