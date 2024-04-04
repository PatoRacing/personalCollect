@section('titulo')
    Informar Pagos
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Informar Pagos</h1>
                <a href="{{route('pagos')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
            </div>
            <livewire:formulario-informar-pago :pagoId="$pagoId" />
        </div>
    </div>
</x-app-layout>