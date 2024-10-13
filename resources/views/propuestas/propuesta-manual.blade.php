@section('titulo')
    Propuesta Manual
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Nueva Propuesta Manual 
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('propuestas')" class="mr-1">
            Volver
        </x-btn-principal>
        
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Ingresá los valores para generar una nueva propuesta
            </x-subtitulo>
            formulario
        </div>
    </div>
</x-app-layout>