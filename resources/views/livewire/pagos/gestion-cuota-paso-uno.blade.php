<div class="p-1">
    @php
        $classesBtn ="text-white py-2 rounded text-sm"
    @endphp
    <x-subtitulo>
        {{ucwords(strtolower($pago->acuerdo->propuesta->deudorId->nombre))}} - Cuota nro: {{$pago->nro_cuota}} 
    </x-subtitulo>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-1">
        <!--Detalle de la cuota-->
        <div class="p-1 border border-gray-700 overflow-y-auto">
            <x-subtitulo-h-cuatro>
                Detalle de la Cuota
            </x-subtitulo-h-cuatro>
            <div class="p-1 overflow-y-auto" style="max-height: 300px;">
                <p class="mt-1">Cliente:
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->clienteId->nombre }}
                    </span>
                </p>
                <p>DNI Deudor:
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->deudorId->nro_doc }}
                    </span>
                </p>
                <p>CUIL Deudor:
                    @if($pago->acuerdo->propuesta->deudorId->cuil)
                        <span class="font-bold">
                            {{ $pago->acuerdo->propuesta->deudorId->cuil}}
                        </span>
                    @else
                        -
                    @endif
                </p>
                <p>Operación:
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->operacion }}
                    </span>
                </p>
                <p>Segmento:
                    <span class="font-bold">
                        @if ( $pago->acuerdo->propuesta->operacionId->segmento )
                            {{ $pago->acuerdo->propuesta->operacionId->segmento }}
                        @else
                            <span class="text-red-600 font-bold">
                                Sin datos
                            </span>
                        @endif
                    </span>
                </p>
                <p>Producto:
                    <span class="font-bold">
                        {{ $pago->acuerdo->propuesta->operacionId->productoId->nombre }}
                    </span>
                </p>
                <p>Acuerdo ID:
                    <span class="font-bold">
                        {{$pago->acuerdo->id}}
                    </span>
                </p>
                <p>Tipo de Acuerdo:
                    @if($pago->acuerdo->propuesta->tipo_de_propuesta == 1)
                        <span class="font-bold">
                            Cancelación
                        </span>
                    @elseif($pago->acuerdo->propuesta->tipo_de_propuesta == 2)
                        <span class="font-bold">
                            Cuotas Fijas
                        </span>
                    @elseif($pago->acuerdo->propuesta->tipo_de_propuesta == 4)
                        <span class="font-bold">
                            Cuotas Variables
                        </span>
                    @endif
                </p>
                <p>Responsable:
                    <span class="font-bold">
                        {{$pago->acuerdo->propuesta->operacionId->usuarioAsignado->name}}
                        {{$pago->acuerdo->propuesta->operacionId->usuarioAsignado->apellido}}
                    </span>
                </p>
                <p>$ de Cuota Acordado:
                    <span class="font-bold">
                        ${{ number_format($pago->monto_acordado, 2, ',', '.') }}
                    </span>
                </p>
                <p>Concepto: 
                    <span class="font-bold">
                        {{$pago->concepto_cuota}}
                    </span>
                </p>
                <p>Vencimiento Cta: 
                    <span class="font-bold">
                        {{ \Carbon\Carbon::parse($pago->vencimiento_cuota)->format('d/m/Y') }}
                    </span>
                </p>
                <p>Nro. Cuota: 
                    <span class="font-bold">
                        {{$pago->nro_cuota}}
                    </span>
                </p>
            </div>
        </div>
        @if($aplicacionDePago)
            <!--informar un pago-->
            <div class="p-1 border border-gray-700">
                @if(auth()->user() && auth()->user()->rol == 'Administrador')
                    <x-subtitulo-h-cuatro>
                        Aplicar/Observar un pago
                    </x-subtitulo-h-cuatro>
                @else
                    <x-subtitulo-h-cuatro>
                        Informar un pago
                    </x-subtitulo-h-cuatro>
                @endif
                <form wire:submit.prevent='guardarInforme' class="p-1 overflow-y-auto" style="max-height: 300px">
                    @if($pago->estado != 4)
                        @if($pasoUno)
                            <!-- Fecha de Pago -->
                            <div class="mt-2">
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
                            <div class="mt-2">
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
                            <div class="mt-2">
                                <x-input-label for="medio_de_pago" :value="__('Medio de Pago')" />
                                <select
                                    id="medio_de_pago"
                                    class="block mt-1 w-full rounded-md border-gray-300"
                                    wire:model="medio_de_pago"
                                >
                                    <option value="">Seleccionar</option>
                                    <option value="Depósito">Depósito</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                                <x-input-error :messages="$errors->get('medio_de_pago')" class="mt-2" />
                            </div>
                            <button class="{{$classesBtn}} w-full mt-5 bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoUno">
                                Siguiente
                            </button>
                        @endif
                        @if($medioDePagoDeposito)
                            <!-- Sucursal -->
                            <div class="mt-2">
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
                            <div class="mt-2">
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
                            <div class="mt-2">
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
                            <!-- Comprobante -->
                            <div class="mt-2">
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
                            <div class="grid grid-cols-2 gap-2 mr-2">
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                                    Anterior
                                </button>
                                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                                    Informar
                                </button>
                            </div>
                        @elseif($medioDePagoTransferencia)
                            <!-- Nombre del Tercero -->
                            <div class="mt-2">
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
                            <div class="mt-2">
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
                            <!-- Comprobante -->
                            <div class="mt-2">
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
                            <div class="grid grid-cols-2 gap-2 mr-2">
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                                    Anterior
                                </button>
                                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                                    Informar
                                </button>
                            </div>
                        @elseif($medioDePagoEfectivo)
                            <!-- Efectivo -->
                            <div class="mt-2">
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
                            <!-- Comprobante -->
                            <div class="mt-2">
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
                            <div class="grid grid-cols-2 gap-2 mr-2">
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                                    Anterior
                                </button>
                                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                                    Informar
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="px-1 pt-1 lg:col-span-2">
                            <p class="text-center bg-cyan-600 text-white py-2">
                                La cuota tiene una rendición completa.
                            </p>
                        </div>
                    @endif
                </form>
            </div>
        @else
            <div class="p-1 border border-gray-700">
                <p class="p-1 text-center bg-red-600 text-white">La cuota esta aplicada en su totalidad</p>
            </div>
        @endif
    </div>
    @if($montoAbonadoSuperior)
        <!--Modal cambiar confirmar monto superior-->
        <x-modal-estado>
            <div class="max-w-1/2 mx-auto text-sm">
                <!--Contenedor Parrafos-->
                <p class="px-1 text-center">
                    El monto ingresado supera al esperado.
                </p>
                <p class="px-1">
                    El saldo se aplicará a la siguiente cuota o se generará una devolución.
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="condiciones">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalMontoAbonadoSuperior">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
</div>
