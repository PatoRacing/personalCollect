@section('titulo')
    Importar información de Deudores
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Importar Deudores
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('clientes')">
            Volver
        </x-btn-principal>
        <!--Modal advertencia-->
        <livewire:importar-deudor />
        <!--Modal Importando-->
        <x-importando />
        <!--Contenedor formulario-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Completar todos los campos
            </x-subtitulo>
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-600 text-red-800 font-bold mt-5 p-3">
                    {!! nl2br($errors->first()) !!}
                </div>
            @endif
            <form 
                class="container mx-auto text-sm mt-2"
                id="formulario"
                action="{{ route('almacenar.deudores')}}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 justify-center md:grid-cols-2 gap-2 p-1 ">
                    <!-- Usuario -->
                    <div>
                        <x-input-label for="usuario" :value="__('Usuario')" />
                        <x-text-input
                            id="usuario"
                            placeholder="Nombre del Usuario"
                            class="block mt-1 w-full  bg-gray-200"
                            type="text"
                            name="usuario"
                            :value="auth()->user()->name . ' ' . auth()->user()->apellido"
                            disabled
                            />
                    </div>
                    <!-- Archivo -->
                    <div>
                        <x-input-label for="archivo" :value="__('Archivo')" />
                        <x-text-input
                            id="importar"
                            placeholder="Seleccionar archivo excel"
                            class="block mt-1 w-full border p-1.5"
                            type="file"
                            name="importar"
                            accept=".xls, .xlsx"
                            />
                    </div>
                </div>
                <x-primary-button class="w-full py-2 px-4 mt-2 text-white bg-green-700 hover:bg-green-800">
                    {{ __('Importar Deudores') }}
                </x-primary-button>
            </form>
        </div>
    </div>
    @vite ('resources/js/spinner-importacion.js')
</x-app-layout>
