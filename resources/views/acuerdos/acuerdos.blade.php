@section('titulo')
    Acuerdos de Pago
@endsection

<x-app-layout>
    <!-- clases-->
    @php
        $classesSpan = "font-bold text-black";
        $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-2 text-center py-2";
        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
        $classesTipo = "text-center bg-blue-800 text-white py-2 font-bold rounded my-4 uppercase";
        $classesButtonTrue = "text-white rounded-md text-sm bg-blue-400 border-2 text-center p-3";
        $classesButtonFalse = "text-white rounded-md bg-blue-300 text-sm border-2 text-center py-3 px-6";
    @endphp
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="px-4 py-2 sticky left-0 mb-1">
                <h1 class="font-bold uppercase bg-gray-200 p-4 text-gray-900 hover:text-gray-500 text-center mb-4 flex items-center justify-center space-x-8">
                    Acuerdos de Pago
                </h1>
                @if(session('message'))
                    <div class="bg-white rounded p-4 mt-8 mb-5">
                        <h1 class="font-extrabold text-2xl text-black">Importación realizada con éxito:</h1>
                        <p class="font-bold text-gray-600 mb-2">Detalle de acciones generadas:</p>
                        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold p-2">
                            {!! nl2br(session('message')) !!}
                        </div>
                    </div>
                @endif     
                <a href="{{route('importar.acuerdos')}}" class="{{$classesButtonTrue}} bg-blue-800 mt-10">
                            + Importar
                </a>
                <livewire:listado-acuerdos />      
            </div>
        </div>
    </div>
</x-app-layout>