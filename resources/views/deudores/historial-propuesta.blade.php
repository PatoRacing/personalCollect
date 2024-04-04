@section('titulo')
    Historial de Gestiones
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-bold bg-white p-4 text-gray-800 text-center mb-5">Gestiones de operación {{$operacion->operacion}} de {{ucwords(strtolower($operacion->deudorId->nombre))}}</h1>
                <a href="{{ route('deudor.perfil', ['deudor' => $operacion->deudorId->id]) }}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">{{ucwords(strtolower($operacion->deudorId->nombre))}}</a>
                <a href="{{ route('propuesta', ['operacion' => $operacion->id]) }}" class="text-white  rounded bg-green-700 px-4 py-3 hover:bg-green-800">Nueva Gestión</a>
                <!--Bajada-->
                <div class="px-14 py-4 lg:flex lg:items-center lg:justify-between text-lg
                        bg-white rounded border border-gray-200 border-1 text-gray-600 mt-4">
                    <p>Cliente: <span class="font-bold text-black">{{ $operacion->clienteId->nombre }}</span></p>
                    <p>Producto: <span class="font-bold text-black">{{$operacion->productoId->nombre }}</span></p>
                    <p>Deuda Capital: <span class="font-bold text-black">${{number_format($operacion->deuda_capital, 2, ',', '.')}}</span></p>                    
                    <p>Situacion actual: 
                        <span class="font-bold text-black">
                            @php
                                $ultimaPropuesta = $operacion->propuestas()->latest('updated_at')->first();
                            @endphp
                            @if($ultimaPropuesta)
                                {{ $ultimaPropuesta->estado }}
                            @else
                                Sin gestión
                            @endif</span>
                    </p>
                </div>
                @if(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-5 p-3 ">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
                @if($propuestas->count())
                    <table class="table-auto overflow-x-auto min-w-full bg-white shadow-md rounded pb-3 ">
                        <thead>
                            <tr class="bg-blue-800 text-white sticky left-0">
                                <th class="px-1 py-2 bg-blue-800 sticky left-0">M. Ofrecido</th>
                                <th class="px-1 py-2">Total ACP</th>
                                <th class="px-1 py-2">% Quita</th>
                                <th class="px-1 py-2">Anticipo</th>
                                <th class="px-1 py-2">N° Ctas. 1</th>
                                <th class="px-1 py-2">$ Ctas. 1</th>
                                <th class="px-1 py-2">N° Ctas. 2</th>
                                <th class="px-1 py-2">$ Ctas. 2</th>
                                <th class="px-1 py-2">N° Ctas. 3</th>
                                <th class="px-1 py-2">$ Ctas. 3</th>
                                <th class="px-1 py-2">Estado</th>
                                <th class="px-1 py-2">Más</th>
                            </tr>
                        </thead>
                        <tbody>
                            @push('scripts')
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                    Livewire.on('modalInformacionPropuesta', function (data) {
                                        const propuesta = data.propuesta;
                                        const usuario = data.usuario;
                                        function formatFecha(fecha) {
                                            const opciones = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                                            const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES', opciones);
                                            return fechaFormateada;
                                        }
                                        function obtenerDescripcionTipoPropuesta(tipo) {
                                            switch (tipo) {
                                                case 1:
                                                    return 'Cancelación';
                                                case 2:
                                                    return 'Cuotas con Descuento';
                                                case 3:
                                                    return 'Cuotas Fijas c/s Anticipo';
                                                case 4:
                                                    return 'Ctas. Variables c/s Anticipo';
                                                default:
                                                    return 'Desconocido';
                                            }
                                        }
                                        console.log(propuesta)
                                        let htmlContent = `
                                            <p class="p-2">Usuario: <span class="font-bold text-black">${usuario.name} ${usuario.apellido}</span></p>
                                            <p class="p-2">Obs: <span class="font-bold text-black">${propuesta.observaciones}</span></p>
                                            <p class="p-2">Tipo Propuesta: <span class="font-bold text-black">${obtenerDescripcionTipoPropuesta(propuesta.tipo_de_propuesta)}</span></p>
                                            <p class="p-2">Fecha: <span class="font-bold text-black">${formatFecha(propuesta.created_at)}</span></p>`;

                                        if (propuesta.vencimiento) {
                                            htmlContent += `<p class="p-2">Vto. de Propuesta: <span class="font-bold text-black">${formatFecha(propuesta.vencimiento)}</span></p>`;
                                        }

                                        if (propuesta.fecha_pago_cuota) {
                                            htmlContent += `<p class="p-2">F. de Pago: <span class="font-bold text-black">${formatFecha(propuesta.fecha_pago_cuota)}</span></p>`;
                                        }

                                        if (propuesta.fecha_pago_anticipo && propuesta.fecha_pago_cuota) {
                                            htmlContent += `<p class="p-2">F. de Pago (Anticipo): <span class="font-bold text-black">${formatFecha(propuesta.fecha_pago_anticipo)}</span></p>
                                                            <p class="p-2">F. de Pago (Cuota 1): <span class="font-bold text-black">${formatFecha(propuesta.fecha_pago_cuota)}</span></p>`;
                                        }

                                        Swal.fire({
                                            title: 'Propuesta: Detalles',
                                            icon: 'info',
                                            html: htmlContent,
                                            showCloseButton: true,
                                            showCancelButton: true,
                                            confirmButtonText: 'Nueva',
                                            confirmButtonColor: '#15803D',
                                            cancelButtonText: 'Cancelar',
                                            cancelButtonColor: '#DC2626',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "{{ route('propuesta', ['operacion' => $operacion->id]) }}";
                                            } 
                                        });
                                    });
                                </script>
                            @endpush
                            @foreach($propuestas as $index => $propuesta)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">
                                    <td class="border p-1 text-center sticky left-0
                                    {{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">
                                        ${{number_format($propuesta->monto_ofrecido, 2, ',', '.')}}
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        ${{number_format($propuesta->total_acp, 2, ',', '.')}}
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if ($propuesta->porcentaje_quita)
                                            {{number_format($propuesta->porcentaje_quita, 2, ',', '.')}}%
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if($propuesta->anticipo)
                                            ${{number_format($propuesta->anticipo, 2, ',', '.')}}
                                        @else 
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if($propuesta->cantidad_de_cuotas_uno)
                                            {{$propuesta->cantidad_de_cuotas_uno}}
                                        @else 
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if($propuesta->monto_de_cuotas_uno)
                                            ${{number_format($propuesta->monto_de_cuotas_uno, 2, ',', '.')}}
                                        @else 
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if($propuesta->cantidad_de_cuotas_dos)
                                            {{$propuesta->cantidad_de_cuotas_dos}}
                                        @else 
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if($propuesta->monto_de_cuotas_dos)
                                            ${{number_format($propuesta->monto_de_cuotas_dos, 2, ',', '.')}}
                                        @else 
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if($propuesta->cantidad_de_cuotas_tres)
                                            {{$propuesta->cantidad_de_cuotas_tres}}
                                        @else 
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        @if($propuesta->monto_de_cuotas_tres)
                                            ${{number_format($propuesta->monto_de_cuotas_tres, 2, ',', '.')}}
                                        @else 
                                            -
                                        @endif
                                    </td>

                                    <td class="border p-1 text-center align-middle">
                                        {{$propuesta->estado === 'Propuesta de Pago' ? 'P. de Pago'
                                        : ($propuesta->estado === 'Acuerdo de Pago' ? 'A. de Pago'
                                        : $propuesta->estado)}}
                                    </td>

                                    <livewire:mas-informacion :propuesta="$propuesta"/>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-800 p-2 text-center font-bold">
                        Esta operación no tiene gestiones realizadas
                    </p>
                @endif
        </div>
    </div>
</x-app-layout>