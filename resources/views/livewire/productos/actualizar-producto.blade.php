<form class="container mx-auto text-sm mt-2" wire:submit.prevent='actualizarProducto'>
    <div class="grid grid-cols-1 justify-center md:grid-cols-2 gap-2 p-1">
        <!-- Nombre -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre del Producto')" />
            <x-text-input
                id="nombre"
                placeholder="Nombre del Producto"
                class="block mt-1 w-full"
                type="text"
                wire:model="nombre"
                :value="old('nombre')"
                />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>
        <!-- Cliente -->
        <div>
            <x-input-label for="cliente_id" :value="__('Selecciona un cliente')" />
            <select
                id="cliente_id"
                class="block mt-1 w-full rounded-md border-gray-300"
                wire:model="cliente_id"
            >
                <option value="">Selecciona un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
        </div>
        <!-- Honorarios -->
        <div>
            <x-input-label for="honorarios" :value="__('Honorarios')" />
            <x-text-input
                id="honorarios"
                placeholder="Indicá el valor de los honorarios"
                class="block mt-1 w-full"
                type="text"
                wire:model="honorarios"
                :value="old('honorarios')"
                />
            <x-input-error :messages="$errors->get('honorarios')" class="mt-2" />
        </div>
        <!-- Comision Cliente -->
        <div>
            <x-input-label for="comision_cliente" :value="__('Comisión del Cliente')" />
            <x-text-input
                id="comision_cliente"
                placeholder="Indicá la comisión del cliente"
                class="block mt-1 w-full"
                type="text"
                wire:model="comision_cliente"
                :value="old('comision_cliente')"
                />
            <x-input-error :messages="$errors->get('comision_cliente')" class="mt-2" />
        </div>
        <!-- Cuotas Variables -->
        <div>
            <x-input-label for="acepta_cuotas_variables" :value="__('Acepta cuotas variables?')" />
            <select
                id="acepta_cuotas_variables"
                class="block mt-1 w-full rounded-md border-gray-300"
                wire:model="acepta_cuotas_variables"
            >
                <option value="">- Seleccionar -</option>
                <option value="1">Si</option>
                <option value="2">No</option>
            </select>
            <x-input-error :messages="$errors->get('acepta_cuotas_variables')" class="mt-2" />
        </div>
    </div>
    <x-primary-button class="w-full py-2 px-4 mt-2 text-white bg-green-700 hover:bg-green-800">
        {{ __('Actualizar Producto') }}
    </x-primary-button>
</form>
    
