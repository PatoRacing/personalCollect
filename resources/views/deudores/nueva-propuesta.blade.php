@section('titulo')
    Propuesta de Pago
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="pt-4 sticky left-0">
                <!--Titulo-->
                <div class="font-bold uppercase bg-gray-200 p-4 text-gray-900 hover:text-gray-500 text-center mb-5 flex items-center justify-center space-x-8">
                    <h1 class="text-black">{{ucwords(strtolower($operacion->deudorId->nombre))}}</h1>
                </div>
                <a href="{{ route('deudor.perfil', ['deudor' => $operacion->deudor_id]) }}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                
                <!--Classes-->
                @php
                    $classesSpan = "font-bold text-black";
                    $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded uppercase";
                @endphp
                
                <div class="p-2 bg-white rounded border border-gray-200 border-1 mt-6">

                    <!--Detalle telefono y operaciones anteriores-->
                    <div class="flex gap-1 mb-4">

                        <!--Detalle de operacion-->
                        <div class="w-1/4 p-2 bg-blue-200 ">
                            <h2 class="text-center bg-white py-2 mb-4 font-bold uppercase">Detalle:</h2>
                            <div class="p-2">
                                <p class="mb-0.5">Fecha Asig:
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($operacion->fecha_asignacion)->format('d/m/Y') }}
                                    </span>
                                </p>
                                <p class="mb-0.5">Operación:
                                    <span class="{{$classesSpan}}">
                                        {{$operacion->operacion}}
                                    </span>
                                </p>
                                <p class="mb-0.5">Cliente:
                                    <span class="{{$classesSpan}}">
                                        {{ucwords(strtolower($operacion->clienteId->nombre))}}
                                    </span>
                                </p>
                                <p class="mb-0.5">Producto:
                                    <span class="{{$classesSpan}}">
                                        {{ucwords(strtolower($operacion->productoId->nombre))}}
                                    </span>
                                </p>
                                @if($operacion->sub_producto)
                                    <p class="mb-0.5">Subproducto:
                                        <span class="{{$classesSpan}}">
                                            {{ucwords(strtolower($operacion->sub_producto))}}
                                        </span>
                                    </p>
                                @endif
                                @if($operacion->segmento)
                                    <p class="mb-0.5">Segmento:
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
                                <p class="mb-0.5">Sucursal:
                                    <span class="{{$classesSpan}}">
                                        {{ucwords(strtolower($operacion->sucursal))}}
                                    </span>
                                </p>
                                <p class="mb-0.5">Deuda Capital:
                                    <span class="{{$classesSpan}}">
                                        ${{number_format($operacion->deuda_capital, 2, ',', '.')}}
                                    </span>
                                </p>
                                <p class="mb-0.5">Días Atraso:
                                    <span class="{{$classesSpan}}">
                                        {{$operacion->dias_atraso}} días
                                    </span>
                                </p>
                                @if($operacion->compensatorio)
                                    <p class="mb-0.5">Compensatorio:
                                        <span class="{{$classesSpan}}">
                                            ${{number_format($operacion->compensatorio, 2, ',', '.')}}
                                        </span>
                                    </p>
                                @endif
                                @if($operacion->punitivos)
                                    <p class="mb-0.5">Punitivos:
                                        <span class="{{$classesSpan}}">
                                            ${{number_format($operacion->punitivos, 2, ',', '.')}}
                                        </span>
                                    </p>
                                @endif
                                <p class="mb-0.5">Deuda Total:
                                    <span class="{{$classesSpan}}">
                                        ${{number_format($operacion->deuda_total, 2, ',', '.')}}
                                    </span>
                                </p>
                                @if($operacion->estado)
                                    <p class="mb-0.5">Estado:
                                        <span class="{{$classesSpan}}">
                                            {{$operacion->estado}}
                                        </span>
                                    </p>
                                @endif
                                @if($operacion->ciclo)
                                    <p class="mb-0.5">Ciclo:
                                        <span class="{{$classesSpan}}">
                                            {{$operacion->ciclo}}
                                        </span>
                                    </p>
                                @endif
                                @if($operacion->acuerdo)
                                    <p class="mb-0.5">Acuerdo:
                                        <span class="{{$classesSpan}}">
                                            {{$operacion->acuerdo}}
                                        </span>
                                    </p>
                                @endif                          
                            </div>
                        </div>

                        <!--Listado telefono-->
                        <div class="w-1/4 border p-2 ">
                            <h2 class="text-center bg-gray-200 py-2 mb-4 font-bold uppercase">Listado de Teléfonos:</h2>
                            <div class="overflow-y-auto max-h-[350px]">
                                @if($telefonos->count())
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
                                        </div>
                                    @endforeach
                                @else
                                    <p>
                                        <span class="{{$classesSpan}}">
                                            El deudor no tiene teléfonos.
                                        </span>
                                        
                                    </p>
                                @endif
                            </div>
                        </div>

                         <!--Propuestas realizadas-->
                        <div class="w-1/2 border p-2 ">
                            @if(session('message'))
                                <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold my-4 p-3 ">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <h2 class="text-center bg-gray-200 py-2 mb-4 font-bold uppercase">Historial de gestiones:</h2>
                            @if($propuestas->count())
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach ($propuestas as $index => $propuesta)
                                        <div class="border border-gray-400 p-2 {{ $index % 2 == 0 ? 'bg-blue-100' : 'bg-white' }}">
                                            <h2 class= "border-b border-gray-400 uppercase text-center p-2">Detalle de la gestión </h2>
                                            <div class="p-2">
                                                <p class="mt-2">Monto Ofrecido:
                                                    <span class="{{$classesSpan}}">
                                                        ${{number_format($propuesta->monto_ofrecido, 2, ',', '.')}}
                                                    </span>
                                                </p>
                                                <p>Tipo Propuesta:
                                                    @if($propuesta->tipo_de_propuesta == 1)
                                                        <span class="{{$classesSpan}}">
                                                            Cancelación
                                                        </span>
                                                    @elseif($propuesta->tipo_de_propuesta == 2)
                                                        <span class="{{$classesSpan}}">
                                                            Cuotas fijas
                                                        </span>
                                                    @elseif($propuesta->tipo_de_propuesta == 3)
                                                        <span class="{{$classesSpan}}">
                                                            Cuotas con dto,
                                                        </span>
                                                    @else
                                                        <span class="{{$classesSpan}}">
                                                            Cuotas Variables
                                                        </span>
                                                    @endif
                                                </p>
                                                @if ($propuesta->porcentaje_quita)
                                                    @if($propuesta->porcentaje_quita < 0)
                                                        <p>Porcentaje Quita:
                                                            <span class="{{$classesSpan}}">
                                                                {{ number_format(0, 2, ',', '.') }}%
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p>Porcentaje Quita:
                                                            <span class="{{$classesSpan}}">
                                                                {{number_format($propuesta->porcentaje_quita, 2, ',', '.')}}%
                                                            </span>
                                                        </p>
                                                    @endif
                                                @endif
                                                @if ($propuesta->anticipo)
                                                    <p>Anticipo:
                                                        <span class="{{$classesSpan}}">
                                                            ${{number_format($propuesta->anticipo, 2, ',', '.')}}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->fecha_pago_anticipo)
                                                    <p>Fecha de Pago anticipo:
                                                        <span class="{{$classesSpan}}">
                                                            {{ \Carbon\Carbon::parse($propuesta->fecha_pago_anticipo)->format('d/m/Y') }}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->cantidad_de_cuotas_uno)
                                                    <p>Cantidad de Cuotas (Grupo 1):
                                                        <span class="{{$classesSpan}}">
                                                            {{$propuesta->cantidad_de_cuotas_uno}}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->monto_de_cuotas_uno)
                                                    <p>Monto (Grupo 1):
                                                        <span class="{{$classesSpan}}">
                                                            ${{number_format($propuesta->monto_de_cuotas_uno, 2, ',', '.')}}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->fecha_pago_cuota)
                                                    <p>Fecha de pago cuota:
                                                        <span class="{{$classesSpan}}">
                                                            {{ \Carbon\Carbon::parse($propuesta->fecha_pago_cuota)->format('d/m/Y') }}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->cantidad_de_cuotas_dos)
                                                    <p>Cantidad de Cuotas (Grupo 2):
                                                        <span class="{{$classesSpan}}">
                                                            {{$propuesta->cantidad_de_cuotas_dos}}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->monto_de_cuotas_dos)
                                                    <p>Monto (Grupo 2):
                                                        <span class="{{$classesSpan}}">
                                                            ${{number_format($propuesta->monto_de_cuotas_dos, 2, ',', '.')}}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->cantidad_de_cuotas_tres)
                                                    <p>Cantidad de Cuotas (Grupo 3):
                                                        <span class="{{$classesSpan}}">
                                                            {{$propuesta->cantidad_de_cuotas_tres}}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->monto_de_cuotas_tres)
                                                    <p>Monto (Grupo 3):
                                                        <span class="{{$classesSpan}}">
                                                            ${{number_format($propuesta->monto_de_cuotas_tres, 2, ',', '.')}}
                                                        </span>
                                                    </p>
                                                @endif
                                                @if ($propuesta->vencimiento)
                                                    <p>Vencimiento:
                                                        <span class="{{$classesSpan}}">
                                                            {{ \Carbon\Carbon::parse($propuesta->vencimiento)->format('d/m/Y') }}
                                                        </span>
                                                    </p>
                                                @endif
                                                <p>Agente:
                                                    <span class="{{$classesSpan}}">
                                                        {{$propuesta->usuarioUltimaModificacion->name}}
                                                        {{$propuesta->usuarioUltimaModificacion->apellido}}
                                                    </span>
                                                </p>
                                                <p>Fecha Gestión:
                                                    <span class="{{$classesSpan}}">
                                                        {{ \Carbon\Carbon::parse($propuesta->created_at)->format('d/m/Y') }}
                                                    </span>
                                                </p>
                                                <p>Observaciones:
                                                    <span class="{{$classesSpan}}">
                                                        {{$propuesta->observaciones}}
                                                    </span>
                                                </p>
                                                @php
                                                    if($propuesta->estado == 'Propuesta de Pago')
                                                        $classesEstado = "text-center text-white bg-indigo-600 py-2 font-bold rounded uppercase";
                                                    elseif($propuesta->estado == 'Negociación')
                                                        $classesEstado = "text-center text-white bg-orange-500 py-2 font-bold rounded uppercase";
                                                    elseif($propuesta->estado == 'Incobrable')
                                                        $classesEstado = "text-center text-white bg-red-600 py-2 font-bold rounded uppercase";
                                                    elseif($propuesta->estado == 'Acuerdo de Pago')
                                                        $classesEstado = "text-center text-white bg-green-700 py-2 font-bold rounded uppercase";
                                                    elseif($propuesta->estado == 'Rechazada')
                                                        $classesEstado = "text-center text-white bg-black py-2 font-bold rounded uppercase";
                                                    elseif($propuesta->estado == 'Enviada')
                                                        $classesEstado = "text-center text-white bg-blue-300 py-2 font-bold rounded uppercase";
                                                    else 
                                                        $classesEstado = "text-center text-white bg-gray-600 py-2 font-bold rounded uppercase"
                                                @endphp
                                                <h3 class="{{$classesEstado}} mt-2">Resultado: {{$propuesta->estado}}</h3>
                                                <livewire:eliminar-propuesta
                                                    :propuesta="$propuesta"
                                                    :operacion="$operacion"
                                                />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="right-0 p-2">
                                    {{$propuestas->links()}}
                                </div>
                            @else
                                <p class="px-2 {{$classesSpan}}">La operación no tiene gestiones realizadas.</p>
                            @endif
                        </div>

                    </div>

                    <!--Nueva Gestion-->
                    <div class=" border p-2 text-sm">
                        <livewire:propuesta-tipos
                            :operacion="$operacion"
                            :ultimaPropuesta="$ultimaPropuesta"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>