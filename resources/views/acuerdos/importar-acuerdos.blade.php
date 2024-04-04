@section('titulo')
    Importar Acuerdos
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Importar Acuerdos</h1>
                <a href="{{route('acuerdos')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-600 text-red-800 font-bold mt-5 p-3">
                        @foreach ($errors->all() as $error)
                            <p>{!! nl2br($error) !!}</p>
                        @endforeach
                    </div>
                @elseif(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-5 p-3">
                        {!! nl2br(session('message')) !!}
                    </div>
                @endif
            </div>

            <div id="spinner" class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50 bg-gray-900 bg-opacity-50 pointer-events-none opacity-0">
                <div class="flex flex-col items-center bg-gray-100 p-5 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-16 h-16 my-4 text-green-600 cursor-not-allowed">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                    <h1 class="font-extrabold text-2xl p-2 text-black text-center">Realizando importación</h1>
                    <p class="font-bold text-gray-600 text-center">Aguarde unos instantes hasta que finalice.</p>
                </div>
            </div>  

            <livewire:acuerdo />

            <form 
                class="container p-2"
                method="POST"
                action="{{route('almacenar.acuerdos')}}"
                enctype="multipart/form-data"
                id="formulario"
                >
                @csrf
                
                <h2 class="text-center bg-white font-bold text-gray-600 border-y-2 p-4 mb-4">Seleccioná el archivo excel a importar</h2>
                <div class="bg-white grid grid-cols-1 gap-4 md:grid-cols-2 px-4 py-4">

                    <!-- Usuario creador -->
                    <div class="mt-2">
                        <x-input-label for="usuario_ultima_modificacion_id" :value="__('Usuario')" />
                        <x-text-input
                            id="usuario_ultima_modificacion_id"
                            class="block mt-1 w-full bg-gray-200"
                            type="text"
                            value="{{ auth()->user()->name }} {{ auth()->user()->apellido }}"
                            name="usuario_ultima_modificacion_id"
                            readonly
                            />
                    </div>
                    
                    <!-- Archivo -->
                    <div class="mt-2">
                        <x-input-label for="importar" :value="__('Importar')" />
                        <x-text-input
                            id="importar"
                            placeholder="Seleccionar archivo"
                            class="block mt-1 w-full border p-1.5"
                            type="file"
                            name="importar"
                            accept=".xls, .xlsx"
                            />
                    </div> 
                </div>
                <x-primary-button class="mt-4 pt-3 pb-3 w-full justify-center bg-blue-800 hover:bg-blue-900">
                    {{ __('Importar') }}
                </x-primary-button>
            
            </form>
        </div>
    </div>
    @vite ('resources/js/spinner-importacion.js')
</x-app-layout>