<div class="p-1 border border-gray-700">
    @php
        $classesBtn ="text-white p-2 rounded text-sm"
    @endphp
    <x-subtitulo>
        Listado de Telefonos
    </x-subtitulo>
    <button class="bg-green-600 hover:bg-green-700 text-white rounded text-sm p-2 my-1"
        wire:click="modalNuevoTelefono">
            + Telefóno 
    </button>
    <!--Alertas-->
    @if($alertaMensaje)
        <div class="px-2 py-1 bg-{{$alertaTipo}}-100 border-l-4 border-{{$alertaTipo}}-600 text-{{$alertaTipo}}-800 text-sm font-bold mt-1">
            {{ $alertaMensaje }}
        </div>
    @endif
    @if($modalNuevoTelefono)
        <div class="p-2 border border-gray-700 my-1">
            <x-subtitulo-h-cuatro>
                Añadir teléfono
            </x-subtitulo-h-cuatro>
            <form class="p-2 text-sm" wire:submit.prevent='nuevoTelefono'>
                <!-- Tipo -->
                <div>
                    <x-input-label for="tipo" :value="__('Tipo de Contacto:')" />
                    <select
                        id="tipo"
                        class="block mt-1 w-full text-sm rounded-md border-gray-300"
                        wire:model="tipo">
                        <option value="">Seleccionar</option>
                        <option value="Celular">Celular</option>
                        <option value="Tel. Fijo">Tel. Fijo</option>
                        <option value="WhastApp">WhastApp</option>
                        <option value="Email">Email</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                </div>
                <!-- Contacto -->
                <div class="mt-2">
                    <x-input-label for="contacto" :value="__('Contacto:')" />
                    <select
                        id="contacto"
                        class="block mt-1 w-full text-sm rounded-md border-gray-300"
                        wire:model="contacto">
                            <option value="">Seleccionar</option>
                            <option value="Titular">Titular</option>
                            <option value="Referencia">Referencia</option>
                            <option value="Laboral">Laboral</option>
                            <option value="Familiar">Familiar</option>
                    </select>
                    <x-input-error :messages="$errors->get('contacto')" class="mt-2" />
                </div>
                <!-- Número -->
                <div class="mt-2">
                    <x-input-label for="numero" :value="__('Número:')" />
                    <x-text-input
                        id="numero"
                        placeholder="Indicar número y prefijo"
                        class="block mt-1 w-full text-sm"
                        type="text"
                        wire:model="numero"
                        :value="old('numero')"
                        />
                    <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                </div>
                <!-- Email -->
                <div class="mt-2">
                    <x-input-label for="email" :value="__('Email:')" />
                    <x-text-input
                        id="email"
                        placeholder="Indicar email"
                        class="block mt-1 w-full text-sm"
                        type="text"
                        wire:model="email"
                        :value="old('email')"
                        />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Estado -->
                <div class="mt-2">
                    <x-input-label for="estado" :value="__('Estado:')" />
                    <select
                        id="estado"
                        class="block mt-1 w-full text-sm rounded-md border-gray-300"
                        wire:model="estado" >
                            <option selected value="">-- Seleccionar --</option>
                            <option value="1">Verificado</option>
                            <option value="2">No Verificado</option>
                    </select>
                    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                </div>
                <div class="flex justify-center gap-2 mt-2">
                    <input 
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 {{$classesBtn}} cursor-pointer w-full"
                        value="Nuevo Teléfono"
                    />
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700 w-full"
                            wire:click.prevent="cerrarModalNuevoTelefono">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    @endif
    @if($telefonos->count())
        <div class="grid md:grid-cols-2 md:gap-2 lg:gap-0 lg:grid-cols-1 overflow-y-auto" style="max-height: 380px;">
            @foreach($telefonos as $index => $telefono)
                <div class="p-2 border border-gray-700 my-1 md:my-0 lg:my-1 {{ $index % 2 == 0 ? 'bg-blue-100' : 'bg-white' }}">
                    <p>Tipo:
                        <span class="font-bold">
                            {{$telefono->tipo}}
                        </span>
                    </p>
                    <p>Contacto:
                        <span class="font-bold">
                            {{$telefono->contacto}}
                        </span>
                    </p>
                    @if($telefono->email)
                        <p>Email:
                            <span class="font-bold">
                                {{$telefono->email}}
                            </span>
                        </p>
                    @elseif($telefono->numero)
                        <p>Número:
                            <span class="font-bold">
                                {{$telefono->numero}}
                            </span>
                        </p>
                    @endif
                    <p>Ult. Modif:
                        <span class="font-bold">
                            {{$telefono->usuarioUltimaModificacion->name}} 
                            {{$telefono->usuarioUltimaModificacion->apellido}} 
                        </span>
                    </p>
                    <p>Fecha:
                        <span class="font-bold">
                            {{ \Carbon\Carbon::parse($telefono->updated_at)->format('d/m/Y - H:i:s') }}
                        </span>
                    </p>
                    <div class="grid grid-cols-3 justify-center gap-1 mt-2">
                        <button class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900"
                                wire:click="mostrarModalActualizarTelefono({{ $telefono->id }})">
                            Actualizar
                        </button>
                        @if($telefono->estado == 1)
                            <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                                    wire:click="mostrarModalCambiarEstado({{ $telefono->id }})">
                                Verificado
                            </button>
                        @else
                            <button class="{{$classesBtn}} bg-gray-600 hover:bg-gray-700"
                                    wire:click="mostrarModalCambiarEstado({{ $telefono->id }})">
                                Sin Verificar
                            </button>
                        @endif
                        
                        <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                wire:click="mostrarModalEliminar({{ $telefono->id }})">
                            Eliminar
                        </button>         
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            El deudor no tiene teléfonos
        </p>
    @endif
    <!--Modal actualizar telefono-->
    @if($modalActualizarTelefono)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="text-sm px-1">Actualizar información de
                <span class="font-bold">
                    {{$telefonoSeleccionado->deudorId->nombre}}
                </span>
            </p>
            <form class="w-full mt-1.5 text-sm px-1" wire:submit.prevent='actualizarTelefono'>
                <!-- Tipo -->
                <div>
                    <x-input-label for="tipo" :value="__('Tipo de Contacto:')" />
                    <select
                        id="tipo"
                        class="block mt-1 w-full text-sm rounded-md border-gray-300"
                        wire:model="tipo"
                        >
                            <option value="">Seleccionar</option>
                            <option value="Celular">Celular</option>
                            <option value="Tel. Fijo">Tel. Fijo</option>
                            <option value="WhastApp">WhastApp</option>
                            <option value="Email">Email</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                </div>
                <!-- Contacto -->
                <div class="mt-2">
                    <x-input-label for="contacto" :value="__('Contacto:')" />
                    <select
                            id="contacto"
                            class="block mt-1 w-full text-sm rounded-md border-gray-300"
                            wire:model="contacto"
                        >
                            <option value="">Seleccionar</option>
                            <option value="Titular">Titular</option>
                            <option value="Referencia">Referencia</option>
                            <option value="Laboral">Laboral</option>
                            <option value="Familiar">Familiar</option>
                    </select>
                    <x-input-error :messages="$errors->get('contacto')" class="mt-2" />
                </div>
                <!-- Número -->
                <div class="mt-2">
                    <x-input-label for="numero" :value="__('Número:')" />
                    <x-text-input
                        id="numero"
                        placeholder="Indicar número y prefijo"
                        class="block mt-1 w-full text-sm"
                        type="text"
                        wire:model="numero"
                        :value="old('numero')"
                        />
                    <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                </div>
                <!-- Email -->
                <div class="mt-2">
                    <x-input-label for="email" :value="__('Email:')" />
                    <x-text-input
                        id="email"
                        placeholder="Indicar email"
                        class="block mt-1 w-full text-sm"
                        type="text"
                        wire:model="email"
                        :value="old('email')"
                        />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Estado -->
                <div class="mt-2">
                    <x-input-label for="estado" :value="__('Estado:')" />
                    <select
                        id="estado"
                        class="block mt-1 w-full text-sm rounded-md border-gray-300"
                        wire:model="estado"
                        >
                            <option selected value="">-- Seleccionar --</option>
                            <option value="1">Verificado</option>
                            <option value="2">No Verificado</option>
                    </select>
                    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                </div>
                <div class="flex justify-center gap-2 mt-2">
                    <input 
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 {{$classesBtn}} cursor-pointer w-full"
                        value="Actualizar Teléfono"
                    />
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700 w-full"
                            wire:click.prevent="cerrarModalActualizarTelefono">
                        Cancelar
                    </button>
                </div>
            </form>
        </x-modal-estado>
    @endif
    <!--Modal cambiar estado-->
    @if($modalEstado)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1">Confirmar cambiar estado de
                @if($telefonoSeleccionado->numero)
                    <span class="font-bold">
                        {{$telefonoSeleccionado->numero}}
                    </span>
                @elseif($telefonoSeleccionado->email)
                    <span class="font-bold">
                        {{$telefonoSeleccionado->email}}
                    </span>
                @endif
            </p>
            <!--Contenedor Botones-->
            <div class="flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                        wire:click="confirmarCambiarEstado({{ $telefonoSeleccionado->id }})">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalEstado">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
    <!--Modal eliminar telefono-->
    @if($modalEliminar)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1">Confirmar eliminar
                @if($telefonoSeleccionado->numero)
                    <span class="font-bold">
                        {{$telefonoSeleccionado->numero}}
                    </span>
                @elseif($telefonoSeleccionado->email)
                    <span class="font-bold">
                        {{$telefonoSeleccionado->email}}
                    </span>
                @endif
            </p>
            <!--Contenedor botones-->
            <div class="flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                        wire:click="confirmarEliminarTelefono({{ $telefonoSeleccionado->id }})">
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
