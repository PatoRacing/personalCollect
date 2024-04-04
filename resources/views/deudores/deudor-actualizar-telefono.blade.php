@section('titulo')
    Actualizar teléfono
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">{{ucwords(strtolower($deudorNombre))}} (actualizar contacto) </h1>
                <a href="{{ route('deudor.perfil', ['deudor' => $deudor_id]) }}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                @if(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-3 p-3 ">
                        {{ session('message') }}
                    </div>
                @endif 
                              
            </div>
        </div>
    </div>
</x-app-layout>