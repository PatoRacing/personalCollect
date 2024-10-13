@section('titulo')
    Crear Cliente
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Crear Cliente
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('clientes')">
            Volver
        </x-btn-principal>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Completar todos los campos
            </x-subtitulo>
            <livewire:crear-cliente />
        </div>
    </div>
</x-app-layout>