<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título del PDF</title>
    <style>
        /* Estilos CSS para el PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }
        .container {
            width: 95%;
            margin: 10px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="container">
    <div style="text-align: center; padding: 2px; margin-bottom: 0;">
        @php
            $imagePath = public_path('img/isologo_fondoazul.png');
            $imageData = base64_encode(file_get_contents($imagePath));
            $base64Image = 'data:image/png;base64,' . $imageData;
        @endphp
        <img src="{{ $base64Image }}" alt="Isologo"  style="width: 120px; height: auto;">
        <h1>ACUERDO DE PAGO</h1>
    </div>
    <div class="container">
        <div style="float: left; width: 50%; margin-right: 10px;">
            <h3>INFORMACIÓN GENERAL:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Fecha:</th>
                        <td>{{ \Carbon\Carbon::parse($acuerdo->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>DNI:</th>
                        <td>{{ $acuerdo->propuesta->deudorId->nro_doc }}</td>
                    </tr>
                    <tr>
                        <th>Nombre</th>
                        <td>{{$acuerdo->propuesta->deudorId->nombre}}</td>
                    </tr>
                    <tr>
                        <th>Cliente:</th>
                        <td>{{$acuerdo->propuesta->operacionId->clienteId->nombre}}</td>
                    </tr>
                    <tr>
                        <th>Producto:</th>
                        <td>{{ $acuerdo->propuesta->operacionId->productoId->nombre }}</td>
                    </tr>
                    <tr>
                        <th>Nro. Operación:</th>
                        <td>{{ $acuerdo->propuesta->operacionId->operacion }}</td>
                    </tr>
                    <tr>    
                        <th>Deuda Capital:</th>
                        <td>${{ number_format($acuerdo->propuesta->operacionId->deuda_capital, 2, ',', '.') }}</td>
                    </tr>>
                    <tr>
                        <th>Responsable:</th>
                        <td>
                            {{$acuerdo->usuarioUltimaModificacion->name}}
                            {{$acuerdo->usuarioUltimaModificacion->apellido}}
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="float: left; width: 50%">
            <h3>DETALLE DEL ACUERDO:</h3>
            <table>
                <thead>
                    <tr>
                        <th>$ a Pagar</th>
                        <td>${{ number_format($acuerdo->propuesta->monto_ofrecido, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Tipo de Propuesta:</th>
                        <td>
                            @if($acuerdo->propuesta->tipo_de_propuesta == 1)
                                Cancelación
                            @elseif($acuerdo->propuesta->tipo_de_propuesta == 2)
                                Cuotas Fijas
                            @elseif($acuerdo->propuesta->tipo_de_propuesta == 3)
                                Cuotas con descuento
                            @elseif($acuerdo->propuesta->tipo_de_propuesta == 4)
                                Cuotas Variables
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>% de Quita:</th>
                        <td>
                            @if(!$acuerdo->propuesta->porcentaje_quita)
                                -
                            @else
                                {{ number_format($acuerdo->propuesta->porcentaje_quita, 2, ',', '.') }}%
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Anticipo:</th>
                        <td>
                            @if(!$acuerdo->propuesta->anticipo)
                                -
                            @else
                                ${{ number_format($acuerdo->propuesta->anticipo, 2, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha Pago Anticipo:</th>
                        <td>
                            @if(!$acuerdo->propuesta->fecha_pago_anticipo)
                                -
                            @else
                                {{ \Carbon\Carbon::parse($acuerdo->propuesta->fecha_pago_anticipo)->format('d/m/Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Cant. Cuotas:</th>
                        @php
                            $cantidadCuotas = 
                                $acuerdo->propuesta->cantidad_de_cuotas_uno + 
                                $acuerdo->propuesta->cantidad_de_cuotas_dos + 
                                $acuerdo->propuesta->cantidad_de_cuotas_tres 
                        @endphp
                        <td>
                            @if($cantidadCuotas > 0)
                                {{$cantidadCuotas}}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @if(!$acuerdo->propuesta->monto_de_cuotas_uno)
                        <tr>
                            <th>$ de Cuotas:</th>
                            <td>-</td>
                        </tr>
                    @elseif(!$acuerdo->propuesta->monto_de_cuotas_dos)
                        <tr>
                            <th>$ de Cuotas:</th>
                            <td>${{ number_format($acuerdo->propuesta->monto_de_cuotas_uno, 2, ',', '.') }}</td>
                        </tr>
                    @elseif(!$acuerdo->propuesta->monto_de_cuotas_tres)
                        <tr>
                            <th>$ de Cuotas (1):</th>
                            <td>${{ number_format($acuerdo->propuesta->monto_de_cuotas_uno, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>$ de Cuotas (2):</th>
                            <td>${{ number_format($acuerdo->propuesta->monto_de_cuotas_dos, 2, ',', '.') }}</td>
                        </tr>
                    @else
                        <tr>
                            <th>$ de Cuotas (1):</th>
                            <td>${{ number_format($acuerdo->propuesta->monto_de_cuotas_uno, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>$ de Cuotas (2):</th>
                            <td>${{ number_format($acuerdo->propuesta->monto_de_cuotas_dos, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>$ de Cuotas (3):</th>
                            <td>${{ number_format($acuerdo->propuesta->monto_de_cuotas_tres, 2, ',', '.') }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>$ ACP</th>
                        <td>${{ number_format($acuerdo->propuesta->total_acp, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>$ a Honorarios</th>
                        <td>${{ number_format($acuerdo->propuesta->honorarios, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>$ Total</th>
                        <td>${{ number_format($acuerdo->propuesta->monto_ofrecido, 2, ',', '.') }}</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div style="clear: both; text-align: center;" class="container">
        <h3 style="padding-top: 10px">DETALLE DE PAGOS:</h3>
        <table>
            <thead>
                <tr>
                    <th>Cuota</th>
                    <th>Fecha</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $informacionesAcuerdo = [];
                    if($acuerdo->propuesta->tipo_de_propuesta == 1) {
                        $informacionesAcuerdo[] = [
                            'cuota' => 1,
                            'fecha' => $acuerdo->propuesta->fecha_pago_cuota,
                            'importe' => $acuerdo->propuesta->monto_ofrecido,
                        ];
                    } elseif($acuerdo->propuesta->tipo_de_propuesta == 2 || $acuerdo->propuesta->tipo_de_propuesta == 3) {
                        $cantidadDeCuotas = $acuerdo->propuesta->cantidad_de_cuotas_uno;
                        $fechaInicial = \Carbon\Carbon::parse($acuerdo->propuesta->fecha_pago_cuota);
                        for($i = 1; $i <= $cantidadCuotas; $i++) {
                            $cuota = $i;
                            $fecha = $fechaInicial->clone()->addDays(30 * ($i - 1));
                            $importe = $acuerdo->propuesta->monto_de_cuotas_uno;
                            $informacionesAcuerdo[] = [
                                'cuota' => $cuota,
                                'fecha' => $fecha,
                                'importe' => $importe,
                            ];
                        }
                    } elseif ($acuerdo->propuesta->tipo_de_propuesta == 4) {
                        $cantidadCuotasUno = $acuerdo->propuesta->cantidad_de_cuotas_uno;
                        $cantidadCuotasDos = $acuerdo->propuesta->cantidad_de_cuotas_dos;
                        $cantidadCuotasTres = $acuerdo->propuesta->cantidad_de_cuotas_tres ?? 0;
                        $fechaPagoInicial = \Carbon\Carbon::parse($acuerdo->propuesta->fecha_pago_cuota);
                        $fechaVencimientoUno = $fechaPagoInicial->copy();
                        $fechaVencimientoDos = null;
                        $fechaVencimientoTres = null;
                        for ($i = 1; $i <= $cantidadCuotasUno; $i++) {
                            $monto = $acuerdo->propuesta->monto_de_cuotas_uno;
                            
                            $informacionesAcuerdo[] = [
                                'cuota' => $i,
                                'fecha' => $fechaVencimientoUno->copy(),
                                'importe' => $monto,
                            ];
                            $fechaVencimientoUno->addDays(30);
                        }
                        $fechaVencimientoDos = $fechaPagoInicial->copy()->addDays(30 * $cantidadCuotasUno);
                        for ($i = 1; $i <= $cantidadCuotasDos; $i++) {
                            $monto = $acuerdo->propuesta->monto_de_cuotas_dos;
                            
                            $informacionesAcuerdo[] = [
                                'cuota' => $cantidadCuotasUno + $i,
                                'fecha' => $fechaVencimientoDos->copy(),
                                'importe' => $monto,
                            ];
                            $fechaVencimientoDos->addDays(30);
                        }
                        if ($cantidadCuotasTres > 0) {
                            $fechaVencimientoTres = $fechaVencimientoDos->copy();
                            for ($i = 1; $i <= $cantidadCuotasTres; $i++) {
                                $monto = $acuerdo->propuesta->monto_de_cuotas_tres;

                                $informacionesAcuerdo[] = [
                                    'cuota' => $cantidadCuotasUno + $cantidadCuotasDos + $i,
                                    'fecha' => $fechaVencimientoTres->copy(),
                                    'importe' => $monto,
                                ];
                                $fechaVencimientoTres->addDays(30);
                            }
                        }
                    }
                @endphp
                @foreach ($informacionesAcuerdo as $informacionAcuerdo)
                    <tr> <td>{{$informacionAcuerdo['cuota']}}</td>
                        <td>{{ \Carbon\Carbon::parse($informacionAcuerdo['fecha'])->format('d/m/Y') }}</td>
                        <td>${{ number_format($informacionAcuerdo['importe'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="page-break-after: always;"></div>
    <h3 style="text-align: center">MEDIOS DE PAGO:</h3>
    <div class="container">
        <div style="float: left; width: 50%; margin-right: 10px;">
            <table>
                <thead>
                    <tr>
                        <th>Forma de Pago:</th>
                        <td>Transferencia / Depósito</td>
                    </tr>
                    <tr>
                        <th>N° de Cuenta:</th>
                        <td>501/02131868/45</td>
                    </tr>
                    <tr>
                        <th>CBU</th>
                        <td>01505016/0200013186845/8</td>
                    </tr>
                    <tr>
                        <th>Alias:</th>
                        <td>pcollect6845</td>
                    </tr>
                    <tr>
                        <th>Titular:</th>
                        <td>Personal Collect SA</td>
                    </tr>
                    <tr>
                        <th>CUIT:</th>
                        <td>30-70742360-5</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="float: left; width: 50%">
            <table>
                <thead>
                    <tr>
                        <th>Forma de Pago:</th>
                        <td>Transferencia / Depósito</td>
                    </tr>
                    <tr>
                        <th>N° de Cuenta:</th>
                        <td>0501/02108568/25</td>
                    </tr>
                    <tr>
                        <th>CBU</th>
                        <td>01505016/0200010856825/3</td>
                    </tr>
                    <tr>
                        <th>Alias:</th>
                        <td>pcollect6825</td>
                    </tr>
                    <tr>
                        <th>Titular:</th>
                        <td>Personal Collect SA</td>
                    </tr>
                    <tr>
                        <th>CUIT:</th>
                        <td>30-70742360-5</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <h3 style="clear: both; color: red; text-align: center; padding-top: 10px;">NO REALIZAR PAGO COMO CLIENTE EN GESTIÓN ACTIVA</h3>
    <div class="container" style="border: 1px solid #000; padding: 8px;">
        <p> * El plan de pagos y la financiación ofrecida mantendrá vigencia siempre que se verifique el
                cumplimiento de cada una de las cuotas pactadas.
        </p>
        <p> * Una vez realizada la transferencia o el depósito, informar el pago adjuntando el comprobante
                de pago al siguiente contacto: WhatsApp 1155823673 - Mail:  recepcion@personalcollect.com.ar
        </p>
        <p> * El libre deuda lo deberá tramitar en cualquier sucursal de ICBC. Opcionalmente puede
                solicitar la carta de pago o recibo cancelatorio en el estudio al siguiente contacto:
                WhatsApp 1155823673 - Mail: recepcion@personalcollect.com.ar web www.personalcollect.com.ar              
        </p>
        <p> *  Puede encontrarnos como agente de cobranzas del Banco ICBC en la página oficial del
                Banco www.icbc.com.ar              
        </p>
    </div>
    @php
    $imagePath = public_path('img/firma.jpg');
        $imageData = base64_encode(file_get_contents($imagePath));
        $base64Image = 'data:image/jpeg;base64,' . $imageData;
    @endphp
    <div style="text-align: center;">
        <img src="{{ $base64Image }}" alt="Firma" style="display: block; margin: 0 auto; width: 70px; height: auto; margin-top: 20px;">
    </div>
</body>
</html>
