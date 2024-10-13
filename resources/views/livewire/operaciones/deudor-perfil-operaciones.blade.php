<div class="p-1">
    @php
        $classesBtn ="text-white py-2 rounded text-sm"
    @endphp
    <x-subtitulo>
        Listado de Operaciones
    </x-subtitulo>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mt-1">
        @if($operacionesDeudor->count())
            @foreach($operacionesDeudor as $operacionDeudor)
                <div class="border border-gray-700 p-1">
                    <x-subtitulo-h-cuatro>
                        Operacion {{$operacionDeudor->operacion}}
                    </x-subtitulo-h-cuatro>
                    <div class="p-2">
                        <p>Cliente:
                            <span class="font-bold">
                                {{$operacionDeudor->clienteId->nombre }}
                            </span>
                        </p>
                        <p>Producto:
                            <span class="font-bold">
                                {{$operacionDeudor->productoId->nombre }}
                            </span>
                        </p>
                        <p>Fecha Asig:
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($operacionDeudor->fecha_asignacion)->format('d/m/Y') }}
                            </span>
                        </p>
                        @if($operacionDeudor->sub_producto)
                            <p>Subproducto:
                                <span class="font-bold">
                                    {{ucwords(strtolower($operacionDeudor->sub_producto))}}
                                </span>
                            </p>
                        @else
                            <p>Subproducto:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                        @if($operacionDeudor->segmento)
                            <p>Segmento:
                                <span class="font-bold">
                                    {{$operacionDeudor->segmento }}
                                </span>
                            </p>
                        @else
                            <p>Segmento:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>            
                        @endif
                        <p>Sucursal:
                            <span class="font-bold">
                                {{ucwords(strtolower($operacionDeudor->sucursal))}}
                            </span>
                        </p>
                        <p>Deuda Capital:
                            <span class="font-bold">
                                ${{ number_format($operacionDeudor->deuda_capital, 2, ',', '.') }}
                            </span>
                        </p>
                        @if($operacionDeudor->dias_atraso)
                            <p>Días Atraso:
                                <span class="font-bold">
                                    {{$operacionDeudor->dias_atraso }} días
                                </span>
                            </p>
                        @else
                            <p>Días Atraso:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                        @if($operacionDeudor->compensatorio)
                            <p>Compensatorio:
                                <span class="font-bold">
                                    ${{number_format($operacionDeudor->compensatorio, 2, ',', '.')}}
                                </span>
                            </p>
                        @else
                            <p>Días Compensatorio:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                        @if($operacionDeudor->punitivos)
                            <p>Punitivos:
                                <span class="font-bold">
                                    ${{number_format($operacionDeudor->punitivos, 2, ',', '.')}}
                                </span>
                            </p>
                        @else
                            <p>Punitivos:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                        @if($operacionDeudor->deuda_total)
                            <p>Deuda Total:
                                <span class="font-bold">
                                    ${{number_format($operacionDeudor->deuda_total, 2, ',', '.')}}
                                </span>
                            </p>
                        @else
                            <p>Deuda Total:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                        @if($operacionDeudor->estado)
                            <p>Estado:
                                <span class="font-bold">
                                    {{$operacionDeudor->estado}}
                                </span>
                            </p>
                        @else
                            <p>Estado:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                        @if($operacionDeudor->ciclo)
                            <p>Ciclo:
                                <span class="font-bold">
                                    {{$operacionDeudor->ciclo}}
                                </span>
                            </p>
                        @else
                            <p>Ciclo:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                        @if($operacionDeudor->acuerdo)
                            <p>Acuerdo:
                                <span class="font-bold">
                                    {{$operacionDeudor->acuerdo}}
                                </span>
                            </p>
                        @else
                            <p>Acuerdo:
                                <span class="font-bold">
                                    -
                                </span>
                            </p>
                        @endif
                    </div>
                    @php
                        $ultimaPropuesta = \App\Models\Propuesta::where('operacion_id', $operacionDeudor->id)->latest('created_at')->first();
                    @endphp
                    <div class="grid grid-cols-2 justify-center gap-1 mt-2">
                        @if($ultimaPropuesta)
                            @php
                                $buttonClass = match($ultimaPropuesta->estado ?? '') {
                                    'Propuesta de Pago' => 'bg-indigo-600',
                                    'Negociación' => 'bg-orange-500',
                                    'Incobrable' => 'bg-gray-700',
                                    'Acuerdo de Pago' => 'bg-green-600',
                                    'Rechazada' => 'bg-black',
                                    'Enviada' => 'bg-blue-400'
                                };
                            @endphp
                            <button class="{{$classesBtn}} {{ $buttonClass }} pointer-events-none">
                                {{$ultimaPropuesta->estado}}
                            </button>
                        @else
                            <button class="{{$classesBtn}} bg-gray-400 pointer-events-none">
                                Sin Gestión
                            </button>
                        @endif
                        @if($situacionDeudor && $situacionDeudor->resultado == 'Ubicado')
                            <a class="{{$classesBtn}} bg-green-600 hover:bg-green-700 text-center"
                                href="{{route('nueva.gestion', ['operacion'=>$operacionDeudor->id])}}">
                                Gestionar
                            </a>  
                        @else  
                            <span class="text-white text-sm text-center rounded bg-green-700 py-2 hover:bg-green-800 disabled cursor-not-allowed opacity-50" 
                                title="Primero debes ubicar al deudor">
                                Gestionar
                            </span>
                        @endif 
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center font-bold">
                Aún no hay Operaciones
            </p>
        @endif
    </div>
</div>
