<div>
    <!--Alertas-->
    @if($alertaMensaje)
        <div class="px-2 py-1 bg-{{$alertaTipo}}-100 border-l-4 border-{{$alertaTipo}}-600 text-{{$alertaTipo}}-800 text-sm font-bold mt-1">
            {{ $alertaMensaje }}
        </div>
    @endif
    @if(session('message'))
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1">
            {{ session('message') }}
        </div>
    @endif
    <div class="p-4">
        <livewire:buscador-productos />
    </div>
    @if($productos->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-4 gap-2">
            @foreach ($productos as $producto)
                <div class="border border-gray-700 p-1">
                    @php
                        if ($producto->estado == 1) {
                            $classesSubtituloHTres = "bg-blue-400 text-white uppercase py-1 text-center";
                        } else {
                            $classesSubtituloHTres = "bg-red-600 text-white uppercase py-1 text-center";
                        }
                    @endphp
                    <h3 class="{{$classesSubtituloHTres}}">
                        {{$producto->nombre}}
                    </h3>
                    <div class="pt-1 px-1">
                        <x-subtitulo-h-cuatro>
                            Detalle del Producto
                        </x-subtitulo-h-cuatro>
                        <!--contenedor de información-->
                        <div class="mt-1">
                            <p>Cliente:
                                <span class="font-bold">
                                    {{ $producto->clienteId->nombre }}
                                </span>
                            </p>
                            <p>Honorarios:
                                <span class="font-bold">
                                    {{ $producto->honorarios}}%
                                </span>
                            </p>
                            <p>Cuotas Variables:
                                <span class="font-bold">
                                    @if($producto->acepta_cuotas_variables == 1)
                                        Sí
                                    @else
                                        No
                                    @endif
                                </span>
                            </p>
                            <p>Ult. Modif:
                                <span class="font-bold">
                                    {{ $producto->usuarioUltimaModificacion->name }}
                                    {{ $producto->usuarioUltimaModificacion->apellido }}
                                </span>
                            </p>
                            <p>Fecha:
                                <span class="font-bold">
                                    {{ \Carbon\Carbon::parse($producto->updated_at)->format('d/m/Y - H:i:s') }}
                                </span>
                            </p>
                        </div>
                        <!--Contenedor botones-->
                        @php
                            $classesBtn ="text-white px-4 py-2 rounded text-sm"
                        @endphp
                        <div class="pt-1 py-1 grid grid-cols-3 justify-center gap-1">
                            <a href="{{ route('perfil.producto', ['producto' => $producto->id]) }}"
                                class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900 text-center">
                                Ver Perfil
                            </a>
                            @if($producto->estado == 1)
                                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                                        wire:click="mostrarModalEstado({{ $producto->id }})">
                                    Activo
                                </button>
                            @else
                                <button class="{{$classesBtn}} bg-gray-700 hover:bg-gray-800"
                                        wire:click="mostrarModalEstado({{ $producto->id }})">
                                    Inactivo
                                </button>
                            @endif
                            <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                    wire:click="mostrarModalEliminar({{ $producto->id }})">
                                Eliminar
                            </button>  
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            Aun no hay Operaciones
        </p>
    @endif
    <div class="my-5 pb-3">
        {{$productos->links()}}
    </div>
    <!--Modal cambiar estado-->
    @if($modalEstado && !$errors->any())
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1">Confirmar cambiar estado de
                <span class="font-bold">
                    {{$productoSeleccionado->nombre}}
                </span>
            </p>
            <!--Contenedor Botones-->
            <div class="flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                        wire:click="confirmarCambiarEstado({{ $productoSeleccionado->id }})">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalEstado">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
    <!--Modal eliminar usuario-->
    @if($modalEliminar && !$errors->any())
    <x-modal-estado>
        <!--Contenedor Parrafos-->
        <p class="px-1">Confirmar eliminar
            <span class="font-bold">
                {{$productoSeleccionado->nombre}}
            </span>
            de
            <span class="font-bold">
                {{$productoSeleccionado->clienteId->nombre}}
            </span>
        </p>
        <!--Contenedor botones-->
        <div class="flex justify-center gap-2 mt-2">
            <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                    wire:click="confirmarEliminarUsuario({{ $productoSeleccionado->id }})">
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