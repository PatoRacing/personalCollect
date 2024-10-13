<form wire:submit.prevent="terminosBusquedaCuotasVigentes"
        class="bg-gray-200 container mx-auto p-2 text-sm">
    <div class="grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-6 gap-2">
        <!--Nombre-->
        <div>
            <label 
                class="block mb-1 font-bold"
                for="deudor">Nombre:
            </label>
            <input 
                id="deudor"
                wire:model="deudor"
                type="text"
                placeholder="Buscar Deudor/a"
                class="text-sm rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>
        <!--Nro doc-->
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
                class="text-sm rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>
        <!--Tipo-->
        <div>
            <label class="block mb-1 font-bold"" for="tipo_acuerdo">Tipo Acuerdo:</label>
            <select id="tipo_acuerdo" wire:model="tipo_acuerdo" class="text-sm border-gray-300 pr-20 text-gray-600 w-full rounded-md shadow-sm">
                <option>Seleccione</option>
                <option value="1">Cancelación</option>
                <option value="2">Cuotas Fijas</option>
                <option value="4">Cuotas Variables</option>
            </select>
        </div>
        <!--agente-->
        <div>
            <label class="block mb-1 font-bold">Responsable:</label>
            <select wire:model="responsable" class="text-sm border-gray-300 pr-20 text-gray-600 w-full rounded-md shadow-sm">
                <option >Seleccione</option>
                @foreach ($responsables as $responsable)
                    @if($responsable->id != 100)
                        <option value="{{$responsable->id}}">{{$responsable->name}} {{$responsable->apellido}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <!--nro operacion-->
        <div>
            <label 
                class="block mb-1 font-bold"
                for="nro_operacion">Nro Operación:
            </label>
            <input 
                id="nro_operacion"
                wire:model="nro_operacion"
                type="text"
                placeholder="Buscar operación"
                class="text-sm rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
            />
        </div>
        <!--Mes-->
        <div>
            <label class="block mb-1 font-bold"" for="mes">Vencimiento:</label>
            <select id="mes" wire:model="mes" class="text-sm border-gray-300 pr-20 text-gray-600 w-full rounded-md shadow-sm">
                <option>Seleccione</option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
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
