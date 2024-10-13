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
    <!--Listado de usuarios-->
    <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-4 gap-2 pt-1 px-1">
        @if($usuarios->count())
            @foreach ($usuarios as $usuario)
                @if($usuario->id != 100)
                    <div class="border border-gray-700 pt-1 px-1">
                        <x-subtitulo-h-tres :variable="$usuario">
                            {{$usuario->name}} {{$usuario->apellido}}
                        </x-subtitulo-h-tres>
                        <div class="container mx-auto pt-1 px-1">
                            <x-subtitulo-h-cuatro>
                                Información General
                            </x-subtitulo-h-cuatro>
                            <!--Contenedor parrafos información-->
                            <div class="pt-1 px-1 border-b border-gray-700">
                                <p>ID: <span class="font-bold">{{$usuario->id}}</span></p>
                                <p>Rol: <span class="font-bold">{{$usuario->rol}}</span></p>
                                <p>DNI: <span class="font-bold">{{ number_format($usuario->dni, 0, ',', '.') }}</span></p>
                                <p>Ingreso: <span class="font-bold">{{ \Carbon\Carbon::parse($usuario->fecha_de_ingreso)->format('d/m/Y') }}</span></p>
                                <p>Teléfono: <span class="font-bold">{{$usuario->telefono}}</span></p>
                                <p>Email: <span class="font-bold">{{$usuario->email}}</span></p>
                                <p>Domicilio: <span class="font-bold">{{$usuario->domicilio}}</span></p>
                                <p>Localidad: <span class="font-bold">{{$usuario->localidad}}</span></p>
                                <p>Cod. Postal: <span class="font-bold">{{$usuario->codigo_postal}}</span></p>
                            </div>
                            <div class="pt-1 px-1">
                                <p>Ult. Modif:
                                    <span class="font-bold">
                                        {{ \App\Models\User::find($usuario->usuario_ultima_modificacion_id)->name }}
                                        {{ \App\Models\User::find($usuario->usuario_ultima_modificacion_id)->apellido }}
                                    </span>
                                </p>
                                <p class=>Fecha:
                                    <span class="font-bold">
                                        {{ ($usuario->updated_at)->format('d/m/Y - H:i') }}
                                    </span>
                                </p>
                            </div>
                            <!--Contenedor botones-->
                            <div class="my-1 px-1 grid grid-cols-3 justify-center gap-1">
                                @php
                                    $classesBtn ="text-white px-4 py-2 rounded text-sm"
                                @endphp
                                <a href="{{route('actualizar.usuario', ['id'=>$usuario->id])}}"
                                    class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900 text-center">
                                    Actualizar
                                </a>
                                @if($usuario->estado == 1)
                                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                                            wire:click="mostrarModalEstado({{ $usuario->id }})">
                                        Activo
                                    </button>
                                @else
                                    <button class="{{$classesBtn}} bg-gray-700 hover:bg-gray-800"
                                            wire:click="mostrarModalEstado({{ $usuario->id }})">
                                        Inactivo
                                    </button>
                                @endif
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                        wire:click="mostrarModalEliminar({{ $usuario->id }})">
                                    Eliminar
                                </button>                 
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
        <p class="text-gray-800 p-2 text-center font-bold">
            Aun no hay Usuarios
        </p>
        @endif
        <!--Modal cambiar estado-->
        @if($modalEstado && !$errors->any())
            <x-modal-estado>
                <!--Contenedor Parrafos-->
                <p class="px-1">Confirmar cambiar estado de
                    <span class="font-bold">
                        {{$usuarioSeleccionado->name}}
                        {{$usuarioSeleccionado->apellido}}
                    </span>
                </p>
                <!--Contenedor Botones-->
                <div class="flex justify-center gap-2 mt-2">
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                            wire:click="confirmarCambiarEstado({{ $usuarioSeleccionado->id }})">
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
                <p class="px-1">Confirmar eliminar al usuario
                    <span class="font-bold">
                        {{$usuarioSeleccionado->name}}
                        {{$usuarioSeleccionado->apellido}}
                    </span>
                </p>
                <!--Contenedor botones-->
                <div class="flex justify-center gap-2 mt-2">
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                            wire:click="confirmarEliminarUsuario({{ $usuarioSeleccionado->id }})">
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
    <div class="p-2">
        {{$usuarios->links()}}
    </div>
</div>


