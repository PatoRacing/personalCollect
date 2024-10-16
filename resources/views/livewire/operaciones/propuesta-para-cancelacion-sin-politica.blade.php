<div class="mt-1 p-2 border border-gray-700">
    @if($formulario)
        <x-subtitulo-h-cuatro>
            Cancelación
        </x-subtitulo-h-cuatro>
        <form wire:submit.prevent='calcularQuita'>
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
            <div>
                <button class="w-full py-1 mt-2 text-white bg-green-600 hover:bg-green-700 rounded">
                    Calcular
                </button>
            </div>
        </form>
    @endif
    @if($negociacionPermitida)
        <x-subtitulo-h-cuatro>
            Detalle de la Propuesta:
        </x-subtitulo-h-cuatro>
        <p class="mt-2">Monto a Pagar:
            <span class="font-bold">
                ${{number_format($this->monto_ofrecido, 2, ',', '.')}}
            </span>
        </p>
        <p>Total ACP:
            <span class="font-bold">
                ${{number_format($this->total_acp, 2, ',', '.')}}
            </span>
        </p>
        <p>Porcentaje de Quita:
            @if($this->porcentaje_quita < 0)
                <span class="font-bold">
                    {{ number_format(0, 2, ',', '.') }}%
                </span>
            @else
                <span class="font-bold">
                    {{number_format($this->porcentaje_quita, 2, ',', '.')}}%
                </span>
            @endif
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
                <!--Fecha de Pago-->
                <div class="mt-2">
                    <x-input-label for="fecha_pago_cuota" :value="__('Fecha de Pago:')" />
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
                <!--Guardar-->
                <button class="w-full py-1 mt-2 text-white bg-green-600 hover:bg-green-700 rounded">
                    Guardar
                </button>
            </form>
        </div>        
    @endif
</div>
