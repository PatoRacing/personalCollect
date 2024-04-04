<div>
    <form 
        class="container p-2 border" wire:submit.prevent='guardarPolitica'>
        <h2 class="text-center bg-white font-bold text-gray-500 border-y-2 p-4 mb-2">Ingresa los valores para crear una nueva politica</h2>
        
        @if($paso === 1)
            <div class="bg-white px-4 py-4 border">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Ingresá la propiedad y el valor de la misma para que se cumpla la condición</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Propiedad uno -->
                    <div class="mt-3">
                        <x-input-label for="propiedad_politica_uno" :value="__('Cual es la propiedad de la operación que debe cumplir la condición?')" />
                        <select
                            id="propiedad_politica_uno"
                            class="block uppercase mt-1 w-full rounded-md border-gray-300"
                            wire:model="propiedad_politica_uno"
                            wire:change="propiedadSeleccionadaUno"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('propiedad_politica_uno')" class="mt-2" />
                    </div>

                    <!-- Valores -->
                    <div class="mt-3">
                        <x-input-label for="valor_propiedad_uno" :value="__('Cual debe ser el valor de la propiedad para cumplir la condición?')" />
                        <select
                            id="valor_propiedad_uno"
                            class="block mt-1 w-full uppercase rounded-md border-gray-300"
                            wire:model="valor_propiedad_uno"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($valores_uno as $valor_uno)
                                <option value="{{ $valor_uno }}">{{ $valor_uno }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('valor_propiedad_uno')" class="mt-2" />
                    </div>

                    <!-- Posible política -->
                    <div>
                        <x-input-label for="politica_posible_uno" :value="__('La política debe cumplir una segunda condición?')" />
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

                <div class="flex justify-end">
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoUno"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif

        @if($paso === 2)
            <div class="bg-white px-4 py-4 border">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Ingresá la segunda propiedad y el valor de la misma</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Propiedad dos -->
                    <div class="mt-3">
                        <x-input-label for="propiedad_politica_dos" :value="__('Cual es la segunda propiedad que debe cumplir la condición?')" />
                        <select
                            id="propiedad_politica_dos"
                            class="block uppercase mt-1 w-full rounded-md border-gray-300"
                            wire:model="propiedad_politica_dos"
                            wire:change="propiedadSeleccionadaDos"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('propiedad_politica_dos')" class="mt-2" />
                    </div>

                    <!-- Valores -->
                    <div class="mt-3">
                        <x-input-label for="valor_propiedad_dos" :value="__('Cual debe ser el valor de la propiedad para cumplir la segunda condición?')" />
                        <select
                            id="valor_propiedad_dos"
                            class="block uppercase mt-1 w-full rounded-md border-gray-300"
                            wire:model="valor_propiedad_dos"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($valores_dos as $valor_dos)
                                <option value="{{ $valor_dos }}">{{ $valor_dos }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('valor_propiedad_dos')" class="mt-2" />
                    </div>

                    <!-- Posible política 2 -->
                    <div>
                        <x-input-label for="politica_posible_dos" :value="__('La política debe cumplir una tercera condición?')" />
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

                <div class="flex justify-between">
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="pasoAnterior"
                    >
                        Anterior
                    </button>
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoDos"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif

        @if($paso === 3)
            <div class="bg-white px-4 py-4 border">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Ingresá la tercera propiedad y el valor de la misma</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Propiedad tres -->
                    <div class="mt-3">
                        <x-input-label for="propiedad_politica_tres" :value="__('Cual es la tercera propiedad que debe cumplir la condición?')" />
                        <select
                            id="propiedad_politica_tres"
                            class="block uppercase mt-1 w-full rounded-md border-gray-300"
                            wire:model="propiedad_politica_tres"
                            wire:change="propiedadSeleccionadaTres"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('propiedad_politica_tres')" class="mt-2" />
                    </div>

                    <!-- Valores -->
                    <div class="mt-3">
                        <x-input-label for="valor_propiedad_tres" :value="__('Cual debe ser el valor de la propiedad para cumplir la tercera condición?')" />
                        <select
                            id="valor_propiedad_tres"
                            class="block uppercase mt-1 w-full rounded-md border-gray-300"
                            wire:model="valor_propiedad_tres"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($valores_tres as $valor_tres)
                                <option value="{{ $valor_tres }}">{{ $valor_tres }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('valor_propiedad_tres')" class="mt-2" />
                    </div>

                    <!-- Posible política 3 -->
                    <div>
                        <x-input-label for="politica_posible_tres" :value="__('La política debe cumplir una cuarta condición?')" />
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

                <div class="flex justify-between">
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="pasoAnterior"
                    >
                        Anterior
                    </button>
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoTres"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif

        @if($paso === 4)
            <div class="bg-white px-4 py-4 border">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Ingresá la cuarta propiedad y el valor de la misma</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Propiedad cuarta -->
                    <div class="mt-3">
                        <x-input-label for="propiedad_politica_cuatro" :value="__('Cual es la cuarta propiedad que debe cumplir la condición?')" />
                        <select
                            id="propiedad_politica_cuatro"
                            class="block uppercase mt-1 w-full rounded-md border-gray-300"
                            wire:model="propiedad_politica_cuatro"
                            wire:change="propiedadSeleccionadaCuatro"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($propiedadesOperacion as $propiedadOperacion)
                                <option value="{{ $propiedadOperacion }}">{{ $propiedadOperacion }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('propiedad_politica_cuatro')" class="mt-2" />
                    </div>

                    <!-- Valores -->
                    <div class="mt-3">
                        <x-input-label for="valor_propiedad_cuatro" :value="__('Cual debe ser el valor de la propiedad para cumplir la cuarta condición?')" />
                        <select
                            id="valor_propiedad_cuatro"
                            class="block uppercase mt-1 w-full rounded-md border-gray-300"
                            wire:model="valor_propiedad_cuatro"
                        >
                            <option value="">Seleccionar</option>
                            @foreach($valores_cuatro as $valor_cuatro)
                                <option value="{{ $valor_cuatro }}">{{ $valor_cuatro }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('valor_propiedad_cuatro')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-between">
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="pasoAnterior"
                    >
                        Anterior
                    </button>
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="valoresQuitaCuota"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif

        @if($valoresQuitaCuota)
            <div class="bg-white px-4 py-4 border">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Ingresá los valores para cada tipo de negociación en caso de que se cumpla la política</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Quita -->
                    <div class="mt-3">
                        <x-input-label for="valor_quita" :value="__('% máximo de Quita')" />
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

                    <!-- Cuotas -->
                    <div class="mt-3">
                        <x-input-label for="valor_cuota" :value="__('Cantidad máxima de cuotas')" />
                        <x-text-input
                            id="valor_cuota"
                            placeholder="Indicá la cantidad máxima de cuotas"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="valor_cuota"
                            :value="old('valor_cuota')"
                            />
                        <x-input-error :messages="$errors->get('valor_cuota')" class="mt-2" />
                    </div>

                    <!-- % descuento con cuotas -->
                    <div>
                        <x-input-label for="valor_quita_descuento" :value="__('% máximo de quita y cuotas')" />
                        <x-text-input
                            id="valor_quita_descuento"
                            placeholder="% máximo de quita y cuotas"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="valor_quita_descuento"
                            :value="old('valor_quita_descuento')"
                            />
                        <x-input-error :messages="$errors->get('valor_quita_descuento')" class="mt-2" />
                    </div>

                    <!-- Cantidad de cuotas con descuento-->
                    <div>
                        <x-input-label for="valor_cuota_descuento" :value="__('Cantidad máxima de cuotas con quita')" />
                        <x-text-input
                            id="valor_cuota_descuento"
                            placeholder="Cantidad máxima de cuotas con quita"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="valor_cuota_descuento"
                            :value="old('valor_cuota_descuento')"
                            />
                        <x-input-error :messages="$errors->get('valor_cuota_descuento')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-between">
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="anteriorValoresQuitaCuota"
                    >
                        Anterior
                    </button>
                    <button class="text-black text-sm bg-gray-100 hover:bg-gray-400 border hover:text-white border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="resumen"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif

        @if($resumen)
            <div class="bg-white px-8 py-4">
                <h3 class="text-center border border-gray-300 shadow-sm uppercase text-2xl py-4 font-bold rounded">Resumen</h3>
                <div class="p-6 container grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!--Condicion uno-->
                    @if($this->propiedad_politica_uno)
                    <div class="px-4">
                        <h3 class="text-center border-b-2 py-4 font-bold rounded mb-4 uppercase">Condición uno:</h3>
                        <p class="text-gray-600">Propiedad de la operación: <span class="font-bold uppercase text-black">{{$this->propiedad_politica_uno}}</span></p>
                        <p class="text-gray-600">Valor de la propiedad: <span class="font-bold uppercase text-black">{{$this->valor_propiedad_uno}}</span></p>
                        
                    </div>
                    @endif

                    <!--Condicion dos-->
                    @if($this->propiedad_politica_dos)
                        <div class="px-4">
                            <h3 class="text-center border-b-2 py-4 font-bold rounded mb-4 uppercase">Condición Dos:</h3>
                            <p class="text-gray-600">Propiedad de la operación: <span class="font-bold uppercase text-black">{{$this->propiedad_politica_dos}}</span></p>
                            <p class="text-gray-600">Valor de la propiedad: <span class="font-bold uppercase text-black">{{$this->valor_propiedad_dos}}</span></p>
                        </div>
                    @endif

                    <!--Condicion tres-->
                    @if($this->propiedad_politica_tres)
                        <div class="px-4">
                            <h3 class="text-center border-b-2 py-4 font-bold rounded mb-4 uppercase">Condición Tres:</h3>
                            <p class="text-gray-600">Propiedad de la operación: <span class="font-bold uppercase text-black">{{$this->propiedad_politica_tres}}</span></p>
                            <p class="text-gray-600">Valor de la propiedad: <span class="font-bold uppercase text-black">{{$this->valor_propiedad_tres}}</span></p>
                        </div>
                    @endif

                    <!--Condicion cuatro-->
                    @if($this->propiedad_politica_cuatro)
                        <div class="px-4">
                            <h3 class="text-center border-b-2 py-4 font-bold rounded mb-4 uppercase">Condición Cuatro:</h3>
                            <p class="text-gray-600">Propiedad de la operación: <span class="font-bold uppercase text-black">{{$this->propiedad_politica_cuatro}}</span></p>
                            <p class="text-gray-600">Valor de la propiedad: <span class="font-bold uppercase text-black">{{$this->valor_propiedad_cuatro}}</span></p>
                        </div>
                    @endif

                </div>
                <div>
                    <!--Caso 1-->
                    @if(!$this->propiedad_politica_cuatro && !$this->propiedad_politica_tres && !$this->propiedad_politica_dos && $this->propiedad_politica_uno)
                        <div class="text-center bg-gray-200 rounded border mt-4">
                            <h3 class="uppercase text-2xl py-4 font-bold rounded">Definición de la Condición:</h3>
                            <p class="px-10 py-4 bg-blue-200 rounded">
                                Si la propiedad de la operación <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_uno}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_uno}}</span>
                                se puede aplicar un máximo de <span class="font-extrabold uppercase text-black">{{$this->valor_quita}}% de quita</span>
                                y la cantidad de cuotas no pueden ser superiores a <span class="font-extrabold uppercase text-black">{{$this->valor_cuota}} cuotas.</span>
                                <br> Para el caso de cuotas con descuento el limite de quita es <span class="font-extrabold text-black uppercase">{{$this->valor_quita_descuento}}% de quita</span>
                                y las cuotas no pueden ser mayores a<span class="font-extrabold uppercase text-black"> {{$this->valor_cuota_descuento}} cuotas</span>
                            </p>
                        </div>
                    @endif

                    <!--Caso 2-->
                    @if(!$this->propiedad_politica_cuatro && !$this->propiedad_politica_tres && $this->propiedad_politica_dos && $this->propiedad_politica_uno)
                        <div class="text-center bg-gray-200 rounded border mt-4">
                            <h3 class="uppercase text-2xl py-4 font-bold rounded">Definición de la Condición:</h3>
                            <p class="px-10 py-4 bg-blue-200 rounded">
                                Si la propiedad <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_uno}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_uno}}</span> y además, la propiedad
                                <span class="font-extrabold text-black uppercase">{{$this->propiedad_politica_dos}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_dos}}</span>
                                se puede aplicar un máximo de <span class="font-extrabold uppercase text-black">{{$this->valor_quita}}% de quita</span>
                                y la cantidad de cuotas no pueden ser superiores a <span class=" uppercase font-extrabold text-black">{{$this->valor_cuota}} cuotas.</span>
                                <br> Para el caso de cuotas con descuento el limite de quita es <span class="font-extrabold uppercase text-black">{{$this->valor_quita_descuento}}% de quita</span>
                                y las cuotas no pueden ser mayores a<span class="font-extrabold uppercase text-black"> {{$this->valor_cuota_descuento}} cuotas</span>
                            </p>
                        </div>
                    @endif

                    <!--Caso 3-->
                    @if(!$this->propiedad_politica_cuatro && $this->propiedad_politica_tres && $this->propiedad_politica_dos && $this->propiedad_politica_uno)
                        <div class="text-center bg-gray-200 rounded border mt-4">
                            <h3 class="uppercase text-2xl py-4 font-bold rounded">Definición de la Condición:</h3>
                            <p class="px-10 py-4 bg-blue-200 rounded">
                                Si la propiedad de la operación <span class="font-bold uppercase text-black">{{$this->propiedad_politica_uno}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_uno}}</span>
                                 , la propiedad <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_dos}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_dos}}</span> y
                                la propiedad <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_tres}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_tres}}</span>
                                se puede aplicar un máximo de <span class="font-extrabold uppercase text-black">{{$this->valor_quita}}% de quita</span>
                                y la cantidad de cuotas no pueden ser superiores a <span class="font-extrabold uppercase text-black">{{$this->valor_cuota}} cuotas.</span>
                                <br> Para el caso de cuotas con descuento el limite de quita es <span class="font-extrabold uppercase text-black">{{$this->valor_quita_descuento}}% de quita</span>
                                y las cuotas no pueden ser mayores a<span class="font-extrabold uppercase text-black"> {{$this->valor_cuota_descuento}} cuotas</span>
                            </p>
                        </div>
                    @endif

                    <!--Caso 4-->
                    @if($this->propiedad_politica_cuatro && $this->propiedad_politica_tres && $this->propiedad_politica_dos && $this->propiedad_politica_uno)
                        <div class="text-center bg-gray-200 rounded border  mt-4">
                            <h3 class="uppercase text-2xl py-4 font-bold rounded">Definición de la Condición:</h3>
                            <p class="px-10 py-4 bg-blue-200 rounded">
                                Si la propiedad de la operación <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_uno}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_uno}}</span>
                                , la propiedad <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_dos}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_dos}}</span>
                                , la propiedad <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_tres}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_tres}}</span> y
                                la propiedad <span class="font-extrabold uppercase text-black">{{$this->propiedad_politica_cuatro}}</span>
                                es igual a <span class="font-extrabold uppercase text-black">{{$this->valor_propiedad_cuatro}}</span>
                                se puede aplicar un máximo de <span class="font-extrabold uppercase text-black">{{$this->valor_quita}}% de quita</span>
                                y la cantidad de cuotas no pueden ser superiores a <span class="font-extrabold uppercase text-black">{{$this->valor_cuota}} cuotas.</span>
                                <br> Para el caso de cuotas con descuento el limite de quita es <span class="font-extrabold uppercase text-black">{{$this->valor_quita_descuento}}% de quita</span>
                                y las cuotas no pueden ser mayores a<span class="font-extrabold uppercase text-black"> {{$this->valor_cuota_descuento}} cuotas</span>
                            </p>
                        </div>
                    @endif
                </div>
                <div class="flex justify-between">
                    <button class="text-white bg-red-600 hover:bg-red-700 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="volverValoresQuitaCuota"
                    >
                        Volver
                    </button>
                    <button class="text-white bg-green-700 hover:bg-green-900 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="guardarPolitica"
                    >
                        Guardar
                    </button>
                </div>
            </div>
        @endif
    </form>
</div>

