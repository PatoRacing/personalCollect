@section('titulo')
    Nueva Operación
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Nueva Operación Manual</h1>
                <a href="{{route('clientes')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-600 text-red-800 font-bold mt-5 p-3">
                        {!! nl2br($errors->first()) !!}
                    </div>
                @elseif(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-3 p-3">
                        {!! nl2br(session('message')) !!}
                    </div>
                @endif

            </div>
            <livewire:generar-operacion :clientes="$clientes" />
        </div>
    </div>
</x-app-layout>