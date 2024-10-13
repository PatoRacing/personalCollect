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