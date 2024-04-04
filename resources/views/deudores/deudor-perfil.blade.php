@section('titulo')
    Perfil del Deudor
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-2 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">{{ucwords(strtolower($deudor->nombre))}}</h1>
                <a href="{{route('cartera')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                @if(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-4 p-3 ">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="px-14 py-4 my-4 lg:flex lg:items-center lg:justify-between text-sm
                            bg-white rounded border border-gray-200 border-1 text-gray-600">
                    <p>DNI: <span class="font-bold text-black">{{ number_format($deudor->nro_doc, 0, ',', '.') }}</span></p>
                    <p>Domicilio: <span class="font-bold text-black">{{ucwords(strtolower($deudor->domicilio))}}</span></p>
                    <p>Localidad: <span class="font-bold text-black">{{ucwords(strtolower($deudor->localidad))}}</span></p>
                    <p>Cod Postal: <span class="font-bold text-black">{{$deudor->codigo_postal}}</span></p>    
                </div>
                <div class="container mx-auto">
                    @php
                        $classesSpan = "font-bold text-black";
                        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
                    @endphp
                    <div class="flex bg-white p-4 rounded">

                        <!-- Columna 1 (2/3 del ancho) -->
                        <div class="w-2/3 px-6 border-r-2">

                            <!--gestion-->
                            <div class="mb-4 p-4">
                                <h2 class="text-center bg-gray-200 py-2 mb-4 font-bold uppercase">Gestiones sobre el deudor</h2>
                                <div class="flex gap-4">
                                    <!--info gestion-->
                                    <div class="w-1/2 border p-2 relative">
                                        @if($gestionesDeudor ->isEmpty())
                                            <p class="p-2"><span class="{{$classesSpan}}">No se han realizado gestiones</span></p>
                                        @else
                                            @if($ultimaGestion)
                                                @php
                                                    if($ultimaGestion->resultado == 'En proceso')
                                                        $classesUltimaGestion = "text-center text-white bg-indigo-600 py-2 font-bold rounded my-4 uppercase";
                                                    elseif ($ultimaGestion->resultado == 'Inubicable')
                                                        $classesUltimaGestion = "text-center text-white bg-orange-500 py-2 font-bold rounded my-4 uppercase";
                                                    elseif ($ultimaGestion->resultado === 'Fallecido')
                                                        $classesUltimaGestion = "text-center text-white bg-red-600 py-2 font-bold rounded my-4 uppercase";
                                                    else
                                                        $classesUltimaGestion = "text-center text-white bg-green-700 py-2 font-bold rounded my-4 uppercase";
                                                @endphp
                                                <h3 class="{{$classesUltimaGestion}}">Situación Deudor: {{$ultimaGestion->resultado}}</h3>
                                            @endif
                                            @foreach ($gestionesDeudor as $gestionDeudor)
                                                <p>Acción: <span class="{{$classesSpan}}">{{$gestionDeudor->accion}}</span></p>
                                                <p>Agente: 
                                                    <span class="{{$classesSpan}}">
                                                        {{$gestionDeudor->usuarioUltimaModificacion->name}}
                                                        {{$gestionDeudor->usuarioUltimaModificacion->apellido}}
                                                    </span>
                                                </p>
                                                <p>Fecha: 
                                                    <span class="{{$classesSpan}}">
                                                        {{ \Carbon\Carbon::parse($gestionDeudor->created_at)->format('d/m/Y - H:i' ) }} 
                                                    </span>
                                                </p>
                                                <p>Observaciones: <span class="{{$classesSpan}}">{{$gestionDeudor->observaciones}}</span></p>
                                            @endforeach
                                        @endif
                                        <div class="absolute bottom-0 left-0 right-0 my-3 p-2">
                                            {{$gestionesDeudor->links('pagination::simple-tailwind')}}
                                        </div>
                                    </div>
                                    <!--formulario de gestion-->
                                    <div class="w-1/2">
                                        <livewire:deudor-gestion :deudor="$deudor"/>
                                    </div>
                                </div>
                            </div>

                            <!--operacion-->
                            <div class="p-2">
                                <h2 class="text-center bg-gray-200 py-2 font-bold uppercase">Listado de operaciones</h2>
                                @if($operaciones->count())
                                    <div class="container grid grid-cols-1 gap-4 md:grid-cols-2">
                                        @foreach ($operaciones as $operacion)
                                            <div class="rounded">

                                                <!--info operacion-->
                                                <div class="p-2 text-gray-600 border-b">
                                                    <h3 class="{{$classesTitulo}}">Detalle de la Operación:</h3>
                                                    <p>Fecha Asig:
                                                        <span class="{{$classesSpan}}">
                                                            {{ \Carbon\Carbon::parse($operacion->fecha_asignacion)->format('d/m/Y') }}
                                                        </span>
                                                    </p>
                                                    <p>Operación:
                                                        <span class="{{$classesSpan}}">
                                                            {{$operacion->operacion}}
                                                        </span>
                                                    </p>
                                                    <p>Cliente:
                                                        <span class="{{$classesSpan}}">
                                                            {{$operacion->clienteId->nombre }}
                                                        </span>
                                                    </p>
                                                    <p>Producto:
                                                        <span class="{{$classesSpan}}">
                                                            {{$operacion->productoId->nombre }}
                                                        </span>
                                                    </p>
                                                    @if($operacion->sub_producto)
                                                        <p>Subproducto:
                                                            <span class="{{$classesSpan}}">
                                                                {{ucwords(strtolower($operacion->sub_producto))}}
                                                            </span>
                                                        </p>
                                                    @endif
                                                    @if($operacion->segmento)
                                                        <p>Segmento:
                                                            <span class="{{$classesSpan}}">
                                                                {{$operacion->segmento }}
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p>Segmento:
                                                            <span class="{{$classesSpan}}">
                                                                -
                                                            </span>
                                                        </p>            
                                                    @endif
                                                    <p>Sucursal:
                                                        <span class="{{$classesSpan}}">
                                                            {{ucwords(strtolower($operacion->sucursal))}}
                                                        </span>
                                                    </p>
                                                    <p>Deuda Capital:
                                                        <span class="{{$classesSpan}}">
                                                            ${{ number_format($operacion->deuda_capital, 2, ',', '.') }}
                                                        </span>
                                                    </p>
                                                    @if($operacion->dias_atraso)
                                                        <p>Días Atraso:
                                                            <span class="{{$classesSpan}}">
                                                                {{$operacion->dias_atraso }} días
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p>Días Atraso:
                                                            <span class="{{$classesSpan}}">
                                                                -
                                                            </span>
                                                        </p>
                                                    @endif
                                                    @if($operacion->compensatorio)
                                                        <p>Compensatorio:
                                                            <span class="{{$classesSpan}}">
                                                                ${{number_format($operacion->compensatorio, 2, ',', '.')}}
                                                            </span>
                                                        </p>
                                                    @endif
                                                    @if($operacion->punitivos)
                                                        <p>Punitivos:
                                                            <span class="{{$classesSpan}}">
                                                                ${{number_format($operacion->punitivos, 2, ',', '.')}}
                                                            </span>
                                                        </p>
                                                    @endif
                                                    <p>Deuda Total:
                                                        <span class="{{$classesSpan}}">
                                                            ${{number_format($operacion->deuda_total, 2, ',', '.')}}
                                                        </span>
                                                    </p>
                                                    @if($operacion->estado)
                                                        <p>Estado:
                                                            <span class="{{$classesSpan}}">
                                                                {{$operacion->estado}}
                                                            </span>
                                                        </p>
                                                    @endif
                                                    @if($operacion->ciclo)
                                                        <p>Ciclo:
                                                            <span class="{{$classesSpan}}">
                                                                {{$operacion->ciclo}}
                                                            </span>
                                                        </p>
                                                    @endif
                                                    @if($operacion->acuerdo)
                                                        <p>Acuerdo:
                                                            <span class="{{$classesSpan}}">
                                                                {{$operacion->acuerdo}}
                                                            </span>
                                                        </p>
                                                    @endif
                                                    
                                                    @if($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id)
                                                        <p>Últ. Gestión:
                                                            <span class="{{$classesSpan}}">
                                                                {{$ultimaPropuesta->usuarioUltimaModificacion->name }}
                                                                {{$ultimaPropuesta->usuarioUltimaModificacion->apellido }}
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p>Últ. Gestión:
                                                            <span class="{{$classesSpan}}">
                                                                -
                                                            </span>
                                                        </p>
                                                    @endif
                                                    @if($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id)
                                                        <p>Fecha:
                                                            <span class="{{$classesSpan}}">
                                                                {{ \Carbon\Carbon::parse($ultimaPropuesta->updated_at)->format('d/m/Y - H:i:s') }}
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p>Fecha:
                                                            <span class="{{$classesSpan}}">
                                                                -
                                                            </span>
                                                        </p>
                                                    @endif
                                                </div>

                                                <!--info ultima gestión-->
                                                <div>
                                                    @php
                                                        if($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Propuesta de Pago')
                                                            $classesEstado = "text-center text-white bg-indigo-600 py-2 font-bold rounded uppercase";
                                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Negociación')
                                                            $classesEstado = "text-center text-white bg-orange-500 py-2 font-bold rounded uppercase";
                                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Incobrable')
                                                            $classesEstado = "text-center text-white bg-red-600 py-2 font-bold rounded uppercase";
                                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Acuerdo de Pago')
                                                            $classesEstado = "text-center text-white bg-green-700 py-2 font-bold rounded uppercase";
                                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Rechazada')
                                                            $classesEstado = "text-center text-white bg-black py-2 font-bold rounded uppercase";
                                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Enviada')
                                                            $classesEstado = "text-center text-white bg-blue-300 py-2 font-bold rounded uppercase";
                                                        else 
                                                            $classesEstado = "text-center text-white bg-gray-600 py-2 font-bold rounded uppercase"
                                                    @endphp
                                                    <h2 class= "{{$classesEstado}}">Estado:
                                                        @if($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id)
                                                            {{$ultimaPropuesta->estado }}
                                                        @else
                                                            <span>Sin gestión</span>
                                                        @endif
                                                    </h2>
                                                </div>

                                                <!--botones-->
                                                <div class="p-2 justify-end flex">
                                                    @if($ultimaGestion && $ultimaGestion->resultado == 'Ubicado')
                                                        <a href="{{ route('propuesta', ['operacion' => $operacion->id]) }}"
                                                            class="text-white rounded bg-green-700 px-5 py-2 hover:bg-green-800">
                                                            Nueva Gestión
                                                        </a>
                                                    @else
                                                        <span class="text-white rounded bg-green-700 px-5 py-2 hover:bg-green-800 disabled cursor-not-allowed opacity-50" 
                                                            title="Primero debes ubicar al deudor">
                                                            Nueva Gestión
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    Sin operaciones
                                @endif
                            </div>
                        </div>

                        <!-- Columna 2 (1/3 del ancho) con overflow -->
                        <div class="w-1/3 px-8 ">
                            <h2 class="{{$classesTitulo}}">Listado de teléfonos</h2> 
                            <livewire:nuevo-telefono :deudorId="$deudorId"/>
                            @if($telefonos->count())
                                <div class="overflow-y-auto" style="max-height: calc(100vh - 150px);">
                                    @foreach ($telefonos as $index => $telefono)
                                        <div class="border p-4 {{ $index % 2 == 0 ? 'bg-blue-100' : 'bg-white' }}">
                                            <p>Tipo: <span class="{{$classesSpan}}">{{$telefono->tipo}}</span></p>
                                            <p>Contacto: <span class="{{$classesSpan}}">{{$telefono->contacto}}</span></p>
                                            @if(!$telefono->email)
                                                <p>Número:
                                                    <span class="{{$classesSpan}}">
                                                        {{$telefono->numero}}
                                                    </span>
                                                </p>
                                            @elseif(!$telefono->numero)
                                                <p>Email:
                                                    <span class="{{$classesSpan}}">
                                                        {{$telefono->email}}
                                                    </span>
                                                </p>
                                            @elseif($telefono->numero && $telefono->email)
                                            <p>Teléfono:
                                                <span class="{{$classesSpan}}">
                                                    {{$telefono->numero}}
                                                </span>
                                            </p>
                                            <p>Email:
                                                <span class="{{$classesSpan}}">
                                                    {{$telefono->email}}
                                                </span>
                                            </p>
                                            @endif
                                            <p>Ult. Modificación:
                                                <span class="{{$classesSpan}}">
                                                    {{$telefono->usuarioUltimaModificacion->name }}
                                                    {{$telefono->usuarioUltimaModificacion->apellido }}
                                                </span>
                                            </p>
                                            <p class="mb-2">Fecha:
                                                <span class="{{$classesSpan}}">
                                                    {{ \Carbon\Carbon::parse($telefono->updated_at)->format('d/m/Y - H:i:s') }}
                                                </span>
                                            </p>
                                            <livewire:estado-telefono :telefono="$telefono"/>
                                            <livewire:actualizar-telefono :telefono="$telefono" />
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>
                                    <span class="{{$classesSpan}}">
                                        El deudor no tiene teléfonos.
                                    </span>
                                    
                                </p>
                            @endif               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
