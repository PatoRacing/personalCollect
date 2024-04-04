<div>
    <form class="container p-2 border rounded" wire:submit.prevent='operacionIncobrable'> 
        <h2 class="text-center rounded  bg-white font-bold text-gray-600 border-y-2 p-2 ">Propuesta Incobrable</h2>
        <div class="bg-white grid  px-4 py-2">
            <!-- Accion -->
            <div>
                <x-input-label for="accion" :value="__('Accion realizada')" />
                <select
                    id="accion"
                    class="block mt-1 w-full rounded-md border-gray-300"
                    wire:model="accion"
                >
                    <option selected value=""> - Seleccionar -</option>
                    <option>Llamada Entrante TP (Fijo)</option>
                    <option>Llamada Saliente TP (Fijo)</option>
                    <option>Llamada Entrante TP (Celular)</option>
                    <option>Llamada Saliente TP (Celular)</option>
                    <option>Llamada Entrante WP (Celular)</option>
                    <option>Llamada Saliente WP (Celular)</option>
                    <option>Chat WP (Celular)</option>
                    <option>Mensaje SMS (Celular)</option>
                </select>
                <x-input-error :messages="$errors->get('accion')" class="mt-2" />
            </div>

            <!-- Observacion -->
            <div class="mt-2">
                <x-input-label for="observaciones" :value="__('Observaciones')" />
                <textarea
                    wire:model="observaciones"
                    id="observaciones"
                    class="block mt-1 w-full"
                    type="text"
                    placeholder="Describe brevemente la acción"
                    ></textarea>
                <div class="mt-2 text-sm text-gray-500">
                    Caracteres restantes: {{ 255 - strlen($observaciones) }}
                </div>
                <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
            </div>
        </div>

        <x-primary-button class="mt-4 pt-3 pb-3 w-full justify-center bg-blue-800 hover:bg-blue-900">
            {{ __('Guardar') }}
        </x-primary-button>
    </form>
</div>
