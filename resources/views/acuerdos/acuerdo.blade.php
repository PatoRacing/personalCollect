@section('titulo')
    Acuerdo
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="px-4 py-2 sticky left-0 mb-1">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-4">Detalle del Acuerdo</h1>
                <a href="{{route('acuerdos')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                @if(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-3 p-3 ">
                        {{ session('message') }}
                    </div>
                @endif 
                <!--Bajada-->
                <div class="px-14 py-4 lg:flex lg:items-center lg:justify-between text-sm
                        bg-white rounded border border-gray-200 border-1 text-gray-600 mt-4">
                    <p>Deudor: <span class="font-bold text-black">{{ ucwords(strtolower($acuerdo->propuesta->operacionId->deudorId->nombre))}}</span></p>
                    <p>Documento:
                        <span class="font-bold text-black">
                            {{$acuerdo->propuesta->operacionId->deudorId->tipo_doc}} -
                            {{ $acuerdo->propuesta->operacionId->deudorId->nro_doc}}
                        </span>
                    </p>
                    <p>Producto: <span class="font-bold text-black">{{ ucwords(strtolower($acuerdo->propuesta->operacionId->productoId->nombre))}}</span></p>
                    <p>Total a Pagar: $<span class="font-bold text-black">{{number_format($acuerdo->propuesta->monto_ofrecido, 2, ',', '.')}}</span></p>
                </div>
                <table class="table-auto overflow-x-auto min-w-full bg-white shadow-md rounded mt-2 text-sm">
                    <thead>
                        <tr class="bg-blue-800 text-white">
                            <th class="px-1.5 py-3 bg-blue-800 sticky left-0">Nro. de Cuota</th>
                            <th class="px-1.5 py-3">Concepto</th>
                            <th class="px-1.5 py-3">Monto</th>
                            <th class="px-1.5 py-3">Vencimiento</th>
                            <th class="px-1.5 py-3">Estado</th>
                            <th class="px-1.5 py-3">Comprobante</th>
                            <th class="px-1.5 py-3">Ult. Modificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $cuotaNumero = 1; @endphp
                        @foreach($pagos as $index => $pago)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">

                                <td class="border px-1.5 py-3 text-center sticky left-0
                                    {{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">
                                    {{ $pago->nro_cuota }}
                                </td>

                                <td class="border px-1.5 py-3 text-center align-middle">
                                    {{ $pago->concepto }}
                                </td>

                                <td class="border px-1.5 py-3 text-center align-middle">
                                    ${{ number_format($pago->monto, 2, ',', '.') }}
                                </td>

                                <td class="border px-1.5 py-3 text-center align-middle">
                                    {{ \Carbon\Carbon::parse($pago->vencimiento)->format('d/m/Y') }}
                                </td>

                                <td class="border px-1.5 py-3 text-center align-middle">
                                    <livewire:actualizar-pago :pago="$pago"/>
                                </td>

                                <td class="border px-1.5 py-4 text-center align-middle">
                                    @if ($pago->comprobante)
                                        <a href="{{ Storage::url('public/comprobantes/' . $pago->comprobante) }}"
                                            class="text-white w-28 h-10 rounded bg-green-700 px-4 py-3 hover:bg-green-800"
                                            target="_blank">
                                            Ver
                                        </a>
                                    @else
                                        <a href= "{{ route('subir.comprobantes', ['pago' => $pago->id]) }}"
                                            class="text-white w-28 h-10 rounded bg-indigo-500 px-4 py-3 hover:bg-indigo-800">
                                            Subir
                                        </a>
                                    @endif
                                </td>

                                <td class="border px-1.5 py-3 text-center align-middle">
                                    {{ $pago->usuarioUltimaModificacion->name }}
                                    {{ $pago->usuarioUltimaModificacion->apellido }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>             
            </div>
        </div>
    </div>
</x-app-layout>