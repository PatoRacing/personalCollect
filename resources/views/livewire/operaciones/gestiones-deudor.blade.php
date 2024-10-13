<div class="p-1">
    @php
        $classesBtn ="text-white py-2 rounded text-sm"
    @endphp
    <x-subtitulo>
        Gestiones sobre Deudor
    </x-subtitulo>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-1">
        <!--formulario para generar gestiones-->
        <div class="p-2 border border-gray-700">
            <x-subtitulo-h-cuatro>
                Nueva Gestión
            </x-subtitulo-h-cuatro>
            <form wire:submit.prevent='deudorGestion' class="px-2">
                <!-- Accion -->
                <div class="mt-2">
                    <x-input-label for="accion" :value="__('Acción realizada')" />
                    <select
                        id="accion"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="accion"
                        >
                        <option selected value=""> - Seleccionar -</option>
                        <option>Llamada Entrante TP (Fijo)</option>
                        <option>Llamada Saliente TP (Fijo)</option>
                        <option>Llamada Entrante TP (Celular)</option>
                        <option>Llamada Saliente TP (Celular)</option>
                        <option>Llamada Entrante WP (Celular)</option>
                        <option>Llamada Saliente WP (Celular)</option>
                        <option>Chat WP (Celular)</option>
                        <option>Mensaje SMS (Celular)</option>
                    </select>
                    <x-input-error :messages="$errors->get('accion')" class="mt-2" />
                </div>
                <!-- Resultado -->
                <div class="mt-2">
                    <x-input-label for="resultado" :value="__('Resultado obtenido')" />
                    <select
                        id="resultado"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="resultado"
                        >
                        <option selected value=""> - Seleccionar - </option>
                        <option>En proceso</option>
                        <option>Fallecido</option>
                        <option>Inubicable</option>
                        <option>Ubicado</option>
                    </select>
                    <x-input-error :messages="$errors->get('resultado')" class="mt-2" />
                </div>
                <!-- Observacion -->
                <div class="mt-2">
                    <x-input-label for="observaciones" :value="__('Observaciones')" />
                    <x-text-input
                        id="observaciones"
                        placeholder="Describe brevemente la acción"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="observaciones"
                        :value="old('observaciones')"
                        />
                    <div class="mt-2 text-sm text-gray-500">
                        Caracteres restantes: {{ 255 - strlen($observaciones) }}
                    </div>
                    <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
                </div>
                <div class="mt-2">
                    <input 
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 mt rounded cursor-pointer w-full md:col-span-5"
                        value="Nueva Gestión"
                    />
                </div>
            </form>
        </div>
        <!--historial de gestiones-->
        <div class="p-2 border border-gray-700">
            <!--Alertas-->
            @if($alertaMensaje)
                <div class="px-2 py-1 bg-{{$alertaTipo}}-100 border-l-4 border-{{$alertaTipo}}-600 text-{{$alertaTipo}}-800 text-sm font-bold mt-1">
                    {{ $alertaMensaje }}
                </div>
            @endif
            <x-subtitulo-h-cuatro>
                Historial
            </x-subtitulo-h-cuatro>
            <div class="max-h-80 overflow-y-auto">
                @if($gestionesDeudor->count())
                    @foreach ($gestionesDeudor as $gestionDeudor)
                        <div class="p-2 border border-gray-700 my-1">
                            <p>Accion:
                                <span class="font-bold">
                                    {{$gestionDeudor->accion}}
                                </span>
                            </p>
                            <p>Agente:
                                <span class="font-bold">
                                    {{$gestionDeudor->usuarioUltimaModificacion->name}}
                                    {{$gestionDeudor->usuarioUltimaModificacion->apellido}}
                                </span>
                            </p>
                            <p>Fecha:
                                <span class="font-bold">
                                    {{ \Carbon\Carbon::parse($gestionDeudor->created_at)->format('d/m/Y - H:i' ) }} 
                                </span>
                            </p>
                            <p>Observaciones:
                                <span class="font-bold">
                                    {{$gestionDeudor->observaciones}}
                                </span>
                            </p>
                            <div class="grid grid-cols-2 justify-center gap-1 mt-2">
                                @php
                                    $buttonColor = match($gestionDeudor->resultado) {
                                        'Inubicable' => 'bg-orange-500',
                                        'Fallecido' => 'bg-gray-700',
                                        'En proceso' => 'bg-indigo-600',
                                        'Ubicado' => 'bg-green-600',
                                        default => 'bg-green-600',
                                    };
                                @endphp
                                <button class="{{$classesBtn}} {{$buttonColor}} pointer-events-none">
                                    Gestión: {{$gestionDeudor->resultado}}
                                </button>
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                        wire:click="mostrarModalEliminar({{ $gestionDeudor->id }})">
                                    Eliminar
                                </button>         
                            </div>
                        </div>    
                    @endforeach
                @else
                    <p class="text-center font-bold">
                        Aún no hay Gestiones
                    </p>
                @endif
            </div>
        </div>
    </div>
    <!--Modal eliminar gestion-->
    @if($modalEliminar)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1">Confirmar eliminar la gestión
                <span class="font-bold">
                    Id: {{$gestionSeleccionada->id}}
                </span>
            </p>
            <!--Contenedor botones-->
            <div class="flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700 px-3"
                        wire:click="confirmarEliminarUsuario({{ $gestionSeleccionada->id }})">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700 px-3"
                        wire:click="cerrarModalEliminar">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif  
</div>
