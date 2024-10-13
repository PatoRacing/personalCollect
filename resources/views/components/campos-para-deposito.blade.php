<!-- Sucursal -->
<div>
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