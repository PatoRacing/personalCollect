<div>
    <!-- clases-->
    @php
        $classesSpan = "font-bold text-black";
        $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-2 text-center py-2";
        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
        $classesTipo = "text-center bg-blue-800 text-white py-2 font-bold rounded my-4 uppercase";
        $classesButtonTrue = "text-white rounded-md text-sm bg-blue-400 border-2 text-center py-3 px-6";
        $classesButtonFalse = "text-white rounded-md bg-blue-300 text-sm border-2 text-center py-3 px-6";
    @endphp
    <!--titulo-->
    <div class="p-4 sticky left-0">
        <h1 class="font-bold uppercase bg-gray-200 p-4 text-gray-900 hover:text-gray-500 text-center mb-2 flex items-center justify-center space-x-8">
            Cartera
        </h1>
        @if(session('message'))
            <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-3 p-3">
                {{ session('message') }}
            </div>
        @endif                
    </div>
    <!--Info-->
    <div class="px-14 py-4 mb-2 lg:flex lg:items-center lg:justify-between text-sm
                bg-white rounded border border-gray-200 border-1 text-gray-600">
        <p>Casos Activos: <span class="font-bold text-black">{{$casosActivos}}</span></p>
        <p>Total DNI: <span class="font-bold text-black">{{$totalDNI}}</span></p>
        <p>Deuda Total Activa: <span class="font-bold text-black">${{number_format($deudaActiva, 2, ',', '.')}}</span></p>               
    </div>
    <livewire:buscar-cartera />
    @if($operaciones->count())
        <div>
            <!--contenedor de operaciones-->
            <div class="p-4 container grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach ($operaciones as $operacion)
                    <!--operacion-->
                    <div class="border rounded">
                        <div class="px-4 text-gray-600">
                            <!-- clases-->
                            @php
                                $classesSpan = "font-bold text-black";
                                $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-4 text-center py-4";
                                $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
                            @endphp
                            <!-- detalle operacion-->
                            <a class= "{{$classesNombre}} block hover:bg-blue-300"
                                href="{{ route('deudor.perfil', ['deudor' => $operacion->deudor_id]) }}">
                                @if($operacion->deudorId->nombre)
                                    {{$operacion->deudorId->nombre}}
                                @else
                                    <span class="text-red-600">Sin datos</span>
                                @endif
                            </a>
                            <h3 class="{{$classesTitulo}}">Detalle de la Operación:</h3>
                            <p>Cliente: <span class="{{$classesSpan}}">{{ $operacion->clienteId->nombre }}</span></p>
                            <p>DNI Deudor: <span class="{{$classesSpan}}">{{ $operacion->nro_doc }}</span></p>
                            <p>Operación: <span class="{{$classesSpan}}">{{ $operacion->operacion }}</span></p>
                            <p>Segmento:
                                <span class="{{$classesSpan}}">
                                    @if ( $operacion->segmento)
                                        {{ $operacion->segmento }}
                                    @else
                                        <span class="text-red-600"> Sin datos </span>
                                    @endif
                                </span>
                            </p>
                            <p>Producto: <span class="{{$classesSpan}}">{{ $operacion->productoId->nombre }}</span></p>
                            <p>Deuda Capital: 
                                <span class="{{$classesSpan}}">
                                    ${{ number_format($operacion->deuda_capital, 2, ',', '.') }}
                                </span>
                            </p>
                            <p>Días Atraso:
                                <span class="{{$classesSpan}}">
                                    @if ( $operacion->dias_atraso)
                                        {{ $operacion->dias_atraso }}
                                    @else
                                        <span class="text-red-600"> Sin datos </span>
                                    @endif      
                                </span>
                            </p>
                            <p>Fecha Asig.:
                                <span class="{{$classesSpan}}">
                                    @if ( $operacion->fecha_asignacion)
                                        {{ \Carbon\Carbon::parse($operacion->fecha_asignacion)->format('d/m/Y') }}
                                    @else
                                        <span class="text-red-600"> Sin datos </span>
                                    @endif      
                                </span>
                            </p>
                            <!--Asignacion-->
                            <div class="border-b-2">
                                <h2 class= "{{$classesTitulo}} mt-2">Agente:
                                    @if($operacion->usuario_asignado_id !== 100)
                                        <span>
                                            {{$operacion->usuarioAsignado->name}}
                                            {{$operacion->usuarioAsignado->apellido}}
                                        </span>
                                    @else
                                        <span>Sin Asignar</span>
                                    @endif
                                </h2>
                            </div>
                            <div class="flex gap-2">
                                <!--Estado deudor-->
                                <div class="border-b-2 w-full">
                                    @php
                                        $ultimaGestion = $operacion->deudorId->gestionesDeudores()->latest('updated_at')->first();
                                        if ($ultimaGestion) {
                                            if($ultimaGestion->resultado == 'En proceso')
                                                $classesUltimaGestion = "text-center text-white bg-indigo-600 py-2 font-bold rounded mt-2 uppercase";
                                            elseif ($ultimaGestion->resultado == 'Inubicable')
                                                $classesUltimaGestion = "text-center text-white bg-orange-500 py-2 font-bold rounded mt-2 uppercase";
                                            elseif ($ultimaGestion->resultado === 'Fallecido')
                                                $classesUltimaGestion = "text-center text-white bg-red-600 py-2 font-bold rounded mt-2 uppercase";
                                            else
                                                $classesUltimaGestion = "text-center text-white bg-green-700 py-2 font-bold rounded mt-2 uppercase";
                                        } else {
                                            // Manejo si $ultimaGestion es nulo
                                            $classesUltimaGestion = "text-center text-white bg-gray-400 py-2 font-bold rounded mt-2 uppercase";
                                            $ultimaGestionResultado = 'Sin Gestión';
                                        }
                                    @endphp
                                    @if($ultimaGestion)
                                        <h2 class="{{$classesUltimaGestion}}">Deudor: {{$ultimaGestion->resultado}}</h2>
                                    @else
                                        <h2 class="{{$classesUltimaGestion}}">Deudor: {{$ultimaGestionResultado}}</h2>
                                    @endif
                                </div>
                                <!--Ultima Gestión-->
                                <div class="border-b-2 w-full">
                                    @php
                                        $ultimaPropuesta = \App\Models\Propuesta::where('operacion_id', $operacion->id)->latest('updated_at')->first();
                                        if($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Propuesta de Pago')
                                            $classesEstado = "text-center text-white bg-indigo-600 py-2 font-bold rounded uppercase mt-2";
                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Negociación')
                                            $classesEstado = "text-center text-white bg-orange-500 py-2 font-bold rounded uppercase mt-2";
                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Incobrable')
                                            $classesEstado = "text-center text-white bg-red-600 py-2 font-bold rounded uppercase mt-2";
                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Acuerdo de Pago')
                                            $classesEstado = "text-center text-white bg-green-700 py-2 font-bold rounded uppercase mt-2";
                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Rechazada')
                                            $classesEstado = "text-center text-white bg-black py-2 font-bold rounded uppercase mt-2";
                                        elseif($ultimaPropuesta && $ultimaPropuesta->operacion_id == $operacion->id && $ultimaPropuesta->estado == 'Enviada')
                                            $classesEstado = "text-center text-white bg-blue-300 py-2 font-bold rounded uppercase mt-2";
                                        else 
                                            $classesEstado = "text-center text-white bg-gray-600 py-2 font-bold rounded uppercase mt-2"
                                    @endphp
                                    @if(!$ultimaPropuesta)
                                        <h2 class="{{$classesEstado}}">Op:
                                            Sin gestión
                                        </h2>
                                    @else
                                        <h2 class= "{{$classesEstado}}">Op:
                                            {{$ultimaPropuesta->estado }}
                                        </h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-800 p-2 text-center font-bold">
            Sin operaciones
        </p>
    @endif
    <div class="my-5 pb-3">
        {{$operaciones->links()}}
    </div>
</div>
