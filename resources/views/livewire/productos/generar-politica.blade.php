<form wire:submit.prevent='guardarPolitica' class="mt-2 border p-1">
    @php
        $classesBtn ="text-white px-4 py-2 rounded text-sm"
    @endphp
    @if($paso === 1)
        <div>
            <x-subtitulo-h-cuatro>
                Indicar primer propiedad y valor de la operación para que se cumpla la condición
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-3 p-2">
                <!--Propiedad uno-->
                <div class="mt-1">
                    <x-input-label for="propiedad_politica_uno" :value="__('Propiedad de la operación')" />
                    <select
                        id="propiedad_politica_uno"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="propiedad_politica_uno"
                        wire:change="propiedadSeleccionadaUno">
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('propiedad_politica_uno')" class="mt-2" />
                </div>
                <!--Valor uno-->
                <div class="mt-1">
                    <x-input-label for="valor_propiedad_uno" :value="__('Valor de la Propiedad')" />
                    <select
                        id="valor_propiedad_uno"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="valor_propiedad_uno">
                            <option value="">Seleccionar</option>
                            @foreach($valores_uno as $valor_uno)
                                <option value="{{ $valor_uno }}">{{ $valor_uno }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('valor_propiedad_uno')" class="mt-2" />
                </div>
                <!-- Posible política -->
                <div class="mt-1">
                    <x-input-label for="politica_posible_uno" :value="__('La política tiene más condiciones?')" />
                    <select
                            id="politica_posible_uno"
                            class="block mt-1 w-full rounded-md border-gray-300"
                            wire:model="politica_posible_uno"
                        >
                        <option value="">Seleccionar</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                    <x-input-error :messages="$errors->get('politica_posible_uno')" class="mt-2" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <span>
                </span>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoUno">
                    Siguiente
                </button>
            </div>
        </div>
    @elseif($paso === 2)
        <div>
            <x-subtitulo-h-cuatro>
                Indicar segunda propiedad y valor de la operación para que se cumpla la condición
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-3 p-2">
                <!--Propiedad dos-->
                <div class="mt-1">
                    <x-input-label for="propiedad_politica_dos" :value="__('Propiedad de la operación')" />
                    <select
                        id="propiedad_politica_dos"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="propiedad_politica_dos"
                        wire:change="propiedadSeleccionadaDos">
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('propiedad_politica_dos')" class="mt-2" />
                </div>
                <!--Valor dos-->
                <div class="mt-1">
                    <x-input-label for="valor_propiedad_dos" :value="__('Valor de la Propiedad')" />
                    <select
                        id="valor_propiedad_dos"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="valor_propiedad_dos">
                            <option value="">Seleccionar</option>
                            @foreach($valores_dos as $valor_dos)
                                <option value="{{ $valor_dos }}">{{ $valor_dos }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('valor_propiedad_dos')" class="mt-2" />
                </div>
                <!-- Posible política dos-->
                <div class="mt-1">
                    <x-input-label for="politica_posible_dos" :value="__('La política tiene más condiciones?')" />
                    <select
                            id="politica_posible_dos"
                            class="block mt-1 w-full rounded-md border-gray-300"
                            wire:model="politica_posible_dos"
                        >
                        <option value="">Seleccionar</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                    <x-input-error :messages="$errors->get('politica_posible_dos')" class="mt-2" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="pasoAnterior">
                    Anterior
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoDos">
                    Siguiente
                </button>
            </div>
        </div>
    @elseif($paso === 3)
        <div>
            <x-subtitulo-h-cuatro>
                Indicar tercer propiedad y valor de la operación para que se cumpla la condición
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-3 p-2">
                <!--Propiedad tres-->
                <div class="mt-1">
                    <x-input-label for="propiedad_politica_tres" :value="__('Propiedad de la operación')" />
                    <select
                        id="propiedad_politica_tres"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="propiedad_politica_tres"
                        wire:change="propiedadSeleccionadaTres">
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('propiedad_politica_tres')" class="mt-2" />
                </div>
                <!--Valor tres-->
                <div class="mt-1">
                    <x-input-label for="valor_propiedad_tres" :value="__('Valor de la Propiedad')" />
                    <select
                        id="valor_propiedad_tres"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="valor_propiedad_tres">
                            <option value="">Seleccionar</option>
                            @foreach($valores_tres as $valor_tres)
                                <option value="{{ $valor_tres }}">{{ $valor_tres }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('valor_propiedad_tres')" class="mt-2" />
                </div>
                <!-- Posible política tres-->
                <div class="mt-1">
                    <x-input-label for="politica_posible_tres" :value="__('La política tiene más condiciones?')" />
                    <select
                            id="politica_posible_tres"
                            class="block mt-1 w-full rounded-md border-gray-300"
                            wire:model="politica_posible_tres"
                        >
                        <option value="">Seleccionar</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                    <x-input-error :messages="$errors->get('politica_posible_tres')" class="mt-2" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="pasoAnterior">
                    Anterior
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoTres">
                    Siguiente
                </button>
            </div>
        </div>
    @elseif($paso === 4)
        <div>
            <x-subtitulo-h-cuatro>
                Indicar cuarta propiedad y valor de la operación para que se cumpla la condición
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 p-2">
                <!--Propiedad cuatro-->
                <div class="mt-1">
                    <x-input-label for="propiedad_politica_cuatro" :value="__('Propiedad de la operación')" />
                    <select
                        id="propiedad_politica_cuatro"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="propiedad_politica_cuatro"
                        wire:change="propiedadSeleccionadaCuatro">
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('propiedad_politica_cuatro')" class="mt-2" />
                </div>
                <!--Valor cuatro-->
                <div class="mt-1">
                    <x-input-label for="valor_propiedad_cuatro" :value="__('Valor de la Propiedad')" />
                    <select
                        id="valor_propiedad_cuatro"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="valor_propiedad_cuatro">
                            <option value="">Seleccionar</option>
                            @foreach($valores_cuatro as $valor_cuatro)
                                <option value="{{ $valor_cuatro }}">{{ $valor_cuatro }}</option>
                            @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('valor_propiedad_cuatro')" class="mt-2" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900" wire:click.prevent="pasoAnterior">
                    Anterior
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="valoresQuitaCuota">
                    Siguiente
                </button>
            </div>
        </div>
    @elseif($valoresQuitaCuota)
        <div>
            <x-subtitulo-h-cuatro>
                Ingresá los límites para cada tipo de negociación
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 p-2">
                <!--Quita-->
                <div class="mt-1">
                    <x-input-label for="valor_quita" :value="__('% máximo de quita')" />
                    <x-text-input
                            id="valor_quita"
                            placeholder="% máximo de quita"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="valor_quita"
                            :value="old('valor_quita')"
                            />
                    <x-input-error :messages="$errors->get('valor_quita')" class="mt-2" />
                </div>
                <!--Cuotas-->
                <div class="mt-1">
                    <x-input-label for="valor_cuota" :value="__('Cant. mínima de ctas.')" />
                    <x-text-input
                            id="valor_cuota"
                            placeholder="Cant. mínima de ctas."
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="valor_cuota"
                            :value="old('valor_cuota')"
                            />
                    <x-input-error :messages="$errors->get('valor_cuota')" class="mt-2" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}}  bg-red-600 hover:bg-red-700" wire:click.prevent="anteriorValoresQuitaCuota">
                    Anterior
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="resumen">
                    Siguiente
                </button>
            </div>
        </div>
    @elseif($resumen)
        <div>
            <x-subtitulo-h-cuatro>
                Resumen
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 p-2">
                <!--Condición uno-->
                @if($this->propiedad_politica_uno)
                    <div class="mt-1">
                        <x-subtitulo-h-cuatro>
                            Condición uno
                        </x-subtitulo-h-cuatro>
                        <p>Propiedad de la Op: <span class="font-bold">{{$this->propiedad_politica_uno}}</span></p>
                        <p>Valor de la Prop: <span class="font-bold">{{$this->valor_propiedad_uno}}</span></p>
                    </div>
                @endif
                <!--Condición dos-->
                @if($this->propiedad_politica_dos)
                    <div class="mt-1">
                        <x-subtitulo-h-cuatro>
                            Condición dos
                        </x-subtitulo-h-cuatro>
                        <p>Propiedad de la Op: <span class="font-bold">{{$this->propiedad_politica_dos}}</span></p>
                        <p>Valor de la Prop: <span class="font-bold">{{$this->valor_propiedad_dos}}</span></p>
                    </div>
                @endif
                <!--Condición tres-->
                @if($this->propiedad_politica_tres)
                    <div class="mt-1">
                        <x-subtitulo-h-cuatro>
                            Condición tres
                        </x-subtitulo-h-cuatro>
                        <p>Propiedad de la Op: <span class="font-bold">{{$this->propiedad_politica_tres}}</span></p>
                        <p>Valor de la Prop: <span class="font-bold">{{$this->valor_propiedad_tres}}</span></p>
                    </div>
                @endif
                <!--Condición cuatro-->
                @if($this->propiedad_politica_cuatro)
                    <div class="mt-1">
                        <x-subtitulo-h-cuatro>
                            Condición cuatro
                        </x-subtitulo-h-cuatro>
                        <p>Propiedad de la Op: <span class="font-bold">{{$this->propiedad_politica_cuatro}}</span></p>
                        <p>Valor de la Prop: <span class="font-bold">{{$this->valor_propiedad_cuatro}}</span></p>
                    </div>
                @endif
            </div>
            <div>
                <!--Limites-->
                <div class="mt-1">
                    <x-subtitulo-h-cuatro>
                        Límites de negociación
                    </x-subtitulo-h-cuatro>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 p-2 text-center">
                        <p class="border p-2">% máximo de Quita: <span class="font-bold">{{$this->valor_quita}}%</span></p>
                        <p class="border p-2">Cant. Máxima de Ctas: <span class="font-bold">{{$this->valor_cuota}}</span></p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="volverValoresQuitaCuota">
                    Volver
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                    Guardar
                </button>
            </div>
        </div>
    @endif
</form>