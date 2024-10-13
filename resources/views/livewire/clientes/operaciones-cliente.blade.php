<div>
    <div class="p-4">
        <livewire:buscador-operaciones />
    </div>
    @if($operacionesCliente->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2">
            @foreach ($operacionesCliente as $operacionCliente)
                <div class="border border-gray-700 pt-1 px-1">
                    @php
                        if ($operacionCliente->situacion == 1) {
                            $classesSubtituloHTres = "bg-blue-400 text-white uppercase py-1 text-center";
                        } else {
                            $classesSubtituloHTres = "bg-red-600 text-white uppercase py-1 text-center";
                        }
                    @endphp
                    <a class="bg-blue-400 text-white uppercase py-1 text-center block hover:bg-blue-500 cursor-pointer"
                        href="{{ route('deudor.perfil', ['deudor' => $operacionCliente->deudor_id]) }}">
                        @if($operacionCliente->deudorId->nombre)
                            {{$operacionCliente->deudorId->nombre}}
                        @else
                            Sin Datos
                        @endif
                    </a>
                    <div class="pt-1 px-1">
                        <x-subtitulo-h-cuatro>
                            Detalle de la Operación
                        </x-subtitulo-h-cuatro>
                        <!--contenedor de información-->
                        <div class="mt-1">
                            <p>DNI deudor:
                                <span class="font-bold">
                                    {{ $operacionCliente->nro_doc }}
                                </span>
                            </p>
                            <p>Operación:
                                <span class="font-bold">
                                    {{ $operacionCliente->operacion }}
                                </span>
                            </p>
                            <p>Segmento:
                                @if($operacionCliente->segmento)
                                    <span class="font-bold">
                                        {{ $operacionCliente->segmento }}
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Sin datos
                                    </span>
                                @endif
                            </p>
                            <p>Producto:
                                <span class="font-bold">
                                    {{ $operacionCliente->productoId->nombre }}
                                </span>
                            </p>
                            <p>Deuda Capital:
                                <span class="font-bold">
                                    ${{ number_format($operacionCliente->deuda_capital, 2, ',', '.') }}
                                </span>
                            </p>
                            <p>Días Atraso:
                                @if($operacionCliente->dias_atraso)
                                    <span class="font-bold">
                                        {{ $operacionCliente->dias_atraso }}
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Sin datos
                                    </span>
                                @endif
                            </p>
                            <p>Fecha Asig:
                                @if( $operacionCliente->fecha_asignacion)
                                    <span class="font-bold">
                                        {{ \Carbon\Carbon::parse($operacionCliente->fecha_asignacion)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Sin datos
                                    </span>
                                @endif
                            </p>
                            <p>Situacion:
                                @if( $operacionCliente->situacion == 1)
                                    <span class="font-bold">
                                        Activa
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Inactiva
                                    </span>
                                @endif
                            </p>
                        </div>
                        @if($operacionCliente->usuario_asignado_id !== 100)
                            <h3 class="bg-green-600 text-white uppercase py-1 text-center mt-1">
                                {{$operacionCliente->usuarioAsignado->name}}
                                {{$operacionCliente->usuarioAsignado->apellido}}
                            </h3>
                        @else
                            <h3 class="bg-red-600 text-white uppercase py-1 text-center mt-1">
                                Sin Asignar
                            </h3>
                        @endif
                        <!--Contenedor botones-->
                        @php
                            $classesBtn ="text-white px-4 py-2 rounded text-sm"
                        @endphp
                        <div class="my-1 grid grid-cols-2 justify-center gap-1">
                            <a href="{{ route('deudor.perfil', ['deudor' => $operacionCliente->deudor_id]) }}"
                                class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900 text-center">
                                Ver Perfil
                            </a>
                            @if ($operacionCliente->situacion == 2)
                                <span class="{{$classesBtn}} bg-gray-700 hover:bg-gray-800 text-center"
                                        title="No puedes asignar una operación inactiva">
                                    Asignar
                                </span>
                            @else  
                                <button class="{{$classesBtn}} bg-cyan-600 hover:bg-cyan-700"
                                        wire:click="mostrarModalAsignar({{ $operacionCliente->id }})">
                                    Asignar
                                </button>
                            @endif            
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
        {{$operacionesCliente->links()}}
    </div>
    <!--Modal asignar-->
    @if($modalAsignar)
        <x-asignar-operacion>
            <!--Contenedor Parrafos-->
            <p class="p-2">Asignar operación
                <span class="font-bold">
                    {{$operacionSeleccionada->operacion}}
                </span>
                de 
                <span class="font-bold">
                    {{$operacionSeleccionada->clienteId->nombre}}
                </span>
            </p>
            <!--Contenedor formulario-->
            <form class="container mx-auto text-sm" wire:submit.prevent='asignarOperacion({{ $operacionSeleccionada->id }})'>
                <div>
                    <x-input-label for="usuario_asignado_id" :value="__('Seleccionar agente')" />
                    <select
                        id="usuario_asignado_id"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="usuario_asignado_id">
                        <option value="">Seleccionar</option>
                        @foreach ($usuarios as $usuario)
                            @if ($usuario->id !== 100)
                                <option value="{{$usuario->id}}">{{$usuario->name}} {{$usuario->apellido}}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('usuario_asignado_id')" class="mt-2" />
                </div>
                <div class="flex justify-center gap-1 mt-2">
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                        Guardar
                    </button>
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                            wire:click.prevent="cerrarModalAsignar">
                        Cancelar
                    </button>
                </div>
            </form>
        </x-asignar-estado>
    @endif
</div>




