<div>
    <!--Classes-->
    @php
    $classesSpan = "font-bold text-black";
    $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded uppercase";
    @endphp
    <h2 class="text-center rounded  bg-blue-400 font-bold text-white border-y-2 py-2 uppercase">Ctas. con Descuento</h2>
    @if($formulario)
        <form class="container p-2 rounded text-left ml-1" wire:submit.prevent='calcularCuotasConDescuento'>

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

            <!--Botones-->
            <div>
                <button class="p-2 mt-2 w-full justify-center bg-blue-800 hover:bg-blue-950 text-white" type="submit">
                    Calcular
                </button>
            </div>
        </form>
    @endif
    @if($negociacionPermitida)
        <h3 class="{{$classesTitulo}}">Detalle de la Propuesta:</h3>
        <p class="mt-2">Monto a Pagar:
            <span class="{{$classesSpan}}">
                ${{number_format($this->monto_ofrecido, 2, ',', '.')}}
            </span>
        </p>
        <p>Total ACP:
            <span class="{{$classesSpan}}">
                ${{number_format($this->total_acp, 2, ',', '.')}}
            </span>
        </p>
        <p>Porcentaje de Quita:
            @if($this->porcentaje_quita < 0)
                <span class="{{$classesSpan}}">
                    {{ number_format(0, 2, ',', '.') }}%
                </span>
            @else
                <span class="{{$classesSpan}}">
                    {{number_format($this->porcentaje_quita, 2, ',', '.')}}%
                </span>
            @endif
        </p>
        <p>Cantidad de cuotas:
            <span class="{{$classesSpan}}">
                {{$this->cantidad_de_cuotas_uno}} cuotas
            </span>
        </p>
        <p>Monto de la cuotas:
            <span class="{{$classesSpan}}">
                ${{number_format($this->monto_de_cuotas_uno, 2, ',', '.')}}
            </span>
        </p>
        <div class="flex gap-1 justify-center mt-2">
            <button class="bg-green-700 p-2 text-white rounded hover:bg-green-800 w-full" wire:click="propuesta">
                Propuesta
            </button>
            <button class="bg-red-600 p-2 text-white rounded hover:bg-red-700 w-full" wire:click="cancelarPropuesta">
                Recalcular
            </button>
        </div>
    @endif
    @if($propuesta)
        <form class="container p-2 rounded text-left ml-1" wire:submit.prevent='guardarPropuesta'>
            <h2 class="{{$classesTitulo}}">Confirmar Propuesta</h2>

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

            <!--Botones-->
            <div class="flex gap-2 justify-center mt-2">
                <button class="bg-green-700 p-2 text-white rounded hover:bg-green-800 w-full" type="submit">
                    Guardar
                </button>
            </div>
        </form>
    @endif
</div>
