<div class="border p-1 mt-1">
    @if($propuestasEnviadas->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($propuestasEnviadas as $propuestaEnviada)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 400px">
                    <h3 class="bg-blue-400 text-white uppercase py-1 text-center mb-1">{{$propuestaEnviada->deudorId->nombre}}</h3>
                    <!--Detalle de la operacion-->
                    <x-subtitulo-h-cuatro>
                        Detalle de la operación:
                    </x-subtitulo-h-cuatro>
                    <div class="p-1">
                        <p class="mt-1">Cliente:
                            <span class="font-bold">
                                {{ $propuestaEnviada->operacionId->clienteId->nombre }}
                            </span>
                        </p>
                        <p>DNI Deudor:
                            <span class="font-bold">
                                {{ $propuestaEnviada->deudorId->nro_doc }}
                            </span>
                        </p>
                        <p>Operación:
                            <span class="font-bold">
                                {{ $propuestaEnviada->operacionId->operacion }}
                            </span>
                        </p>
                        <p>Segmento:
                            <span class="font-bold">
                                @if ( $propuestaEnviada->operacionId->segmento)
                                    {{ $propuestaEnviada->operacionId->segmento }}
                                @else
                                    <span class="text-red-600">Sin datos </span>
                                @endif
                            </span>
                        </p>
                        <p>Producto:
                            <span class="font-bold">
                                {{ $propuestaEnviada->operacionId->productoId->nombre }}
                            </span>
                        </p>
                        <p>Deuda Capital: 
                            <span class="font-bold">
                                ${{ number_format($propuestaEnviada->operacionId->deuda_capital, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Fecha Asig.:
                            <span class="font-bold">
                                @if ( $propuestaEnviada->operacionId->fecha_asignacion)
                                    {{ \Carbon\Carbon::parse($propuestaEnviada->operacionId->fecha_asignacion)->format('d/m/Y') }}
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
                                {{$propuestaEnviada->id}}
                            </span>
                        </p>
                        <p>Agente: 
                            <span class="font-bold">
                                {{$propuestaEnviada->usuarioUltimaModificacion->name}}
                                {{$propuestaEnviada->usuarioUltimaModificacion->apellido}}
                            </span>
                        </p>
                        <p>Monto a Pagar: 
                            <span class="font-bold">
                                ${{ number_format($propuestaEnviada->monto_ofrecido, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Total ACP: 
                            <span class="font-bold">
                                ${{ number_format($propuestaEnviada->total_acp, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Honorarios: 
                            <span class="font-bold">
                                ${{ number_format($propuestaEnviada->honorarios, 2, ',', '.') }}
                            </span>
                        </p>
                        <p>Fecha Gestión: 
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($propuestaEnviada->created_at)->format('d/m/Y') }}
                            </span>
                        </p>
                        @if($propuestaEnviada->porcentaje_quita)
                            <p>% Quita: 
                                <span class="font-bold">
                                    {{ number_format($propuestaEnviada->porcentaje_quita, 2, ',', '.') }}%
                                </span>
                            </p>
                        @endif
                        <p>Fecha de Pago cuota: 
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($propuestaEnviada->fecha_pago_cuota)->format('d/m/Y') }}
                            </span>
                        </p>
                        @if($propuestaEnviada->anticipo)
                            <p>Anticipo: 
                                <span class="font-bold">
                                    ${{ number_format($propuestaEnviada->anticipo, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaEnviada->fecha_pago_anticipo)
                            <p>Fecha de Pago Anticipo: 
                                <span class="font-bold">
                                    {{ \Carbon\Carbon::parse($propuestaEnviada->fecha_pago_anticipo)->format('d/m/Y') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaEnviada->cantidad_de_cuotas_uno)
                            <p>Cantidad de Ctas (1): 
                                <span class="font-bold">
                                    {{ $propuestaEnviada->cantidad_de_cuotas_uno}}
                                </span>
                            </p>
                        @endif
                        @if($propuestaEnviada->monto_de_cuotas_uno)
                            <p>$ de Cuotas (1): 
                                <span class="font-bold">
                                    ${{ number_format($propuestaEnviada->monto_de_cuotas_uno, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaEnviada->cantidad_de_cuotas_dos)
                            <p>Cantidad de Ctas (2): 
                                <span class="font-bold">
                                    {{ $propuestaEnviada->cantidad_de_cuotas_dos}}
                                </span>
                            </p>
                        @endif
                        @if($propuestaEnviada->monto_de_cuotas_dos)
                            <p>$ de Cuotas (2): 
                                <span class="font-bold">
                                    ${{ number_format($propuestaEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($propuestaEnviada->cantidad_de_cuotas_tres)
                            <p>Cantidad de Ctas (3): 
                                <span class="font-bold">
                                    {{ $propuestaEnviada->cantidad_de_cuotas_dos}}
                                </span>
                            </p>
                        @endif
                        @if($propuestaEnviada->monto_de_cuotas_tres)
                            <p>$ de Cuotas (3): 
                                <span class="font-bold">
                                    ${{ number_format($propuestaEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                    </div>
                    <!--botones-->
                    <div class="grid grid-cols-2 justify-center gap-1 text-sm text-center text-white">
                        @if($propuestaEnviada->tipo_de_propuesta == 1)
                            <p class="p-2 bg-blue-800">
                                <span class="font-bold">
                                    Cancelación
                                </span>
                            </p>
                        @elseif($propuestaEnviada->tipo_de_propuesta == 2)
                            <p class="p-2 bg-green-600">
                                <span class="font-bold">
                                    Cuotas Fijas
                                </span>
                            </p>
                        @elseif($propuestaEnviada->tipo_de_propuesta == 4)
                            <p class="p-2 bg-orange-600">
                                <span class="font-bold">
                                    Cuotas Variables
                                </span>
                            </p>
                        @endif
                        <button class="text-white text-sm bg-cyan-600 hover:bg-cyan-700"
                            wire:click="modalCambiarEstado({{ $propuestaEnviada->id }})">
                            Actualizar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay propuestas enviadas
        </p>
    @endif
    <!--Modal cambiar estado-->
    @if($modalCambiarEstado)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1">Confirmar cambiar estado de 
                <span class="font-bold">
                    Propuesta ID {{$propuestaSeleccionada->id}}
                </span>
            </p>
            <!--Contenedor Botones-->
            <div class="flex justify-center gap-2 mt-2">
                @php
                    $classesBtn ="text-white px-4 py-2 rounded text-sm"
                @endphp
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                        wire:click="confirmarCambiarEstado({{ $propuestaSeleccionada->id }})">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                        wire:click="cancelarCambiarEstado">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
</div>
