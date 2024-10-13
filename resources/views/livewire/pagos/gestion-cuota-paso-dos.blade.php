<div class="p-1">
    @php
        $classesBtn ="text-white py-2 rounded text-sm"
    @endphp
    <x-subtitulo>
        Aplicacion y Rendición de Pagos de Cuota nro: {{$pago->nro_cuota}} 
    </x-subtitulo>
    <!--alertas-->
    @if($alertaNoGestion)
        <div class="px-2 py-1 bg-red-100 border-l-4 border-red-600 text-red-800 text-sm font-bold my-1">
            <p>No hay pagos a rendir para el Id indicado.</p>
        </div>
    @endif
    @if($alertaPagoNoAplicado)
        <div class="px-2 py-1 bg-red-100 border-l-4 border-red-600 text-red-800 text-sm font-bold my-1">
            <p>El pago a rendir no esta aplicado.</p>
        </div>
    @endif
    @if($alertaMontosNoIguales)
        <div class="px-2 py-1 bg-red-100 border-l-4 border-red-600 text-red-800 text-sm font-bold my-1">
            <p>El monto a rendir es diferente al monto aplicado.</p>
        </div>
    @endif
    @if($alertaNuevaRendicion)
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold my-1">
            <p>Pago Rendido Correctamente.</p>
        </div>
    @endif
    @if($alertaPagoRendido)
        <div class="px-2 py-1 bg-red-100 border-l-4 border-red-600 text-red-800 text-sm font-bold my-1">
            <p>El Pago ya esta rendido.</p>
        </div>
    @endif
    @if($alertaPagoFinalizado)
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold my-1">
            <p>Pago Finalizado Correctamente.</p>
        </div>
    @endif
    @if($pagosAplicados->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mt-1">
        <!--Situacion actual-->
        <div class="px-1 pt-1 border border-gray-700 lg:col-span-1">
            <x-subtitulo-h-cuatro>
                Situación actual de la Cuota
            </x-subtitulo-h-cuatro>
            <div class="p-1 my-1 lg:mt-1">
                <p class="mt-2">$ Aplicado Sin Rendir:
                    <span class="font-bold">
                        ${{ number_format($pagosAplicadosSinRendirSuma, 2, ',', '.') }}
                    </span>
                </p>
                <p>$ Aplicado Cliente:
                    <span class="font-bold">
                        ${{ number_format($pagosaplicadosCliente, 2, ',', '.') }}
                    </span>
                </p>
                <p>$ Aplicado Honorarios:
                    <span class="font-bold">
                        ${{ number_format($pagosAplicadosHonorarios, 2, ',', '.') }}
                    </span>
                </p>
                <p>$ Total Rendido:
                    <span class="font-bold">
                        ${{ number_format($pagosRendidosSuma, 2, ',', '.') }}
                    </span>
                </p>
                <p>$ Rendición Cliente:
                    <span class="font-bold">
                        ${{ number_format($rendicionCliente, 2, ',', '.') }}
                    </span>
                </p>
                <p>$ Rendición Honorarios:
                    <span class="font-bold">
                        ${{ number_format($rendicionHonorarios, 2, ',', '.') }}
                    </span>
                </p>
                <p>$ Restante a Rendir: 
                    <span class="font-bold">
                        ${{ number_format($saldoRestanteARendir, 2, ',', '.') }}
                    </span>
                </p>
                @if(($pago->monto_acordado - $pagosAplicadosSinRendirSuma) > 0)
                    <p class="bg-orange-500 font-bold text-white p-1 text-center mt-2">
                        Cuota c/ Pago Aplicado Parcial
                    </p>
                @elseif(($pago->monto_acordado - $pagosAplicadosSinRendirSuma) == 0)
                    <p class="bg-cyan-600 font-bold text-white p-1 text-center mt-2">
                        Cuota c/ Pago Aplicado Total
                    </p>  
                @elseif($pago->estado == 3)
                    <p class="bg-green-600 text-white p-1 text-center mt-2">Situación:
                        <span class="font-bold">
                            Pago Finalizado
                        </span>
                    </p>
                @endif
            </div>
        </div>
        @if($pago->estado != 3)
            <!--Rendir un pago-->
            <div class="px-1 pt-1 border border-gray-700 lg:col-span-2">
                <x-subtitulo-h-cuatro>
                    Rendir un pago
                </x-subtitulo-h-cuatro>
                <div class="p-1">
                    <!--formulario-->
                    <form wire:submit.prevent='rendirPago' class="p-1 overflow-y-auto" style="max-height: 210px">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 my-1">
                            <!-- Gestion ID -->
                            <div>
                                <x-input-label for="gestion_id" :value="__('Pago a Rendir')" />
                                <x-text-input
                                    id="gestion_id"
                                    placeholder="Id del Pago Aplicado"
                                    class="block mt-1 w-full"
                                    type="number"
                                    wire:model="gestion_id"
                                    :value="old('gestion_id')"
                                    />
                                <x-input-error :messages="$errors->get('gestion_id')" class="mt-2" />
                            </div>
                            <!-- Monto a Rendir -->
                            <div>
                                <x-input-label for="monto_a_rendir" :value="__('Monto a Rendir')" />
                                <x-text-input
                                    id="monto_a_rendir"
                                    placeholder="Monto a Rendir"
                                    class="block mt-1 w-full"
                                    type="text"
                                    wire:model="monto_a_rendir"
                                    :value="old('monto_a_rendir')"
                                    />
                                <x-input-error :messages="$errors->get('monto_a_rendir')" class="mt-2" />
                            </div>
                            <!-- Rendicion CG -->
                            <div>
                                <x-input-label for="proforma" :value="__('Rendicion CG')" />
                                <x-text-input
                                    id="proforma"
                                    placeholder="Proforma Y rendición CG"
                                    class="block mt-1 w-full"
                                    type="text"
                                    wire:model="proforma"
                                    :value="old('proforma')"
                                    />
                                <x-input-error :messages="$errors->get('proforma')" class="mt-2" />
                            </div>
                            <!-- Fecha de Rendicion -->
                            <div>
                                <x-input-label for="fecha_rendicion" :value="__('Fecha de Rendición')" />
                                <x-text-input
                                    id="fecha_rendicion"
                                    class="block mt-1 w-full"
                                    type="date"
                                    wire:model="fecha_rendicion"
                                    :value="old('fecha_rendicion')"
                                    :max="now()->format('Y-m-d')"
                                    />
                                <x-input-error :messages="$errors->get('fecha_rendicion')" class="mt-2" />
                            </div>
                        </div>
                        <!--submit-->
                        <x-text-input
                            class="{{$classesBtn}} w-full lg:mt-1 bg-green-600 hover:bg-green-700 cursor-pointer"
                            type="submit"
                            value="Rendir"
                        />
                    </form>
                </div>
            </div>
        @else
            <div class="px-1 pt-1 lg:col-span-2">
                <p class="text-center bg-cyan-600 text-white py-2">
                    No se puede realizar rendiciones porque el pago está finalizado.
                </p>
            </div>
        @endif
    </div>
    @else
        <p class="font-bold text-center pt-2">
            La cuota no registra pagos aplicados para rendir.
        </p>
    @endif
    <!--Modal finalizar pago-->
    @if($modalFinalizarPago)
        <x-modal-estado>
            <div>
                <!--Contenedor Parrafos-->
                <p class="px-1">
                    Confirmar finalizar el Pago de
                    <span class="font-bold">
                        Cuota: {{$pago->nro_cuota}}
                    </span>
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="confirmarFinalizarPago">
                    Confirmar
                </button>
                <button class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalFinalizarPago">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
</div>
