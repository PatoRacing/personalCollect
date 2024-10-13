<div class="border p-1 mt-1">
    @if($propuestasNoEnviadas->count())
        <button class="text-white text-sm bg-green-600 hover:bg-green-700 p-2.5 rounded mb-1"
            wire:click="confirmarExportar">
            Exportar
        </button>
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($propuestasNoEnviadas as $propuestaNoEnviada)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 400px">
                    <h3 class="bg-blue-400 text-white uppercase py-1 text-center mb-1">{{$propuestaNoEnviada->deudorId->nombre}}</h3>
                    <!--Detalle de la operacion-->
                    <x-subtitulo-h-cuatro>
                        Detalle de la operación:
                    </x-subtitulo-h-cuatro>
                    <div class="p-1">
                        <p class="mt-1">Cliente:
                            <span class="font-bold">
                                {{ $propuestaNoEnviada->operacionId->clienteId->nombre }}
                            </span>
                        </p>
                        <p>DNI Deudor:
                            <span class="font-bold">
                                {{ $propuestaNoEnviada->deudorId->nro_doc }}
                            </span>
                        </p>
                        <p>Operación:
                            <span class="font-bold">
                                {{ $propuestaNoEnviada->operacionId->operacion }}
                            </span>
                        </p>
                        <p>Segmento:
                            <span class="font-bold">
                                @if ( $propuestaNoEnviada->operacionId->segmento)
                                    {{ $propuestaNoEnviada->operacionId->segmento }}
                                @else
                                    <span class="text-red-600">Sin datos </span>
                                @endif
                            </span>
                        </p>
                        <p>Producto:
                            <span class="font-bold">
                                {{ $propuestaNoEnviada->operacionId->productoId->nombre }}
                            </span>
                        </p>
                        <p>Deuda Capital: 
                            <span class="font-bold">
                                ${{ number_format($propuestaNoEnviada->operacionId->deuda_capital, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Fecha Asig.:
                            <span class="font-bold">
                                @if ( $propuestaNoEnviada->operacionId->fecha_asignacion)
                                    {{ \Carbon\Carbon::parse($propuestaNoEnviada->operacionId->fecha_asignacion)->format('d/m/Y') }}
                                @else
                                    <span class="text-red-600"> Sin datos </span>
                                @endif      
                            </span>
                        </p>
                    </div>
                    <!--Detalle de la propuesta-->
                    <x-subtitulo-h-cuatro>
                        Detalle de la Propuesta:
                    </x-subtitulo-h-cuatro>
                    <div class="p-1">
                        <p class="mt-1">Propuesta ID: 
                            <span class="font-bold">
                                {{$propuestaNoEnviada->id}}
                            </span>
                        </p>
                        <p>Agente: 
                            <span class="font-bold">
                                {{$propuestaNoEnviada->usuarioUltimaModificacion->name}}
                                {{$propuestaNoEnviada->usuarioUltimaModificacion->apellido}}
                            </span>
                        </p>
                        <p>Monto a Pagar: 
                            <span class="font-bold">
                                ${{ number_format($propuestaNoEnviada->monto_ofrecido, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Total ACP: 
                            <span class="font-bold">
                                ${{ number_format($propuestaNoEnviada->total_acp, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Honorarios: 
                            <span class="font-bold">
                                ${{ number_format($propuestaNoEnviada->honorarios, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Fecha Gestión: 
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($propuestaNoEnviada->created_at)->format('d/m/Y') }}
                            </span>
                        </p>
                        @if($propuestaNoEnviada->porcentaje_quita)
                            <p>% Quita: 
                                <span class="font-bold">
                                    {{ number_format($propuestaNoEnviada->porcentaje_quita, 2, ',', '.') }}%
                                </span>
                            </p>
                        @endif
                        <p>Fecha de Pago cuota: 
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($propuestaNoEnviada->fecha_pago_cuota)->format('d/m/Y') }}
                            </span>
                        </p>
                        @if($propuestaNoEnviada->anticipo)
                            <p>Anticipo: 
                                <span class="font-bold">
                                    ${{ number_format($propuestaNoEnviada->anticipo, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaNoEnviada->fecha_pago_anticipo)
                            <p>Fecha de Pago Anticipo: 
                                <span class="font-bold">
                                    {{ \Carbon\Carbon::parse($propuestaNoEnviada->fecha_pago_anticipo)->format('d/m/Y') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaNoEnviada->cantidad_de_cuotas_uno)
                            <p>Cantidad de Ctas (1): 
                                <span class="font-bold">
                                    {{ $propuestaNoEnviada->cantidad_de_cuotas_uno}}
                                </span>
                            </p>
                        @endif
                        @if($propuestaNoEnviada->monto_de_cuotas_uno)
                            <p>$ de Cuotas (1): 
                                <span class="font-bold">
                                    ${{ number_format($propuestaNoEnviada->monto_de_cuotas_uno, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaNoEnviada->cantidad_de_cuotas_dos)
                            <p>Cantidad de Ctas (2): 
                                <span class="font-bold">
                                    {{ $propuestaNoEnviada->cantidad_de_cuotas_dos}}
                                </span>
                            </p>
                        @endif
                        @if($propuestaNoEnviada->monto_de_cuotas_dos)
                            <p>$ de Cuotas (2): 
                                <span class="font-bold">
                                    ${{ number_format($propuestaNoEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaNoEnviada->cantidad_de_cuotas_tres)
                            <p>Cantidad de Ctas (3): 
                                <span class="font-bold">
                                    {{ $propuestaNoEnviada->cantidad_de_cuotas_dos}}
                                </span>
                            </p>
                        @endif
                        @if($propuestaNoEnviada->monto_de_cuotas_tres)
                            <p>$ de Cuotas (3): 
                                <span class="font-bold">
                                    ${{ number_format($propuestaNoEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                    </div>
                    <!--botones-->
                    <div class="grid grid-cols-2 justify-center gap-1 text-sm text-center text-white">
                        @if($propuestaNoEnviada->tipo_de_propuesta == 1)
                            <p class="p-2 bg-blue-800">
                                <span class="font-bold">
                                    Cancelación
                                </span>
                            </p>
                        @elseif($propuestaNoEnviada->tipo_de_propuesta == 2)
                            <p class="p-2 bg-green-600">
                                <span class="font-bold">
                                    Cuotas Fijas
                                </span>
                            </p>
                        @elseif($propuestaNoEnviada->tipo_de_propuesta == 4)
                            <p class="p-2 bg-orange-600">
                                <span class="font-bold">
                                    Cuotas Variables
                                </span>
                            </p>
                        @endif
                        <a href="{{route('nueva.gestion', ['operacion'=>$propuestaNoEnviada->operacion_id])}}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-center p-2">
                            Ver
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay propuestas sin enviar
        </p>
    @endif
    <!--Modal confirmar exportacion-->
    @if($modalConfirmarExportacion)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1">Confirmar exportar
                <span class="font-bold">
                    {{$totalPropuestasNoEnviadas}} propuestas
                </span>
            </p>
            <!--Contenedor Botones-->
            <div class="flex justify-center gap-2 mt-2">
                @php
                    $classesBtn ="text-white px-4 py-2 rounded text-sm"
                @endphp
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                        wire:click="confirmarExportarPropuestas">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                        wire:click="cancelarExportarPropuestas">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
</div>
