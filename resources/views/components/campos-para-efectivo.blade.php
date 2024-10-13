<!-- Efectivo -->
<div>
    <x-input-label for="central_de_pago" :value="__('Central de pago:')" />
    <select
        id="central_de_pago"
        class="block mt-1 w-full rounded-md border-gray-300"
        wire:model="central_de_pago"
        >
        <option value="">Seleccionar</option>
        <option value="RapiPago">RapiPago</option>
        <option value="Pago Facil">Pago Fácil</option>
    </select>
    <x-input-error :messages="$errors->get('central_de_pago')" class="mt-2" />
</div>