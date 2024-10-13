@section('titulo')
    Nueva Gestión
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Nueva Gestión - Operación {{$operacion->operacion}}
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('deudor.perfil', ['deudor'=>$operacion->deudor_id])" class="mr-1">
            Volver
        </x-btn-principal>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mt-3">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                <livewire:detalle-operacion :operacion="$operacion" />
                <livewire:telefonos-operacion :operacion="$operacion" />
            </div>
            <div>
                @if(session('message'))
                    <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold my-3">
                        {{ session('message') }}
                    </div>
                @endif
                <livewire:historial-gestiones :operacion="$operacion" />
            </div>
        </div>
        <livewire:gestiones-operaciones-administradores :operacion="$operacion">
    </div>
</x-app-layout>