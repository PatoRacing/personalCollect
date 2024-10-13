<?php

namespace App\Http\Controllers;

use App\Imports\ImportacionTemporalPagoImport;
use App\Models\Deudor;
use App\Models\ImportacionTemporalPago;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class PagoController extends Controller
{
    public function index()
    {
        return view('cuotas.cuotas');
    }
    
    public function gestionCuota(Pago $cuota)
    {
        return view('cuotas.gestion-cuotas',[
            'cuota'=>$cuota
        ]);
    }

    public function gestionCuotaAdm(Pago $cuota)
    {
        return view('cuotas.gestion-cuota-administrador',[
            'cuota'=>$cuota
        ]);
    }

    public function gestionCancelacionAdm(Pago $cuota)
    {
        return view('cuotas.gestion-cancelacion-administrador',[
            'cuota'=>$cuota
        ]);
    }

    public function gestionCuotaSaldoExcedenteAdm(Pago $cuota)
    {
        return view('cuotas.gestion-cuota-saldo-excedente-administrador',[
            'cuota'=>$cuota
        ]);
    }

    public function gestionCuotaAgt(Pago $cuota)
    {
        return view('cuotas.gestion-cuota-agente',[
            'cuota'=>$cuota
        ]);
    }

    public function gestionCancelacionAgt(Pago $cuota)
    {
        return view('cuotas.gestion-cancelacion-agente',[
            'cuota'=>$cuota
        ]);
    }

    public function gestionCuotaSaldoExcedenteAgt(Pago $cuota)
    {
        return view('cuotas.gestion-cuota-saldo-excedente-agente',[
            'cuota'=>$cuota
        ]);
    }

    public function importarPagos()
    {
        return view('pagos.importar-pagos');
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
        $encabezadosEsperados = ['monto', 'cuil', 'cuenta','sucursal', 'fecha'];
        $encabezadosExcel = (new HeadingRowImport())->toArray($request->file('importar'))[0][0];
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
            $pagosAplicadosArray = [];
            $pagosNoAplicados = [];
            foreach($pagosTemporales as $key => $pagoTemporal) {
                $monto = $pagoTemporal->monto;
                $pago = Pago::where('monto', $monto)
                            ->where('estado', 1)
                            ->first();
                if($pago) {
                    if ($pago->concepto == 'Anticipo') {
                        $nroFila = $key + 2; 
                        $pagosNoAplicados[] = $nroFila; //El pago es un anticipo
                    } else {
                        $deudor = Deudor::where('cuil', $pagoTemporal->cuil)->first();
                        if($deudor) {
                            $pago->estado = 3;
                            $pago->usuario_ultima_modificacion_id = auth()->user()->id;
                            $pago->save();
                            $pagosAplicados++;
                            $nroFila = $key + 2; 
                            $pagosAplicadosArray[] = $nroFila;
                        } else {
                            $nroFila = $key + 2; 
                            $pagosNoAplicados[] = $nroFila; //No hay cuil para ese pago
                        }
                    }
                } else {
                    $nroFila = $key + 2; 
                    $pagosNoAplicados[] = $nroFila; //El pago no tiene un monto exacto
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
    }

    public function informarpagos($pagoId)
    {
        return view('pagos.informar-pagos',[
            'pagoId'=>$pagoId
        ]);
    }
}
