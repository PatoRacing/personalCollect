<div>
    <!-- clases-->
    @php
        $classesSpan = "font-bold text-black";
        $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-2 text-center py-2";
        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
        $classesTipo = "text-center bg-blue-800 text-white py-2 font-bold rounded my-4 uppercase";
        $classesButtonTrue = "text-white rounded-md text-sm bg-blue-400 border-2 text-center py-3 px-6";
        $classesButtonFalse = "text-white rounded-md bg-blue-300 text-sm border-2 text-center py-3 px-6";
    @endphp
    <form 
        class="container p-2 border" wire:submit.prevent='crearProducto'>
        <h2 class="text-center bg-white font-bold text-gray-500 border-y-2 p-4 mb-2">Ingresa los valores para informar un pago</h2>
            <div class="bg-white px-4 py-4 border">
                <div class="flex p-6 justify-between bg-gray-200 mb-4">
                    <p>Deudor:
                        <span class="{{$classesSpan}}">
                            {{$pago->acuerdo->propuesta->deudorId->nombre}}
                        </span>
                    </p>
                    <p>DNI Deudor:
                        <span class="{{$classesSpan}}">
                            {{$pago->acuerdo->propuesta->deudorId->nro_doc}}
                        </span>
                    </p>
                    <p>Nro cuota:
                        <span class="{{$classesSpan}}">
                            {{ $pago->nro_cuota }}
                        </span>
                    </p>
                    <p>$ de la Cuota:
                        <span class="{{$classesSpan}}">
                            ${{ number_format($pago->monto, 2, ',', '.') }}
                        </span>
                    </p>
                </div>
                @if($paso === 1)
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Información General:</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 py-4">

                    <input type="hidden" name="nombre_deudor" wire:model="nombre_deudor">
                    <input type="hidden" name="dni_deudor" wire:model="dni_deudor">
                    <input type="hidden" name="nro_cuota" wire:model="nro_cuota">

                    <!-- Fecha de Pago -->
                    <div>
                        <x-input-label for="fecha_de_pago" :value="__('Fecha de Pago')" />
                        <x-text-input
                            id="fecha_de_pago"
                            class="block mt-1 w-full"
                            type="date"
                            wire:model="fecha_de_pago"
                            :value="old('fecha_de_pago')"
                            :max="now()->format('Y-m-d')"
                            />
                        <x-input-error :messages="$errors->get('fecha_de_pago')" class="mt-2" />
                    </div>

                    <!-- Monto -->
                    <div>
                        <x-input-label for="monto" :value="__('Monto Abonado')" />
                        <x-text-input
                            id="monto"
                            placeholder="Monto abonado"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="monto"
                            :value="old('monto')"
                            />
                        <x-input-error :messages="$errors->get('monto')" class="mt-2" />
                    </div>

                    <!-- Medio de pago -->
                    <div>
                        <x-input-label for="medio_de_pago" :value="__('Medio de Pago')" />
                        <select
                            id="medio_de_pago"
                            class="block mt-1 w-full rounded-md border-gray-300"
                            wire:model="medio_de_pago"
                        >
                            <option value="">Seleccionar</option>
                            <option value="deposito">Depósito</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="efectivo">Efectivo</option>
                        </select>
                        <x-input-error :messages="$errors->get('medio_de_pago')" class="mt-2" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="text-black text-sm bg-gray-100 hover:text-white hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoUno"
                    >
                        Siguiente
                    </button>
                </div>
                @endif
                @if($paso === 2)
                    @if($medioDePagoDeposito)
                        <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Condiciones del Depósito</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 py-4">     
                            <!-- Sucursal -->
                            <div>
                                <x-input-label for="sucursal" :value="__('Indicar Sucursal')" />
                                <x-text-input
                                    id="sucursal"
                                    placeholder="Sucursal del depósito"
                                    class="block mt-1 w-full"
                                    type="text"
                                    wire:model="sucursal"
                                    :value="old('sucursal')"
                                    />
                                <x-input-error :messages="$errors->get('sucursal')" class="mt-2" />
                            </div>

                            <!-- Hora -->
                            <div>
                                <x-input-label for="hora" :value="__('Hora del depósito')" />
                                <input id="hora"
                                    class="block mt-1 w-full rounded border-gray-300"
                                    placeholder="Hora del depósito"
                                    type="time"
                                    wire:model="hora"
                                />
                                <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                            </div>

                            <!-- Cuenta -->
                            <div>
                                <x-input-label for="cuenta" :value="__('En qué cuenta se hizo el pago')" />
                                <select
                                    id="cuenta"
                                    class="block mt-1 w-full rounded-md border-gray-300"
                                    wire:model="cuenta"
                                >
                                    <option value="">Seleccionar</option>
                                    <option value="501/02131868/45">501/02131868/45</option>
                                    <option value="0501/02108568/25">0501/02108568/25</option>
                                </select>
                                <x-input-error :messages="$errors->get('cuenta')" class="mt-2" />
                            </div>

                            <!-- Comrobante -->
                            <div>
                                <x-input-label for="comprobante" :value="__('Comprobante')" />
                                <x-text-input
                                    id="comprobante"
                                    class="block mt-1 w-full border p-1.5"
                                    type="file"
                                    wire:model="comprobante"
                                    accept=".jpg, .jpeg, .pdf, .png"
                                    />
                                    <div class="my-5 w-48">
                                        @if ($comprobante)
                                            @if (Str::startsWith($comprobante->getMimeType(), 'image'))
                                                Imagen:
                                                <img src="{{$comprobante->temporaryUrl()}}" alt="Vista previa de la imagen">
                                            @elseif (Str::startsWith($comprobante->getMimeType(), 'application/pdf'))
                                                Vista previa no disponible para PDF.
                                            @endif
                                        @endif
                                    </div>
                            </div>

                        </div>
                    @elseif($medioDePagoTransferencia)
                        <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Condiciones de la Transferencia</h3>     
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 py-4">
                            
                            <!-- Nombre del Tercero -->
                            <div>
                                <x-input-label for="nombre_tercero" :value="__('Nombre del titular')" />
                                <x-text-input
                                    id="nombre_tercero"
                                    placeholder="Titular de la cuenta"
                                    class="block mt-1 w-full"
                                    type="text"
                                    wire:model="nombre_tercero"
                                    :value="old('nombre_tercero')"
                                    />
                                <x-input-error :messages="$errors->get('nombre_tercero')" class="mt-2" />
                            </div>

                            <!-- Cuenta -->
                            <div>
                                <x-input-label for="cuenta" :value="__('En qué cuenta se hizo el pago')" />
                                <select
                                    id="cuenta"
                                    class="block mt-1 w-full rounded-md border-gray-300"
                                    wire:model="cuenta"
                                >
                                    <option value="">Seleccionar</option>
                                    <option value="501/02131868/45">501/02131868/45</option>
                                    <option value="0501/02108568/25">0501/02108568/25</option>
                                </select>
                                <x-input-error :messages="$errors->get('cuenta')" class="mt-2" />
                            </div>

                            <!-- Comrobante -->
                            <div>
                                <x-input-label for="comprobante" :value="__('Comprobante')" />
                                <x-text-input
                                    id="comprobante"
                                    class="block mt-1 w-full border p-1.5"
                                    type="file"
                                    wire:model="comprobante"
                                    accept=".jpg, .jpeg, .pdf, .png"
                                    />
                                    <div class="my-5 w-48">
                                        @if ($comprobante)
                                            @if (Str::startsWith($comprobante->getMimeType(), 'image'))
                                                Imagen:
                                                <img src="{{$comprobante->temporaryUrl()}}" alt="Vista previa de la imagen">
                                            @elseif (Str::startsWith($comprobante->getMimeType(), 'application/pdf'))
                                                Vista previa no disponible para PDF.
                                            @endif
                                        @endif
                                    </div>
                            </div>
                            
                        </div>
                    @elseif($medioDePagoEfectivo)
                        <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Condiciones del Pago</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 py-4">
                            <!-- Efectivo -->
                            <div>
                                <x-input-label for="central_de_pago" :value="__('Central de pago:')" />
                                <select
                                    id="central_de_pago"
                                    class="block mt-1 w-full rounded-md border-gray-300"
                                    wire:model="central_de_pago"
                                >
                                    <option value="">Seleccionar</option>
                                    <option value="RapiPago">RapiPago</option>
                                    <option value="Pago Facil">Pago Fácil</option>
                                </select>
                                <x-input-error :messages="$errors->get('central_de_pago')" class="mt-2" />
                            </div>
                            <!-- Comrobante -->
                            <div>
                                <x-input-label for="comprobante" :value="__('Comprobante')" />
                                <x-text-input
                                    id="comprobante"
                                    class="block mt-1 w-full border p-1.5"
                                    type="file"
                                    wire:model="comprobante"
                                    accept=".jpg, .jpeg, .pdf, .png"
                                    />
                                    <div class="my-5 w-48">
                                        @if ($comprobante)
                                            @if (Str::startsWith($comprobante->getMimeType(), 'image'))
                                                Imagen:
                                                <img src="{{$comprobante->temporaryUrl()}}" alt="Vista previa de la imagen">
                                            @elseif (Str::startsWith($comprobante->getMimeType(), 'application/pdf'))
                                                Vista previa no disponible para PDF.
                                            @endif
                                        @endif
                                    </div>
                            </div>
                        </div>
                    @endif
                <div class="flex justify-center gap-2">
                    <button class="text-black text-sm bg-gray-100 hover:text-white hover:bg-gray-400 border border-gray-300 px-8 py-2.5 rounded"
                            wire:click.prevent="anterior"
                    >
                        Volver
                    </button>
                    <button class="text-white bg-green-700 hover:bg-green-900 px-8 py-2.5 rounded"
                            wire:click.prevent="guardarNuevaOperacion"
                    >
                        Guardar
                    </button>
                </div>
            </div>
            @endif
    </form>
</div>
