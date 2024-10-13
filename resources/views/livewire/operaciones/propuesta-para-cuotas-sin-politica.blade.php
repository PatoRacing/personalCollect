<div class="mt-1 p-2 border border-gray-700">
    @if($formulario)
        <x-subtitulo-h-cuatro>
            Ctas. Fijas c/s Anticipo
        </x-subtitulo-h-cuatro>
        <form wire:submit.prevent='calcularCuotas'>
            <!--Monto negociado -->
            <div>
                <x-input-label for="monto_ofrecido" :value="__('Monto ofrecido a pagar:')" />
                <x-text-input
                    id="monto_ofrecido"
                    placeholder="$ ofrecido a pagar"
                    class="block mt-1 w-full text-sm"
                    type="text"
                    wire:model="monto_ofrecido"
                    :value="old('monto_ofrecido')"
                    />
                <x-input-error :messages="$errors->get('monto_ofrecido')" class="mt-2" />
            </div>
            <!--Anticipo -->
            <div class="mt-2">
                <x-input-label for="anticipo" :value="__('$ anticipo:')" />
                <x-text-input
                    id="anticipo"
                    placeholder="Si no se ofrece = 0"
                    class="block mt-1 w-full text-sm"
                    type="text"
                    wire:model="anticipo"
                    :value="old('anticipo')"
                    />
                <x-input-error :messages="$errors->get('anticipo')" class="mt-2" />
            </div>
            <!--Cant Cuotas -->
            <div class="mt-2">
                <x-input-label for="cantidad_de_cuotas_uno" :value="__('Cant. Ctas:')" />
                <x-text-input
                    id="cantidad_de_cuotas_uno"
                    placeholder="Cant. Ofrecida de ctas."
                    class="block mt-1 w-full text-sm"
                    type="text"
                    wire:model="cantidad_de_cuotas_uno"
                    :value="old('cantidad_de_cuotas_uno')"
                    />
                <x-input-error :messages="$errors->get('cantidad_de_cuotas_uno')" class="mt-2" />
            </div>
            <!--Boton-->
            <div>
                <button class="w-full py-1 mt-2 text-white bg-green-600 hover:bg-green-700 rounded">
                    Calcular
                </button>
            </div>
        </form>
    @endif
    @if($montoNoPermitido)
        <x-subtitulo-h-cuatro>
            No se cumplen cumple con las políticas
        </x-subtitulo-h-cuatro>
        <p class="mt-2">El monto mínimo a Pagar es
            <span class="font-bold">
                ${{number_format($this->minimoAPagar, 2, ',', '.')}}
            </span>
        </p>
        <button class="bg-red-600 mt-2 w-full text-white rounded hover:bg-red-700 py-1" wire:click="cancelarPropuesta">
            Recalcular
        </button>
    @endif
    @if($negociacionPermitida)
        <x-subtitulo-h-cuatro>
            Detalle de la Propuesta:
        </x-subtitulo-h-cuatro>
        <p class="mt-2">Monto Total:
            <span class="font-bold">
                ${{number_format($this->monto_total, 2, ',', '.')}}
            </span>
        </p>
        @if($this->anticipo > 0)
            <p>Anticipo:
                <span class="font-bold">
                    ${{number_format($this->anticipo, 2, ',', '.')}}
                </span>
            </p>
        @endif
        <p>Cantidad de cuotas:
            <span class="font-bold">
                {{$this->cantidad_de_cuotas_uno}} cuotas
            </span>
        </p>
        <p>Monto de la cuotas:
            <span class="font-bold">
                ${{number_format($this->monto_de_cuotas_uno, 2, ',', '.')}}
            </span>
        </p>
        <div class="grid grid-cols-2 gap-1 mt-2">
            <button class="py-1 text-white rounded bg-green-600 hover:bg-green-700 w-full" wire:click="propuesta">
                Propuesta
            </button>
            <button class="py-1 text-white rounded bg-red-600 hover:bg-red-700 w-full" wire:click="cancelarPropuesta">
                Recalcular
            </button>
        </div>
    @endif
    @if($propuesta)
        <div class="mt-2">
            <x-subtitulo-h-cuatro>
                Confirmar Propuesta
            </x-subtitulo-h-cuatro>
        </div>
        <form wire:submit.prevent='guardarPropuesta'>
            <!--Accion realizada-->
            <div class="mt-2">
                <x-input-label for="accion" :value="__('Acción realizada')" />
                <select
                        id="accion"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="accion"
                    >
                        <option value="">Seleccionar</option>
                        <option value="Llamada Entrante TP (Fijo)">Llamada Entrante TP (Fijo)</option>
                        <option value="Llamada Saliente TP (Fijo)">Llamada Saliente TP (Fijo)</option>
                        <option value="Llamada Entrante TP (Celular)">Llamada Entrante TP (Celular)</option>
                        <option value="Llamada Saliente TP (Celular)">Llamada Saliente TP (Celular)</option>
                        <option value="Llamada Entrante WP (Celular)">Llamada Entrante WP (Celular)</option>
                        <option value="Llamada Saliente WP (Celular)">Llamada Saliente WP (Celular)</option>
                        <option value="Chat WP (Celular)">Chat WP (Celular)</option>
                        <option value="Mensaje SMS (Celular)">Mensaje SMS (Celular)</option>   
                </select>
                <x-input-error :messages="$errors->get('accion')" class="mt-2" />
            </div>
            <!--Fecha de Pago Anticipo-->
            @if($this->anticipo != 0)
                <div class="mt-2">
                    <x-input-label for="fecha_pago_anticipo" :value="__('Fecha de Pago Anticipo:')" />
                        <x-text-input
                            id="fecha_pago_anticipo"
                            class="block mt-1 w-full text-sm"
                            type="date"
                            wire:model="fecha_pago_anticipo"
                            :value="old('fecha_pago_anticipo')"
                            min="{{ now()->toDateString() }}"
                            />
                    <x-input-error :messages="$errors->get('fecha_pago_anticipo')" class="mt-2" />
                </div>
            @endif
            <!--Fecha de Pago-->
            <div class="mt-2">
                <x-input-label for="fecha_pago_cuota" :value="__('Fecha de Pago Cuota:')" />
                    <x-text-input
                        id="fecha_pago_cuota"
                        class="block mt-1 w-full text-sm"
                        type="date"
                        wire:model="fecha_pago_cuota"
                        :value="old('fecha_pago_cuota')"
                        min="{{ now()->toDateString() }}"
                        />
                <x-input-error :messages="$errors->get('fecha_pago_cuota')" class="mt-2" />
            </div>
            <!-- Listado de usuario -->
            <div class="mt-2">
                <x-input-label for="usuario_ultima_modificacion_id" :value="__('Agente asignado')" />
                <select
                    id="usuario_ultima_modificacion_id"
                    class="block mt-1 w-full rounded-md border-gray-300"
                    wire:model="usuario_ultima_modificacion_id">
                    <option value="">Seleccionar</option>
                    @foreach ($usuarios as $usuario)
                        @if ($usuario->id !== 100)
                            <option value="{{$usuario->id}}">{{$usuario->name}} {{$usuario->apellido}}</option>
                        @endif
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('usuario_ultima_modificacion_id')" class="mt-2" />
            </div>

            <!-- Observacion -->
            <div class="mt-2">
                <x-input-label for="observaciones" :value="__('Observaciones')" />
                <textarea
                    wire:model="observaciones"
                    id="observaciones"
                    class="block mt-1 w-full border-gray-300 rounded"
                    type="text"
                    placeholder="Describe brevemente la acción"
                    ></textarea>
                <div class="mt-2 text-sm text-gray-600">
                    Caracteres restantes: {{ 255 - strlen($observaciones) }}
                </div>
                <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
            </div>

            <!--guardar-->
            <button class="w-full py-1 mt-2 text-white bg-green-600 hover:bg-green-700 rounded">
                Guardar
            </button>
        </form>
    @endif
</div>
