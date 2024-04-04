@section('titulo')
    Subir comprobante
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="px-4 py-2 sticky left-0 mb-1">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-4">Subir Comprobante</h1>
                <a href="{{ route('acuerdo', ['acuerdo' => $pago->acuerdo->id]) }}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                
                <!--Bajada-->
                <div class="px-14 py-4 lg:flex lg:items-center lg:justify-between text-sm
                        bg-white rounded border border-gray-200 border-1 text-gray-600 mt-4">
                    <p>Deudor: <span class="font-bold text-black">{{ ucwords(strtolower($pago->acuerdo->propuesta->operacionId->deudorId->nombre))}}</span></p>
                    <p>Documento:
                        <span class="font-bold text-black">
                            {{$pago->acuerdo->propuesta->operacionId->deudorId->tipo_doc}} -
                            {{$pago->acuerdo->propuesta->operacionId->deudorId->nro_doc}}
                        </span>
                    </p>
                    <p>Nro Cuota: <span class="font-bold text-black">{{ $pago->nro_cuota}}</span></p>
                    <p>Monto de Cta: <span class="font-bold text-black">${{number_format($pago->monto, 2, ',', '.')}}</span></p>
                    <p>Vencimiento: <span class="font-bold text-black">{{ \Carbon\Carbon::parse($pago->vencimiento)->format('d/m/Y') }}</span></p>
                </div>            
            </div>
            <livewire:subir-comprobante :pago="$pago" />
        </div>
    </div>
</x-app-layout>