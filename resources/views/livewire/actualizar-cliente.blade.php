<div>
    <form 
        class="container p-2"
        wire:submit.prevent='editarCliente'
        >    
        @csrf
        <h2 class="text-center bg-white font-bold text-gray-600 border-y-2 p-4 mb-4">Completa todos los campos</h2>
        <div class="bg-white grid grid-cols-1 gap-4 md:grid-cols-2 px-4 py-4">

            <!-- Nombre -->
            <div class="mt-2">
                <x-input-label for="nombre" :value="__('Nombre del Cliente')" />
                <x-text-input
                    id="nombre"
                    placeholder="Nombre del Cliente"
                    class="block mt-1 w-full"
                    type="text"
                    wire:model="nombre"
                    :value="old('nombre')"
                    />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Contacto -->
            <div class="mt-2">
                <x-input-label for="contacto" :value="__('Contacto')" />
                <x-text-input
                    id="contacto"
                    placeholder="Nombre y apellido del Contacto"
                    class="block mt-1 w-full"
                    type="text"
                    wire:model="contacto"
                    :value="old('contacto')"
                    />
                <x-input-error :messages="$errors->get('contacto')" class="mt-2" />
            </div>

            <!-- Telefono -->
            <div class="mt-2">
                <x-input-label for="telefono" :value="__('Telefono')" />
                <x-text-input
                    id="telefono"
                    placeholder="Teléfono de contacto"
                    class="block mt-1 w-full"
                    type="text"
                    wire:model="telefono"
                    :value="old('telefono')"
                    />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-2">
                <x-input-label for="email" :value="__('Email de contacto')" />
                <x-text-input
                    id="email"
                    placeholder="Email de contacto"
                    class="block mt-1 w-full"
                    type="email"
                    wire:model="email"
                    :value="old('email')"
                    />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Domicilio -->
            <div class="mt-2">
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
            <div class="mt-2">
                <x-input-label for="localidad" :value="__('Localidad')" />
                <x-text-input
                    id="localidad"
                    placeholder="Localidad del Cliente"
                    class="block mt-1 w-full"
                    type="text"
                    wire:model="localidad"
                    :value="old('localidad')"
                    />
                <x-input-error :messages="$errors->get('localidad')" class="mt-2" />
            </div>

            <!-- Codigo Postal -->
            <div class="mt-2">
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

            <!-- Provincia -->
            <div class="mt-2">
                <x-input-label for="provincia" :value="__('Provincia')" />
                <x-text-input
                    id="provincia"
                    placeholder="Provincia"
                    class="block mt-1 w-full"
                    type="text"
                    wire:model="provincia"
                    :value="old('provincia')"
                    />
                <x-input-error :messages="$errors->get('provincia')" class="mt-2" />
            </div>    
        </div>
        <x-primary-button class="mt-4 pt-3 pb-3 w-full justify-center bg-blue-800 hover:bg-blue-900">
            {{ __('Actualizar cliente') }}
        </x-primary-button>
    
    </form>
</div>
