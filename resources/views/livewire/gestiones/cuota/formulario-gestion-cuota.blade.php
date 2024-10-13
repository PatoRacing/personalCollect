<form wire:submit.prevent='nuevaGestionIngresada' class="p-3">
    @if($pasoUno)
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
        <button type="button" class="{{$classesBtn}} w-full mt-2 bg-green-600 hover:bg-green-700" wire:click.prevent="aplicarPasoDos">
            Siguiente
        </button>
    @endif
    @if($medioDePagoDeposito)
        <x-campos-para-deposito :sucursal="$sucursal" :hora="$hora" :cuenta="$cuenta"/>
    @elseif($medioDePagoTransferencia)
        <x-campos-para-transferencia :nombre_tercero="$nombre_tercero" :cuenta="$cuenta"/>
    @elseif($medioDePagoEfectivo)
        <x-campos-para-efectivo :central_de_pago="$central_de_pago"/>
    @endif
    @if($medioDePagoDeposito || $medioDePagoTransferencia || $medioDePagoEfectivo)
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
        <div class="grid grid-cols-2 gap-2 mt-2">
            <button type="button" class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="volverPasoUno">
                Anterior
            </button>
            <button type="submit" class="{{$classesBtn}} bg-green-600 hover:bg-green-700">
                Guardar
            </button>
        </div>
    @endif
    @if($alertaDeMonto)
        <!--Modal cambiar confirmar monto superior-->
        <x-modal-estado>
            <div class="max-w-1/2 mx-auto text-sm">
                <!--Contenedor Parrafos-->
                <p class="px-1 text-center">
                    {{$this->calculoDeMonto}}
                </p>
                <p class="px-1 text-center">
                    Confirmás este importe?
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="condiciones">
                    Confirmar
                </button>
                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarAlertaDeMonto">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
</form>
