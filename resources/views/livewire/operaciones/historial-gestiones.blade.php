<div class="border border-gray-700 p-1">
    <x-subtitulo>
        Historial de Gestiones
    </x-subtitulo>
    @if($propuestas->count())
        <!--Alertas-->
        @if($alertaMensaje)
            <div class="px-2 py-1 bg-{{$alertaTipo}}-100 border-l-4 border-{{$alertaTipo}}-600 text-{{$alertaTipo}}-800 text-sm font-bold mt-1">
                {{ $alertaMensaje }}
            </div>
        @endif
        <div class="p-2 grid md:grid-cols-2 gap-2 overflow-x-auto" style="max-height: 425px;">
            @foreach ($propuestas as $propuesta)
                <div class="p-2 border border-gray-700">
                    <x-subtitulo-h-cuatro>
                        Detalle de la gestión
                    </x-subtitulo-h-cuatro>
                    <p class="mt-2">Monto Total:
                        <span class="font-bold">
                            ${{number_format($propuesta->monto_ofrecido, 2, ',', '.')}}
                        </span>
                    </p>
                    <p>Tipo Propuesta:
                        @if($propuesta->tipo_de_propuesta == 1)
                            <span class="font-bold">
                                Cancelación
                            </span>
                        @elseif($propuesta->tipo_de_propuesta == 2)
                            <span class="font-bold">
                                Cuotas fijas
                            </span>
                        @else
                            <span class="font-bold">
                                Cuotas Variables
                            </span>
                        @endif
                    </p>
                    @if ($propuesta->porcentaje_quita)
                        @if($propuesta->porcentaje_quita < 0)
                            <p>Porcentaje Quita:
                                <span class="font-bold">
                                    {{ number_format(0, 2, ',', '.') }}%
                                </span>
                            </p>
                        @else
                            <p>Porcentaje Quita:
                                <span class="font-bold">
                                    {{number_format($propuesta->porcentaje_quita, 2, ',', '.')}}%
                                </span>
                            </p>
                        @endif
                    @endif
                    @if ($propuesta->anticipo)
                        <p>Anticipo:
                            <span class="font-bold">
                                ${{number_format($propuesta->anticipo, 2, ',', '.')}}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->fecha_pago_anticipo)
                        <p>Fecha de Pago anticipo:
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($propuesta->fecha_pago_anticipo)->format('d/m/Y') }}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->cantidad_de_cuotas_uno)
                        <p>Cantidad de Cuotas (Grupo 1):
                            <span class="font-bold">
                                {{$propuesta->cantidad_de_cuotas_uno}}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->monto_de_cuotas_uno)
                        <p>Monto (Grupo 1):
                            <span class="font-bold">
                                ${{number_format($propuesta->monto_de_cuotas_uno, 2, ',', '.')}}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->fecha_pago_cuota)
                        <p>Fecha de pago cuota:
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($propuesta->fecha_pago_cuota)->format('d/m/Y') }}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->cantidad_de_cuotas_dos)
                        <p>Cantidad de Cuotas (Grupo 2):
                            <span class="font-bold">
                                {{$propuesta->cantidad_de_cuotas_dos}}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->monto_de_cuotas_dos)
                        <p>Monto (Grupo 2):
                            <span class="font-bold">
                                ${{number_format($propuesta->monto_de_cuotas_dos, 2, ',', '.')}}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->cantidad_de_cuotas_tres)
                        <p>Cantidad de Cuotas (Grupo 3):
                            <span class="font-bold">
                                {{$propuesta->cantidad_de_cuotas_tres}}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->monto_de_cuotas_tres)
                        <p>Monto (Grupo 3):
                            <span class="font-bold">
                                ${{number_format($propuesta->monto_de_cuotas_tres, 2, ',', '.')}}
                            </span>
                        </p>
                    @endif
                    @if ($propuesta->vencimiento)
                        <p>Vencimiento:
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($propuesta->vencimiento)->format('d/m/Y') }}
                            </span>
                        </p>
                    @endif
                    <p>Agente:
                        <span class="font-bold">
                            {{$propuesta->usuarioUltimaModificacion->name}}
                            {{$propuesta->usuarioUltimaModificacion->apellido}}
                        </span>
                    </p>
                    <p>Fecha Gestión:
                        <span class="font-bold">
                            {{ \Carbon\Carbon::parse($propuesta->created_at)->format('d/m/Y') }}
                        </span>
                    </p>
                    <p>Observaciones:
                        <span class="font-bold">
                            {{$propuesta->observaciones}}
                        </span>
                    </p>
                    @php
                        $classesBtn ="text-white p-2 rounded text-sm";
                        if($propuesta->estado == 'Propuesta de Pago')
                            $classesEstado = "text-center text-white bg-cyan-600 py-2 text-sm rounded";
                        elseif($propuesta->estado == 'Negociación')
                            $classesEstado = "text-center text-white bg-indigo-600 py-2 text-sm rounded";
                        elseif($propuesta->estado == 'Incobrable')
                            $classesEstado = "text-center text-white bg-red-600 py-2 text-sm rounded";
                        elseif($propuesta->estado == 'Acuerdo de Pago')
                            $classesEstado = "text-center text-white bg-green-600 py-2 text-sm rounded";
                        elseif($propuesta->estado == 'Rechazada')
                            $classesEstado = "text-center text-white bg-black py-2 text-sm rounded";
                        elseif($propuesta->estado == 'Enviada')
                            $classesEstado = "text-center text-white bg-blue-300 py-2 text-sm rounded";
                        else 
                            $classesEstado = "text-center text-white bg-gray-600 py-2 text-sm rounded"
                    @endphp
                    <div class="grid grid-cols-2 justify-center gap-1 mt-1">
                        <p class="{{$classesEstado}}">
                            {{$propuesta->estado}}
                        </p>
                        @if($propuesta->estado == 'Negociación' || $propuesta->estado == 'Propuesta de Pago')
                            <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                    wire:click="mostrarModalEliminar({{ $propuesta->id }})">
                                Eliminar
                            </button> 
                        @else  
                            <span class="text-white text-sm text-center rounded bg-red-600 py-2 hover:bg-red-700 disabled cursor-not-allowed opacity-50" 
                                title="No puedes eliminar la gestión porque tiene una acción en curso">
                                Eliminar
                            </span>
                        @endif
                    </div>                    
                </div>
            @endforeach
        </div>
    @else
        <p class="p-2 font-bold text-center">La operación no tiene gestiones realizadas.</p>
    @endif
    <!--Modal eliminar telefono-->
    @if($modalEliminar)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1">Confirmar eliminar propuesta
                @if($propuestaSeleccionada->id)
                    <span class="font-bold">
                        ID {{$propuestaSeleccionada->id}}
                    </span>
                @endif
            </p>
            <!--Contenedor botones-->
            <div class="flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                        wire:click="confirmarEliminarPropuesta({{ $propuestaSeleccionada->id }})">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalEliminar">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif 
</div>
