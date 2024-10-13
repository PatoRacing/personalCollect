@section('titulo')
    Actualizar Producto
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Actualizar Producto
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('perfil.producto', ['producto'=>$producto->id])">
            Volver
        </x-btn-principal>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Completar todos los campos
            </x-subtitulo>
            <livewire:actualizar-producto 
                :producto="$producto"
                :clientes="$clientes"
            /> 
        </div>
    </div>
</x-app-layout>