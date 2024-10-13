@section('titulo')
    Clientes
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Clientes
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('crear.cliente')" class="mr-1">
            + Cliente
        </x-btn-principal>
        <x-btn-principal :href="route('importar.deudores')" class="bg-orange-400 hover:bg-orange-500 mr-1">
            + Deudores
        </x-btn-principal>
        <x-btn-principal :href="route('importar.informacion')" class="bg-green-600 hover:bg-green-700">
            + Información
        </x-btn-principal>
        
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Listado de Clientes
            </x-subtitulo>
            <livewire:clientes />
        </div>
    </div>
</x-app-layout>