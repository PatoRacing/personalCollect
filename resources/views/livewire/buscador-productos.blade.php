<div class=" bg-gray-200 pt-4">
    <form wire:submit.prevent="busquedaProducto" class="flex justify-center gap-4">
        <div class="mb-5">
            <label 
                class="block mb-1 text-sm text-gray-700 uppercase font-bold"
                for="nombre">Nombre:
            </label>
            <input 
                id="nombre"
                wire:model="nombre"
                type="text"
                placeholder="Nombre Producto"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>

        <div class="mb-5">
            <label class="block mb-1 text-sm text-gray-700 uppercase font-bold">Cliente:</label>
            <select wire:model="cliente_id" class="border-gray-300 pr-20 text-gray-600 w-full rounded-md shadow-sm">
                <option >Seleccione</option>
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                @endforeach
            </select>
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
