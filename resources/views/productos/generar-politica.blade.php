@section('titulo')
    Generar Politica
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        {{$producto->nombre}}: Nueva Política 
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('perfil.producto', ['producto'=>$producto->id])" class="mr-1">
            Volver
        </x-btn-principal>
        
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Ingresá los valores para crear una nueva politica
            </x-subtitulo>
            <livewire:generar-politica
                :producto="$producto"
                :propiedadesOperacion="$propiedadesOperacion"
            />
        </div>
    </div>
</x-app-layout>