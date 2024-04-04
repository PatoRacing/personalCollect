@section('titulo')
    Listado de Pagos
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            @if(session('message'))
                <div class="bg-white rounded p-4 mt-8 mb-5">
                    <h1 class="font-extrabold text-2xl text-black">Importación realizada con éxito:</h1>
                    <p class="font-bold text-gray-600 mb-2">Detalle de acciones generadas:</p>
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold p-2">
                        {!! nl2br(session('message')) !!}
                    </div>
                </div>
            @endif
            @if(session('success.message'))
                <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold p-2">
                    {!! nl2br(session('success.message')) !!}
                </div>
            @endif
            @if(session('aplicado.message'))
                <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold p-2">
                    {!! nl2br(session('aplicado.message')) !!}
                </div>
            @endif
            <livewire:listado-pagos />
        </div>
    </div>
</x-app-layout>