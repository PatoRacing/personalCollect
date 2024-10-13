<div>
    <!--Alertas-->
    @if($alertaMensaje)
        <div class="px-2 py-1 bg-{{$alertaTipo}}-100 border-l-4 border-{{$alertaTipo}}-600 text-{{$alertaTipo}}-800 text-sm font-bold mt-1">
            {{ $alertaMensaje }}
        </div>
    @endif
    <!--alerta de importacion exitosa-->
    @if(session('successMessage') && session('messageType') == 'import')
        <div class="container mx-auto px-2 py-1 mt-1 border">
            <h5 class="font-bold text-black text-xl">Importación exitosa:</h5>
            <p>Detalle de acciones generadas:</p>
            <div class="bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1 px-2 py-1">
                {!! nl2br(session('successMessage')) !!}
            </div>
        </div>
    @endif
    <!--alerta de creacion de cliente-->
    @if(session('successMessage') && session('messageType') == 'cliente')
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1">
            {!! nl2br(session()->get('successMessage')) !!}
        </div>
    @endif
    <!--Listado de clientes-->
    <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-4 gap-2 p-1">
        @if($clientes->count())
            @foreach ($clientes as $cliente)
                <div class="border border-gray-700 pt-1 px-1">
                    <x-subtitulo-h-tres :variable="$cliente">
                        {{$cliente->nombre}}
                    </x-subtitulo-h-tres>
                    <div class="container mx-auto pt-1 px-1">
                        <x-subtitulo-h-cuatro>
                            Información General
                        </x-subtitulo-h-cuatro>
                        <!--Contenedor parrafos información-->
                        <div class="p-2">
                            <p>ID: <span class="font-bold">{{$cliente->id}}</span></p>
                            <p>Contacto: <span class="font-bold">{{$cliente->contacto}}</span></p>
                            <p>Teléfono: <span class="font-bold">{{ $cliente->telefono }}</span></p>
                            <p>Ult. Modif:
                                <span class="font-bold">
                                    {{ $cliente->usuarioUltimaModificacion->name }}
                                    {{ $cliente->usuarioUltimaModificacion->apellido }}
                                </span></p>
                            <p>Fecha: <span class="font-bold">{{ \Carbon\Carbon::parse($cliente->fecha_ultima_modificacion)->format('d/m/Y') }}</span></p>
                            <!--Contenedor botones-->
                            <div class="p-2 grid grid-cols-3 justify-center gap-1">
                                @php
                                    $classesBtn ="text-white px-4 py-2 rounded text-sm"
                                @endphp
                                <a href="{{route('actualizar.cliente', ['cliente'=>$cliente->id])}}"
                                    class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900 text-center">
                                    Actualizar
                                </a>
                                @if($cliente->estado == 1)
                                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                                            wire:click="mostrarModalEstado({{ $cliente->id }})">
                                        Activo
                                    </button>
                                @else
                                    <button class="{{$classesBtn}} bg-gray-700 hover:bg-gray-800"
                                            wire:click="mostrarModalEstado({{ $cliente->id }})">
                                        Inactivo
                                    </button>
                                @endif
                                <!--Modal cambiar estado-->
                                @if($modalEstado)
                                    <x-modal-estado>
                                        <!--Contenedor Parrafos-->
                                        <p class="px-1">Confirmar cambiar estado de
                                            <span class="font-bold">
                                                {{$clienteSeleccionado->nombre}}
                                            </span>
                                        </p>
                                        <!--Contenedor Botones-->
                                        <div class="flex justify-center gap-2 mt-2">
                                            <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                                                    wire:click="confirmarCambiarEstado({{ $clienteSeleccionado->id }})">
                                                Confirmar
                                            </button>
                                            <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                                    wire:click="cerrarModalEstado">
                                                Cancelar
                                            </button>
                                        </div>
                                    </x-modal-estado>
                                @endif
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                        wire:click="mostrarModalEliminar({{ $cliente->id }})">
                                    Eliminar
                                </button> 
                                <!--Modal eliminar usuario-->
                                @if($modalEliminar)
                                    <x-modal-estado>
                                        <!--Contenedor Parrafos-->
                                        <p class="px-1">Confirmar eliminar al cliente
                                            <span class="font-bold">
                                                {{$clienteSeleccionado->nombre}}
                                            </span>
                                        </p>
                                        <!--Contenedor botones-->
                                        <div class="flex justify-center gap-2 mt-2">
                                            <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                                                    wire:click="confirmarEliminarUsuario({{ $clienteSeleccionado->id }})">
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
                        </div>
                        <x-subtitulo-h-cuatro>
                            Operaciones
                        </x-subtitulo-h-cuatro>
                        <!--Variables auxiliares-->
                        @php
                            $casosActivos = \App\Models\Operacion::where('cliente_id', $cliente->id)->where('situacion', 1)->count();
                            $totalDNI = \App\Models\Operacion::where('cliente_id', $cliente->id)->distinct('nro_doc')->count();
                            $deudaActiva = \App\Models\Operacion::where('cliente_id', $cliente->id)->where('situacion', 1)->sum('deuda_capital')
                        @endphp
                        <!--Contenedor parrafos operaciones-->
                        <div class="pt-1 px-1">
                            <p>Casos activos:
                                @if (($casosActivos))
                                    <span class="font-bold">{{ $casosActivos }}</span>
                                @else
                                    <span class="font-bold">-</span>
                                @endif
                            </p>  
                            <p>Total DNI:
                                @if (($totalDNI))
                                    <span class="font-bold">{{$totalDNI}}</span>
                                @else
                                    <span class="font-bold">-</span>
                                @endif
                            </p>
                            <p>Deuda Activa:
                                @if($deudaActiva)
                                    <span class="font-bold">${{ number_format($deudaActiva, 2, ',', '.') }}</span>
                                @else
                                    <span class="font-bold">-</span>
                                @endif
                            </p>
                            <!--Contenedor botones-->
                            <div class="pt-1 px-1 my-1 grid grid-cols-2 justify-center gap-1">
                                <a href="{{ route('perfil.cliente', ['cliente' => $cliente->id]) }}"
                                    class="{{$classesBtn}} bg-indigo-600 hover:bg-indigo-700 text-center">
                                    Ver Cartera
                                </a>
                                @if ($cliente->estado == 2)
                                    <span class="{{$classesBtn}} bg-gray-700 hover:bg-gray-800 text-center"
                                            title="No puedes importar cartera a un cliente inactivo">
                                        Importar Cartera
                                    </span>
                                @else  
                                    <a href="{{route('importar.operaciones', ['cliente'=>$cliente->id])}}"
                                        class="{{$classesBtn}} bg-cyan-600 hover:bg-cyan-700 text-center">
                                        Importar
                                    </a>
                                @endif            
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        <p class="text-gray-800 p-2 text-center font-bold">
            Aun no hay Clientes
        </p>
        @endif
    </div>
    <!--paginacion-->
    <div class="p-2">
        {{$clientes->links()}}
    </div>
</div>
