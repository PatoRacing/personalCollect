<div class="border p-1 mt-1">
    <div>
        <livewire:buscador-acuerdos-vigentes />
    </div>
    @if($acuerdosVigentes->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($acuerdosVigentes as $acuerdoVigente)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 400px">
                    <a class="bg-blue-400 mb-1 text-white uppercase py-1 text-center block hover:bg-blue-500 cursor-pointer"
                        href="{{ route('deudor.perfil', ['deudor' => $acuerdoVigente->propuesta->deudorId->id]) }}">
                        @if($acuerdoVigente->propuesta->deudorId->nombre)
                            {{$acuerdoVigente->propuesta->deudorId->nombre}}
                        @else
                            <span class="text-red-600">Sin datos</span>
                        @endif
                    </a>
                    <!--Detalle del Acuerdo-->
                    <x-subtitulo-h-cuatro>
                        Detalle del Acuerdo:
                    </x-subtitulo-h-cuatro>
                    <div class="p-1">
                        <p class="mt-1">Cliente:
                            <span class="font-bold">
                                {{ $acuerdoVigente->propuesta->operacionId->clienteId->nombre }}
                            </span>
                        </p>
                        <p>Responsable:
                            <span class="font-bold">
                                {{ $acuerdoVigente->usuarioResponsable->name }}
                                {{ $acuerdoVigente->usuarioResponsable->apellido }}
                            </span>
                        </p>
                        <p>Creado:
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($acuerdoVigente->created_at)->format('d/m/Y') }}
                            </span>
                        </p>
                        <p>DNI Deudor:
                            <span class="font-bold">
                                {{ $acuerdoVigente->propuesta->deudorId->nro_doc }}
                            </span>
                        </p>
                        <p>Operación:
                            <span class="font-bold">
                                {{ $acuerdoVigente->propuesta->operacionId->operacion}}
                            </span>
                        </p>
                        <p>Segmento:
                            <span class="font-bold">
                                @if ( $acuerdoVigente->propuesta->operacionId->segmento )
                                    {{ $acuerdoVigente->propuesta->operacionId->segmento}}
                                @else
                                    <span class="text-red-600 font-bold">
                                        Sin datos
                                    </span>
                                @endif
                            </span>
                        </p>
                        <p>Producto:
                            <span class="font-bold">
                                {{ $acuerdoVigente->propuesta->operacionId->productoId->nombre}}
                            </span>
                        </p><p>$ a Pagar:
                            <span class="font-bold">
                                ${{ number_format($acuerdoVigente->propuesta->monto_ofrecido, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>$ ACP:
                            <span class="font-bold">
                                ${{ number_format($acuerdoVigente->propuesta->total_acp, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>$ Honorarios:
                            <span class="font-bold">
                                ${{ number_format($acuerdoVigente->propuesta->honorarios, 2, ',', '.') }}
                            </span>
                        </p>
                        @if($acuerdoVigente->propuesta->porcentaje_quita)
                            <p>% Quita: 
                                <span class="font-bold">
                                    {{ number_format($acuerdoVigente->propuesta->porcentaje_quita, 2, ',', '.') }}%
                                </span>
                            </p>
                        @endif
                        <p>Fecha de Pago: 
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($acuerdoVigente->propuesta->fecha_pago_cuota)->format('d/m/Y') }}
                            </span>
                        </p>
                        @if($acuerdoVigente->propuesta->anticipo)
                            <p>Anticipo: 
                                <span class="font-bold">
                                    ${{ number_format($acuerdoVigente->propuesta->anticipo, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($acuerdoVigente->propuesta->fecha_pago_anticipo)
                            <p>Fecha de Pago Anticipo: 
                                <span class="font-bold">
                                    {{ \Carbon\Carbon::parse($acuerdoVigente->propuesta->fecha_pago_anticipo)->format('d/m/Y') }}
                                </span>
                            </p>
                        @endif
                        @if($acuerdoVigente->propuesta->cantidad_de_cuotas_uno)
                            <p>Cantidad de Ctas (1): 
                                <span class="font-bold">
                                    {{ $acuerdoVigente->propuesta->cantidad_de_cuotas_uno}}
                                </span>
                            </p>
                        @endif
                        @if($acuerdoVigente->propuesta->monto_de_cuotas_uno)
                            <p>$ de Cuotas (1): 
                                <span class="font-bold">
                                    ${{ number_format($acuerdoVigente->propuesta->monto_de_cuotas_uno, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($acuerdoVigente->propuesta->cantidad_de_cuotas_dos)
                            <p>Cantidad de Ctas (2): 
                                <span class="font-bold">
                                    {{ $acuerdoVigente->propuesta->cantidad_de_cuotas_dos}}
                                </span>
                            </p>
                        @endif
                        @if($acuerdoVigente->propuesta->monto_de_cuotas_dos)
                            <p>$ de Cuotas (2): 
                                <span class="font-bold">
                                    ${{ number_format($acuerdoVigente->propuesta->monto_de_cuotas_dos, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($acuerdoVigente->propuesta->cantidad_de_cuotas_tres)
                            <p>Cantidad de Ctas (3): 
                                <span class="font-bold">
                                    {{ $acuerdoVigente->propuesta->cantidad_de_cuotas_dos}}
                                </span>
                            </p>
                        @endif
                        @if($acuerdoVigente->propuesta->monto_de_cuotas_tres)
                            <p>$ de Cuotas (3): 
                                <span class="font-bold">
                                    ${{ number_format($acuerdoVigente->propuesta->monto_de_cuotas_dos, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                    </div>
                    <!--botones-->
                    <div class="grid grid-cols-2 justify-center gap-1 text-sm text-center text-white">
                        @if($acuerdoVigente->propuesta->tipo_de_propuesta == 1)
                            <p class="p-2 bg-blue-800">
                                <span class="font-bold">
                                    Cancelación
                                </span>
                            </p>
                        @elseif($acuerdoVigente->propuesta->tipo_de_propuesta == 2)
                            <p class="p-2 bg-green-600">
                                <span class="font-bold">
                                    Cuotas Fijas
                                </span>
                            </p>
                        @elseif($acuerdoVigente->propuesta->tipo_de_propuesta == 4)
                            <p class="p-2 bg-orange-600">
                                <span class="font-bold">
                                    Cuotas Variables
                                </span>
                            </p>
                        @endif
                        <a href="{{ Storage::url('acuerdos/' . $acuerdoVigente->acuerdos_de_pago_pdf) }}"
                            class="text-white block rounded bg-indigo-600 py-2 hover:bg-indigo-700"
                            target="_blank">
                            Ver PDF
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay acuerdos vigentes
        </p>
    @endif
    @if($acuerdosVigentesTotales >= 30)
        <div class="my-5 pb-3">
            {{$acuerdosVigentes->links()}}
        </div>
    @endif
</div>

