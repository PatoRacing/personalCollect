<form wire:submit.prevent="busquedaProducto"
        class="bg-gray-200 container mx-auto p-2 text-sm">
    <div class="grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-2 gap-2">
        <!--nombre-->
        <div>
            <label class="block mb-1 font-bold">Nombre:</label>
            <input 
                id="nombre"
                wire:model="nombre"
                type="text"
                placeholder="Nombre Producto"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>
        <!--cliente-->
        <div>
            <label class="block mb-1 font-bold">Cliente:</label>
            <select wire:model="cliente_id" class="border-gray-300 w-full rounded-md shadow-sm">
                <option >Seleccione</option>
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-2">
        <input 
            type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded cursor-pointer w-full"
            value="Buscar"
        />
    </div>
</form>

