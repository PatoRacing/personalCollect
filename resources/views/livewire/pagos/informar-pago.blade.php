<div>
    <div class="border p-2">
        <x-subtitulo>
            Detalle del Pago
        </x-subtitulo>
        <div class="grid grid-cols-1 justify-center md:grid-cols-2 md:gap-2 pt-2 px-2">
            <!--columna izquierda-->
            <div class="md:border-r">
                <p>Deudor: 
                    <span class="font-bold">
                        {{ucwords(strtolower($pago->acuerdo->propuesta->deudorId->nombre))}}
                    </span>
                </p>
                <p>DNI Deudor: 
                    <span class="font-bold">
                        {{ucwords(strtolower($pago->acuerdo->propuesta->deudorId->nro_doc))}}
                    </span>
                </p>
                <p>CUIL Deudor: 
                    <span class="font-bold">
                        {{ucwords(strtolower($pago->acuerdo->propuesta->deudorId->cuil))}}
                    </span>
                </p>
                <p>Responsable: 
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->usuarioAsignado->name }}
                        {{ $pago->acuerdo->propuesta->operacionId->usuarioAsignado->apellido }}
                    </span>
                </p>
                <p>Cliente: 
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->clienteId->nombre }}
                    </span>
                </p>
                <p>Operación: 
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->operacion }}
                    </span>
                </p>
            </div>
            <!--columna derecha-->
            <div>
                <p>Producto: 
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->productoId->nombre }}
                    </span>
                </p>
                <p>Segmento: 
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->segmento }}
                    </span>
                </p>
                <p>Nro. Cuota: 
                    <span class="font-bold">
                        {{ $pago->nro_cuota }}
                    </span>
                </p>
                <p>Concepto: 
                    <span class="font-bold">
                        {{ $pago->concepto_cuota }}
                    </span>
                </p>
                <p>$ de Cuota Acordado: 
                    <span class="font-bold">
                        ${{ number_format($pago->monto_acordado, 2, ',', '.') }}
                    </span>
                </p>
                <p>Vencimiento Cta: 
                    <span class="font-bold">
                        {{ \Carbon\Carbon::parse($pago->vencimiento_cuota)->format('d/m/Y') }}
                    </span>
                </p>
            </div>
        </div>
    </div>
    <div>
        <form wire:submit.prevent='guardarNuevaOperacion'class="mt-2 border p-1">
            @php
                $classesBtn ="text-white px-4 py-2 rounded text-sm"
            @endphp
            @if($pasoUno)
                <x-subtitulo-h-cuatro>
                    Paso 1: Información General
                </x-subtitulo-h-cuatro>
                <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 p-2">
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
                        <x-input-label for="monto_abonado" :value="__('Monto Abonado')" />
                        <x-text-input
                            id="monto_abonado"
                            placeholder="Monto abonado"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="monto_abonado"
                            :value="old('monto_abonado')"
                            />
                        <x-input-error :messages="$errors->get('monto_abonado')" class="mt-2" />
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
                <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 mr-2">
                    <span>
                    </span>
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoUno">
                        Siguiente
                    </button>
                </div>
            @endif
            @if($medioDePagoDeposito)
                <x-subtitulo-h-cuatro>
                    Paso 2: Condiciones del Depósito
                </x-subtitulo-h-cuatro>
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 p-2">
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
                <div class="grid grid-cols-2 gap-2 mr-2">
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                        Anterior
                    </button>
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                        Guardar
                    </button>
                </div>
            @elseif($medioDePagoTransferencia)
                <x-subtitulo-h-cuatro>
                    Paso 2: Condiciones de la Transferencia
                </x-subtitulo-h-cuatro>
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 p-2">
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
                <div class="grid grid-cols-2 gap-2 mr-2">
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                        Anterior
                    </button>
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                        Guardar
                    </button>
                </div>
            @elseif($medioDePagoEfectivo)
                <x-subtitulo-h-cuatro>
                    Paso 2: Condiciones del Pago
                </x-subtitulo-h-cuatro>
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 p-2">
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
                <div class="grid grid-cols-2 gap-2 mr-2">
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                        Anterior
                    </button>
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                        Guardar
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>
