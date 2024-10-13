@section('titulo')
    Usuarios
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Usuarios
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('crear.usuario')">
            + Usuario
        </x-btn-principal>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Listado de Usuarios
            </x-subtitulo>
            <livewire:usuarios />
        </div>
    </div>
</x-app-layout>







