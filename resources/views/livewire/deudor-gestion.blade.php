<div>
    <form 
        class="container text-sm border p-4"
        wire:submit.prevent='deudorGestion'
        >
        <h2 class="text-center bg-gray-200 py-2 mb-4 font-bold uppercase">Deudor Nueva gestión</h2>

        <!-- Accion -->
        <div class="mt-2">
            <x-input-label for="accion" :value="__('Acción realizada')" />
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

        <!-- Resultado -->
        <div class="mt-2">
            <x-input-label for="resultado" :value="__('Resultado obtenido')" />
            <select
                id="resultado"
                class="block mt-1 w-full rounded-md border-gray-300"
                wire:model="resultado"
            >
                <option selected value=""> - Seleccionar - </option>
                <option>En proceso</option>
                <option>Fallecido</option>
                <option>Inubicable</option>
                <option>Ubicado</option>
            </select>
            <x-input-error :messages="$errors->get('resultado')" class="mt-2" />
        </div>

        <!-- Observacion -->
        <div class="mt-2">
            <x-input-label for="observaciones" :value="__('Observaciones')" />
            <x-text-input
                id="observaciones"
                placeholder="Describe brevemente la acción"
                class="block mt-1 w-full"
                type="text"
                wire:model="observaciones"
                :value="old('observaciones')"
                />
            <div class="mt-2 text-sm text-gray-500">
                Caracteres restantes: {{ 255 - strlen($observaciones) }}
            </div>
            <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
        </div>
        
        <x-primary-button class="mt-4 pt-3 pb-3 w-full justify-center bg-blue-800 hover:bg-blue-900">
            {{ __('Nueva gestión') }}
        </x-primary-button>
    
    </form>
</div>