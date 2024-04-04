<div>
    <button
        class="bg-indigo-600 text-white w-28 h-10 rounded block mt-2"
        wire:click="modalActualizarTelefono"
    > Actualizar 
    </button>
    @if($mostrarModal)
        <form 
            class="container p-4 mt-3 border text-sm bg-white"
            wire:submit.prevent='actualizarTelefono'
            >
            <h2 class="text-center bg-gray-200 py-2 mb-4 font-bold uppercase">Actualizar teléfono</h2>
                
            <!-- Tipo -->
            <div class="mt-3">
                <x-input-label for="tipo" :value="__('Tipo de Contacto:')" />
                <select
                    id="tipo"
                    class="block mt-1 w-full rounded-md border-gray-300"
                    wire:model="tipo"
                >
                    <option value="">Seleccionar</option>
                    <option value="Celular">Celular</option>
                    <option value="Tel. Fijo">Tel. Fijo</option>
                    <option value="WhastApp">WhastApp</option>
                    <option value="Email">Email</option>
                </select>
                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
            </div>

            <!-- Contacto -->
            <div class="mt-3">
                <x-input-label for="contacto" :value="__('Contacto:')" />
                <select
                    id="contacto"
                    class="block mt-1 w-full rounded-md border-gray-300"
                    wire:model="contacto"
                >
                    <option value="">Seleccionar</option>
                    <option value="Titular">Titular</option>
                    <option value="Referencia">Referencia</option>
                    <option value="Laboral">Laboral</option>
                    <option value="Familiar">Familiar</option>
                </select>
                <x-input-error :messages="$errors->get('contacto')" class="mt-2" />
            </div>

            <!-- Número -->
            <div class="mt-3">
                <x-input-label for="numero" :value="__('Número:')" />
                <x-text-input
                    id="numero"
                    placeholder="Indicar número y prefijo"
                    class="block mt-1 w-full"
                    type="text"
                    wire:model="numero"
                    :value="old('numero')"
                    />
                <x-input-error :messages="$errors->get('numero')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-3">
                <x-input-label for="email" :value="__('Email:')" />
                <x-text-input
                    id="email"
                    placeholder="Indicar email"
                    class="block mt-1 w-full"
                    type="text"
                    wire:model="email"
                    :value="old('email')"
                    />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Estado -->
            <div class="mt-3">
                <x-input-label for="estado" :value="__('Estado:')" />
                <select
                    id="estado"
                    class="block mt-1 w-full rounded-md border-gray-300"
                    wire:model="estado"
                >
                    <option selected value="">-- Seleccionar --</option>
                    <option value="1">Verificado</option>
                    <option value="2">No Verificado</option>
                </select>
                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
            </div>

            <div class="flex gap-2 mt-4">
                <button class="p-2 w-full justify-center bg-green-700 hover:bg-green-800 text-white"
                    type="submit">
                        Guardar
                </button>
                <button class="p-2 w-full justify-center bg-red-600 hover:bg-red-800 text-white"
                    wire:click="cerrarModal">
                        Cancelar
                </button>
            </div>
        </form>
    @endif
</div>

