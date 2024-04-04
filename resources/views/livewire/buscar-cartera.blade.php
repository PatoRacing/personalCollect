<div class=" bg-gray-200 pt-4">
    <form wire:submit.prevent="leerTerminoBusquedaCartera" class="flex justify-center gap-4">
        <div class="mb-5">
            <label 
                class="block mb-1 text-sm text-gray-700 uppercase font-bold"
                for="nro_doc">Nro. Documento:
            </label>
            <input 
                id="nro_doc"
                wire:model="nro_doc"
                type="text"
                placeholder="Buscar DNI"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>

        <div class="mb-5">
            <label 
                class="block mb-1 text-sm text-gray-700 uppercase font-bold "
                for="nro_operacion">Nro Operación:
            </label>
            <input 
                id="nro_operacion"
                wire:model="nro_operacion"
                type="text"
                placeholder="Buscar operación"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>

        <div class="mb-5">
            <label 
                class="block mb-1 text-sm text-gray-700 uppercase font-bold "
                for="deudor">Nombre:
            </label>
            <input 
                id="deudor"
                wire:model="deudor"
                type="text"
                placeholder="Buscar Deudor/a"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>
        
        <div class="flex py-6">
            <input 
                type="submit"
                class="bg-blue-800 hover:bg-blue-900 text-white text-sm font-bold px-16  rounded cursor-pointer uppercase"
                value="Buscar"
            />
        </div>
    </form>
</div>
