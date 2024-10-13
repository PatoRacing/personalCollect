<form class="container mx-auto text-sm mt-2" wire:submit.prevent='actualizarPerfilDeudor'>
    <div class="grid grid-cols-1 justify-center md:grid-cols-2 gap-2 p-1">
        <!-- Nombre -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre del Deudor')" />
            <x-text-input
                id="nombre"
                placeholder="Nombre del Deudor"
                class="block mt-1 w-full"
                type="text"
                wire:model="nombre"
                :value="old('nombre')"
                />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>
        <!-- Tipo doc -->
        <div>
            <x-input-label for="tipo_doc" :value="__('Tipo Documento:')" />
            <x-text-input
                id="tipo_doc"
                placeholder="Tipo Doc"
                class="block mt-1 w-full"
                type="text"
                wire:model="tipo_doc"
                :value="old('tipo_doc')"
                />
            <x-input-error :messages="$errors->get('tipo_doc')" class="mt-2" />
        </div>
        <!-- Nro doc -->
        <div>
            <x-input-label for="nro_doc" :value="__('Nro. Documento:')" />
            <x-text-input
                id="nro_doc"
                placeholder="Nro. Documento"
                class="block mt-1 w-full"
                type="text"
                wire:model="nro_doc"
                :value="old('nro_doc')"
                />
            <x-input-error :messages="$errors->get('nro_doc')" class="mt-2" />
        </div>
        <!-- Cuil -->
        <div>
            <x-input-label for="cuil" :value="__('CUIL del Deudor')" />
            <x-text-input
                id="cuil"
                placeholder="CUIL del Deudor"
                class="block mt-1 w-full"
                type="text"
                wire:model="cuil"
                :value="old('cuil')"
                />
            <x-input-error :messages="$errors->get('cuil')" class="mt-2" />
        </div>
        <!-- Domicilio -->
        <div>
            <x-input-label for="domicilio" :value="__('Domicilio')" />
            <x-text-input
                id="domicilio"
                placeholder="Calle y número"
                class="block mt-1 w-full"
                type="text"
                wire:model="domicilio"
                />
            <x-input-error :messages="$errors->get('domicilio')" class="mt-2" />
        </div>
        <!-- Localidad -->
        <div>
            <x-input-label for="localidad" :value="__('Localidad')" />
            <x-text-input
                id="localidad"
                placeholder="Localidad"
                class="block mt-1 w-full"
                type="text"
                wire:model="localidad"
                :value="old('localidad')"
                />
            <x-input-error :messages="$errors->get('localidad')" class="mt-2" />
        </div>
        <!-- Codigo Postal -->
        <div>
            <x-input-label for="codigo_postal" :value="__('Código Postal')" />
            <x-text-input
                id="codigo_postal"
                placeholder="Código Postal"
                class="block mt-1 w-full"
                type="text"
                wire:model="codigo_postal"
                :value="old('codigo_postal')"
                />
            <x-input-error :messages="$errors->get('codigo_postal')" class="mt-2" />
        </div>
    </div>
    <x-primary-button class="w-full py-2 px-4 mt-2 text-white bg-green-700 hover:bg-green-800">
        {{ __('Actualizar Deudor') }}
    </x-primary-button>

</form>
