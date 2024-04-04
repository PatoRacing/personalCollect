<div>
    @if($acuerdosVigentes->count())
        <div>
            <!--contenedor de acuerdos-->
            <div class="p-4 container grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach ($acuerdosVigentes as $acuerdoVigente)
                    <!--acuerdo-->
                    <div class="border rounded">
                        <div class="px-4 text-gray-600">
                            <!-- clases-->
                            @php
                                $classesSpan = "font-bold text-black";
                                $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-4 text-center py-4";
                                $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
                            @endphp
                            <!-- detalle acuerdo-->
                            <a class= "{{$classesNombre}} block hover:bg-blue-300"
                                href="{{ route('deudor.perfil', ['deudor' => $acuerdoVigente->propuesta->deudorId->id]) }}">
                                @if($acuerdoVigente->propuesta->deudorId->nombre)
                                    {{$acuerdoVigente->propuesta->deudorId->nombre}}
                                @else
                                    <span class="text-red-600">Sin datos</span>
                                @endif
                            </a>
                            <h3 class="{{$classesTitulo}}">Detalle del Acuerdo:</h3>
                            <p>Cliente:
                                <span class="{{$classesSpan}}">
                                    {{ $acuerdoVigente->propuesta->operacionId->clienteId->nombre }}
                                </span>
                            </p>
                            <p>Responsable: 
                                <span class="{{$classesSpan}}">
                                    {{ $acuerdoVigente->propuesta->usuarioUltimaModificacion->name }}
                                    {{ $acuerdoVigente->propuesta->usuarioUltimaModificacion->apellido }}
                                </span>
                            </p>
                            <p>DNI Deudor:
                                <span class="{{$classesSpan}}">
                                    {{ $acuerdoVigente->propuesta->deudorId->nro_doc }}
                                </span>
                            </p>
                            <p>Operación:
                                <span class="{{$classesSpan}}">
                                    {{ $acuerdoVigente->propuesta->operacionId->operacion}}</span></p>
                            <p>Segmento:
                                <span class="{{$classesSpan}}">
                                    @if ( $acuerdoVigente->propuesta->operacionId->segmento )
                                        {{ $acuerdoVigente->propuesta->operacionId->segmento}}
                                    @else
                                        <span class="text-red-600"> Sin datos </span>
                                    @endif
                                </span>
                            </p>
                            <p>Producto:
                                <span class="{{$classesSpan}}">
                                    {{ $acuerdoVigente->propuesta->operacionId->productoId->nombre}}
                                </span>
                            </p>
                            <p>$ a Pagar:
                                <span class="{{$classesSpan}}">
                                    ${{ number_format($acuerdoVigente->propuesta->monto_ofrecido, 2, ',', '.') }}
                                </span>
                            </p>
                            <p>$ ACP:
                                <span class="{{$classesSpan}}">
                                    ${{ number_format($acuerdoVigente->propuesta->total_acp, 2, ',', '.') }}
                                </span>
                            </p>
                            <p>$ Honorarios:
                                <span class="{{$classesSpan}}">
                                    ${{ number_format($acuerdoVigente->propuesta->honorarios, 2, ',', '.') }}
                                </span>
                            </p>
                            @if($acuerdoVigente->propuesta->porcentaje_quita)
                                <p>% Quita: 
                                    <span class="{{$classesSpan}}">
                                        {{ number_format($acuerdoVigente->propuesta->porcentaje_quita, 2, ',', '.') }}%
                                    </span>
                                </p>
                            @endif
                            <p>Fecha de Pago: 
                                <span class="{{$classesSpan}}">
                                    {{ \Carbon\Carbon::parse($acuerdoVigente->propuesta->fecha_pago_cuota)->format('d/m/Y') }}
                                </span>
                            </p>
                            @if($acuerdoVigente->propuesta->anticipo)
                                <p>Anticipo: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($acuerdoVigente->propuesta->anticipo, 2, ',', '.') }}
                                    </span>
                                </p>
                            @endif
                            @if($acuerdoVigente->propuesta->fecha_pago_anticipo)
                                <p>Fecha de Pago Anticipo: 
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($acuerdoVigente->propuesta->fecha_pago_anticipo)->format('d/m/Y') }}
                                    </span>
                                </p>
                            @endif
                            @if($acuerdoVigente->propuesta->cantidad_de_cuotas_uno)
                                <p>Cantidad de Ctas (1): 
                                    <span class="{{$classesSpan}}">
                                        {{ $acuerdoVigente->propuesta->cantidad_de_cuotas_uno}}
                                    </span>
                                </p>
                            @endif
                            @if($acuerdoVigente->propuesta->monto_de_cuotas_uno)
                                <p>$ de Cuotas (1): 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($acuerdoVigente->propuesta->monto_de_cuotas_uno, 2, ',', '.') }}
                                    </span>
                                </p>
                            @endif
                            @if($acuerdoVigente->propuesta->cantidad_de_cuotas_dos)
                                <p>Cantidad de Ctas (2): 
                                    <span class="{{$classesSpan}}">
                                        {{ $acuerdoVigente->propuesta->cantidad_de_cuotas_dos}}
                                    </span>
                                </p>
                            @endif
                            @if($acuerdoVigente->propuesta->monto_de_cuotas_dos)
                                <p>$ de Cuotas (2): 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($acuerdoVigente->propuesta->monto_de_cuotas_dos, 2, ',', '.') }}
                                    </span>
                                </p>
                            @endif
                            @if($acuerdoVigente->propuesta->cantidad_de_cuotas_tres)
                                <p>Cantidad de Ctas (3): 
                                    <span class="{{$classesSpan}}">
                                        {{ $acuerdoVigente->propuesta->cantidad_de_cuotas_dos}}
                                    </span>
                                </p>
                            @endif
                            @if($acuerdoVigente->propuesta->monto_de_cuotas_tres)
                                <p>$ de Cuotas (3): 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($acuerdoVigente->propuesta->monto_de_cuotas_dos, 2, ',', '.') }}
                                    </span>
                                </p>
                            @endif
                            <h3 class="{{$classesTitulo}}">
                                Estado:
                                @if($acuerdoVigente->estado === 1)
                                    Vigente
                                @elseif($acuerdoVigente->estado === 2)
                                    Cumplido
                                @elseif($acuerdoVigente->estado === 3)
                                    Incumplido
                                @endif
                            </h3>
                            <div class="flex gap-2 text-center uppercase">
                                <span class="{{$classesSpan}} w-full">
                                    <a href="{{ Storage::url('acuerdos/' . $acuerdoVigente->acuerdos_de_pago_pdf) }}"
                                        class="text-white block rounded bg-green-700 py-2 hover:bg-green-800"
                                        target="_blank">
                                        PDF Acuerdo de Pago
                                    </a>
                                </span>
                                <span class="{{$classesSpan}} w-full">
                                    <a href= "{{ route('acuerdo', ['acuerdo' => $acuerdoVigente->id]) }}"
                                        class="text-white block rounded bg-blue-800 py-2 hover:bg-blue-950">
                                        Ver Pagos
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-800 p-2 text-center font-bold">
            Sin Acuerdos de Pago
        </p>
    @endif
</div>
