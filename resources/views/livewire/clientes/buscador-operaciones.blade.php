<form wire:submit.prevent="leerTerminoBusqueda"
        class="bg-gray-200 container mx-auto p-2 text-sm">
    <div class="grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-4 gap-2">
        <!--nro documento-->
        <div>
            <label 
                class="block mb-1 font-bold"
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
        <!--nro operacion-->
        <div>
            <label 
                class="block mb-1 font-bold "
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
        <!--nombre-->
        <div>
            <label 
                class="block mb-1 font-bold "
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
        <!--situacion-->
        <div>
            <label class="block mb-1 font-bold">Situación:</label>
            <select wire:model="situacion" class="border-gray-300 pr-20 text-gray-600 w-full rounded-md shadow-sm">
                <option >Seleccione</option>
                <option value="1">Asignadas</option>
                <option value="100">Sin asignar</option>
            </select>
        </div>
    </div>
    <div class="mt-2 grid grid-cols-2 md:grid-cols-6 justify-center gap-2">
        <input 
            type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded cursor-pointer w-full md:col-span-5"
            value="Buscar"
        />
        <button class="text-white py-2 rounded text-sm bg-red-600 hover:bg-red-700 md:col-span-1"
                wire:click="recargarBusqueda">
            Recargar
        </button>  
    </div>
</form>
