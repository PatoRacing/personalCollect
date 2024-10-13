@section('titulo')
    Actualizar Deudor
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Actualizar perfil: {{$deudor->nombre}}
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('deudor.perfil', ['deudor' => $deudor->id])">
            Volver
        </x-btn-principal>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Completar todos los campos
            </x-subtitulo>
            <livewire:actualizar-perfil-deudor :deudor="$deudor"/>
        </div>
    </div>
</x-app-layout>