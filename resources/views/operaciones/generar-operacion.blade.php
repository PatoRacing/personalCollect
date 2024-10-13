@section('titulo')
    Nueva Operación
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Nueva Operación Manual 
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('operaciones')" class="mr-1">
            Volver
        </x-btn-principal>
        
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Ingresa los valores para Deudor, Contacto y Operación
            </x-subtitulo>
            <livewire:generar-operacion :clientes="$clientes"/>
        </div>
    </div>
</x-app-layout>