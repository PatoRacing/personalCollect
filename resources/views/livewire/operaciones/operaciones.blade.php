<div>
    @php
        $classesBtn ="text-white py-2 rounded text-sm"
    @endphp
    <div class="p-4">
        <livewire:buscar-cartera />
    </div>
    @if($operaciones->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($operaciones as $operacion)
                <div class="border border-gray-700 p-1">
                    <a class="bg-blue-400 text-white uppercase py-1 text-center block hover:bg-blue-500 cursor-pointer"
                        href="{{ route('deudor.perfil', ['deudor' => $operacion->deudor_id]) }}">
                        @if($operacion->deudorId->nombre)
                            {{$operacion->deudorId->nombre}}
                        @else
                            Sin Datos
                        @endif
                    </a>
                    <div class="p-1">
                        <x-subtitulo-h-cuatro>
                            Detalle de la Operación
                        </x-subtitulo-h-cuatro>
                        <!--contenedor de información-->
                        <div class="mt-1">
                            <p>Cliente:
                                <span class="font-bold">
                                    {{ $operacion->clienteId->nombre }}
                                </span>
                            </p>
                            <p>DNI deudor:
                                <span class="font-bold">
                                    {{ $operacion->nro_doc }}
                                </span>
                            </p>
                            <p>Operación:
                                <span class="font-bold">
                                    {{ $operacion->operacion }}
                                </span>
                            </p>
                            <p>Segmento:
                                @if($operacion->segmento)
                                    <span class="font-bold">
                                        {{ $operacion->segmento }}
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Sin datos
                                    </span>
                                @endif
                            </p>
                            <p>Producto:
                                <span class="font-bold">
                                    {{ $operacion->productoId->nombre }}
                                </span>
                            </p>
                            <p>Deuda Capital:
                                <span class="font-bold">
                                    ${{ number_format($operacion->deuda_capital, 2, ',', '.') }}
                                </span>
                            </p>
                            <p>Días Atraso:
                                @if($operacion->dias_atraso)
                                    <span class="font-bold">
                                        {{ $operacion->dias_atraso }}
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Sin datos
                                    </span>
                                @endif
                            </p>
                            <p>Fecha Asig:
                                @if( $operacion->fecha_asignacion)
                                    <span class="font-bold">
                                        {{ \Carbon\Carbon::parse($operacion->fecha_asignacion)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Sin datos
                                    </span>
                                @endif
                            </p>
                        </div>
                        <!--contenedor situacioon deudor / operacion-->
                        @php
                            $ultimaGestionDeudor = $operacion->deudorId->gestionesDeudores()->latest('updated_at')->first();
                            $ultimaGestionOperacion = \App\Models\Propuesta::where('operacion_id', $operacion->id)->latest('updated_at')->first();
                            if($ultimaGestionDeudor) {
                                $classesBG = 'bg-blue-400';
                            } else {
                                $classesBG = 'bg-gray-500';
                            }
                            if($ultimaGestionOperacion) {
                                $classesBGOperacion = 'bg-blue-400';
                            } else {
                                $classesBGOperacion = 'bg-gray-500';
                            }
                        @endphp
                        <div class="text-sm mx-auto grid grid-cols-2 justify-center gap-1 mt-1 text-center">
                            <div class="{{$classesBG}} lg:my-1 py-2 rounded text-white">
                                <p>Deudor:
                                    @if($ultimaGestionDeudor)                                     
                                        <span class="font-bold">
                                            {{$ultimaGestionDeudor->resultado}}
                                        </span>
                                    @else
                                        <span class="font-bold">
                                            Sin Gestión
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="{{$classesBGOperacion}} lg:my-1 py-2 rounded text-white">
                                @if($ultimaGestionOperacion)                                     
                                    <span class="font-bold">
                                        {{$ultimaGestionOperacion->estado}}
                                    </span>
                                @else
                                    <span class="font-bold">
                                        Sin Gestión
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!--Operacion Asignada-->
                        @if($operacion->usuario_asignado_id !== 100)
                            <h3 class="bg-green-600 text-white uppercase py-2 text-center rounded mt-1 lg:mt-0 text-sm">
                                Agente: 
                                {{$operacion->usuarioAsignado->name}}
                                {{$operacion->usuarioAsignado->apellido}}
                            </h3>
                            <!--Contenedor botones-->
                            <div class="grid grid-cols-2 justify-center gap-1 mt-1">
                                <a href="{{ route('deudor.perfil', ['deudor' => $operacion->id]) }}"
                                    class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900 text-center">
                                    Ver Perfil
                                </a> 
                                <button class="{{$classesBtn}} bg-cyan-600 hover:bg-cyan-700"
                                        wire:click="mostrarModalAsignar({{ $operacion->id }})">
                                    Reasignar
                                </button>         
                            </div>
                        @else
                        <!--Operacion sin asignar-->
                            <h3 class="bg-red-600 text-white uppercase rounded text-sm py-2 text-center mt-1 lg:mt-0">
                                Sin Asignar
                            </h3>
                            <div class="grid grid-cols-2 justify-center gap-1 mt-1">
                                <a href="{{ route('deudor.perfil', ['deudor' => $operacion->deudor_id]) }}"
                                    class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900 text-center">
                                    Ver Perfil
                                </a> 
                                <button class="{{$classesBtn}} bg-orange-500 hover:bg-orange-600"
                                        wire:click="mostrarModalAsignar({{ $operacion->id }})">
                                    Asignar
                                </button>         
                            </div>
                        @endif
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
        {{$operaciones->links()}}
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
                    <button class="{{$classesBtn}} px-3 bg-green-600 hover:bg-green-700">                        
                        Guardar
                    </button>
                    <button class="{{$classesBtn}} px-3 bg-red-600 hover:bg-red-700"
                            wire:click.prevent="cerrarModalAsignar">
                        Cancelar
                    </button>
                </div>
            </form>
        </x-asignar-estado>
    @endif
</div>
