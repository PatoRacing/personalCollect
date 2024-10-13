@section('titulo')
    Productos
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Productos
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('crear.producto')" class="mr-1">
            + Producto
        </x-btn-principal>        
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Listado de Productos
            </x-subtitulo>
            <livewire:productos />
        </div>
    </div>
</x-app-layout>

