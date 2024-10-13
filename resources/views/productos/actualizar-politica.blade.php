@section('titulo')
    Actualizar Politica
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        {{$politica->productoId->nombre}}: Actualizar Política 
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('perfil.producto', ['producto'=>$politica->productoId->id])" class="mr-1">
            Volver
        </x-btn-principal>
        
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Ingresá los valores para actualizar la politica
            </x-subtitulo>
            <livewire:actualizar-politica
                :politica="$politica"
                :propiedadesOperacion="$propiedadesOperacion"
            />
        </div>
    </div>
</x-app-layout>