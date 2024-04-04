@section('titulo')
    Clientes
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Clientes</h1>
                <a href="{{route('crear.cliente')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">+ Cliente</a>
                <a href="{{route('importar.deudores')}}" class="text-white bg-orange-500 hover:bg-orange-700 px-5 py-3 rounded">+ Deudores</a>
                <a href="{{route('importar.informacion')}}" class="text-white bg-green-700 hover:bg-green-900 px-5 py-3 rounded">+ Información</a>
                <a href="{{route('generar.operacion')}}" class="text-white bg-blue-400 hover:bg-blue-600 px-5 py-3 rounded">+ Operación</a>                    
                @if(session('successMessage') && session('messageType') == 'import')
                    <div class="bg-white rounded p-4 mt-8">
                        <h1 class="font-extrabold text-2xl text-black">Importación realizada con éxito:</h1>
                        <p class="font-bold text-gray-600 mb-2">Detalle de acciones generadas:</p>
                        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold p-2">
                            {!! nl2br(session('successMessage')) !!}
                        </div>
                    </div>
                @endif
                @if(session('successMessage') && session('messageType') == 'cliente')
                    <div class="bg-white rounded p-4 mt-8">
                        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold p-2">
                            {!! nl2br(session()->get('successMessage')) !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="bg-white px-8 py-4 rounded mt-2">
                <div>
                    <h3 class="text-center bg-gray-200 border-b-2 py-4 font-bold rounded mb-4 uppercase">Listado de clientes</h3>
                    <div class="p-3">
                        @if($clientes->count())
                            <div>
                                <div class="p-6 container grid grid-cols-1 gap-4 md:grid-cols-3">
                                    @foreach ($clientes as $cliente)
                                    <div class="border rounded">
                                        <div class="px-4 text-gray-600">
                                            @php
                                                $classesSpan = "font-bold text-black";
                                                if ($cliente->estado === 1) {
                                                    $classesNombre = "uppercase border-b-2 text-black font-bold text-center py-4";
                                                    } else {
                                                        $classesNombre = "uppercase border-b-2 text-red-600 font-bold text-center py-4";
                                                }
                                                $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
                                            @endphp
                                            <h2 class= "{{$classesNombre}}">{{$cliente->nombre}} <span class="rounded px-3 py-1 bg-blue-800 text-white">{{$cliente->id}}</span></h2>
                                            <h3 class="{{$classesTitulo}}">Información:</h3>
                                            <p>Contacto: <span class="{{$classesSpan}}">{{$cliente->contacto}}</span></p>
                                            <p>Teléfono: <span class="{{$classesSpan}}">{{$cliente->telefono}}</span></p>
                                            <p>Ult. Modif:
                                                <span class="{{$classesSpan}}">
                                                    {{ \App\Models\User::find($cliente->usuario_ultima_modificacion_id)->name }}
                                                    {{ \App\Models\User::find($cliente->usuario_ultima_modificacion_id)->apellido }}
                                                </span>
                                            </p>
                                            <p class="mb-4 border-b-2 pb-4">Fecha Ult. Modif:
                                                <span class="{{$classesSpan}}">
                                                    {{ \Carbon\Carbon::parse($cliente->fecha_ultima_modificacion)->format('d/m/Y - H:i') }}
                                                </span>
                                            </p>
                                        </div>

                                        <div class="p-4 flex justify-center gap-2">                                                   
                                            <a href="{{route('actualizar.cliente', ['cliente'=>$cliente->id])}}"
                                                class="text-white text-center bg-blue-800 hover:bg-blue-950 px-5 py-2 rounded">
                                                Actualizar
                                            </a>
                                            <livewire:actualizar-estado-cliente :cliente="$cliente"/>
                                            <livewire:eliminar-cliente :cliente="$cliente"/>
                                        </div>

                                        <div class="px-4 text-gray-600">
                                            <h3 class="{{$classesTitulo}}">Cartera:</h3>
                                            <p>Casos Activos:
                                                <span class="{{$classesSpan}}">
                                                    @php
                                                        $casosActivos = \App\Models\Operacion::where('cliente_id', $cliente->id)
                                                                                            ->where('situacion', 1)
                                                                                            ->count();
                                                    @endphp
                                                    @if (($casosActivos))
                                                        {{$casosActivos}}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </p>
                                            <p>Total DNI:
                                                <span class="{{$classesSpan}}">
                                                    @php
                                                        $totalDNI = \App\Models\Operacion::where('cliente_id', $cliente->id)
                                                                                            ->distinct('nro_doc')
                                                                                            ->count();
                                                    @endphp
                                                    @if (($totalDNI))
                                                        {{$totalDNI}}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </p>
                                            <p>Deuda Activa:
                                                <span class="{{$classesSpan}}">
                                                    @php
                                                        $deudaActiva = \App\Models\Operacion::where('cliente_id', $cliente->id)
                                                                                            ->where('situacion', 1)
                                                                                            ->sum('deuda_capital')
                                                    @endphp
                                                    @if (($deudaActiva))
                                                        ${{ number_format($deudaActiva, 2, ',', '.') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </p>
                                            <p>Ult. Importación:
                                                <span class="{{$classesSpan}}">
                                                    @if (($ultimaImportacion = \App\Models\Operacion::where('cliente_id', $cliente->id)->latest('updated_at')->first()))
                                                        {{ \App\Models\User::find($ultimaImportacion->usuario_ultima_modificacion_id)->name }}
                                                        {{ \App\Models\User::find($ultimaImportacion->usuario_ultima_modificacion_id)->apellido }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </p>
                                            <p class="mb-4 border-b-2 pb-4">Fecha:
                                                <span class="{{$classesSpan}}">
                                                    @if ($fechaUltimaImportacion = \App\Models\Operacion::where('cliente_id', $cliente->id)
                                                                                                        ->latest('updated_at')
                                                                                                        ->first())
                                                        {{ \Carbon\Carbon::parse($fechaUltimaImportacion->updated_at)->format('d/m/Y - H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </p>
                                        </div>

                                        <div class="p-4 flex justify-center gap-2">  
                                            <a href="{{ route('perfil.cliente', ['cliente' => $cliente->id]) }}"
                                                class="mb-2 text-white rounded px-5 py-2 bg-indigo-600 hover:bg-indigo-800">
                                                Ver Cartera
                                            </a>

                                            @if ($cliente->estado === 2)
                                                <span  class="mb-2 text-white rounded bg-gray-600 px-5 py-2 hover:bg-gray-800 cursor-not-allowed"
                                                    title="No puedes importar cartera a un cliente inactivo">
                                                    Importar Cartera
                                                </span>
                                            @else
                                                <a href="{{ route('importar.operaciones', ['cliente' => $cliente->id]) }}"
                                                    class="mb-2 text-center text-white rounded px-5 py-2 bg-cyan-600 hover:bg-cyan-700">
                                                    Importar Cartera
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-800 p-2 text-center font-bold">
                                Aun no hay Clientes
                            </p>
                        @endif
                        <div class="my-5 pb-3">
                            {{$clientes->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>