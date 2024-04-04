<div>
    <!-- clases-->
    @php
        $classesSpan = "font-bold text-black";
        $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-2 text-center py-2";
        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
        $classesTipo = "text-center bg-blue-800 text-white py-2 font-bold rounded my-4 uppercase";
        $classesButtonTrue = "text-white rounded-md text-sm bg-blue-400 border-2 text-center py-3 px-6";
        $classesButtonFalse = "text-white rounded-md bg-blue-300 text-sm border-2 text-center py-3 px-6";
    @endphp
    <div class="sticky left-0">
        <h1 class="font-bold uppercase rounded bg-blue-800 p-4 text-white text-center mb-2 flex items-center justify-center space-x-8">
            Pagos Informados
        </h1>               
    </div>
    <div class="bg-white pt-4 px-4">
        <div class="mb-4">
        </div>
        <livewire:buscar-pagos-informados />
        @if($pagosInformados->count())
            <div>
                <div class="container grid grid-cols-3 gap-2">
                    @foreach ($pagosInformados as $pagoInformado)
                    @php
                        $detallePago = \App\Models\PagoInformado::where('pago_id', $pagoInformado->id)->first();
                    @endphp
                    <!--Pagos-->
                        <div class="border rounded">
                            <div class="px-2 text-gray-600">
                                <!-- detalle pago-->
                                <h2 class= "{{$classesNombre}}">
                                    {{$pagoInformado->acuerdo->propuesta->deudorId->nombre}}
                                </h2>
                                <h3 class="{{$classesTitulo}}">Detalle del Pago:</h3>
                                <p>Cliente:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoInformado->acuerdo->propuesta->operacionId->clienteId->nombre }}
                                    </span>
                                </p>
                                <p>Operación:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoInformado->acuerdo->propuesta->operacionId->operacion }}
                                    </span>
                                </p>
                                <p>Segmento:
                                    <span class="{{$classesSpan}}">
                                        @if ( $pagoInformado->acuerdo->propuesta->operacionId->segmento)
                                            {{ $pagoInformado->acuerdo->propuesta->operacionId->segmento }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif
                                    </span>
                                </p>
                                <p>Producto:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoInformado->acuerdo->propuesta->operacionId->productoId->nombre }}
                                    </span>
                                </p>
                                <p>DNI Deudor:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoInformado->acuerdo->propuesta->deudorId->nro_doc }}
                                    </span>
                                </p>
                                <p>Nro. Cuota:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoInformado->nro_cuota }}
                                    </span>
                                </p>
                                <p>$ de Cuota:
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($pagoInformado->monto, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Fecha de Pago:
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($detallePago->fecha_de_pago)->format('d/m/Y') }}
                                    </span>
                                </p>
                                <p>Monto abonado:
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($detallePago->monto, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Medio de Pago:
                                    @if($detallePago->medio_de_pago == 'transferencia')
                                        <span class="{{$classesSpan}}">
                                            Transferencia
                                        </span>
                                    @elseif($detallePago->medio_de_pago == 'deposito')
                                        <span class="{{$classesSpan}}">
                                            Depósito
                                        </span>
                                    @elseif($detallePago->medio_de_pago == 'efectivo')
                                        <span class="{{$classesSpan}}">
                                            Efectivo
                                        </span>
                                    @endif
                                </p>
                                @if($detallePago->sucursal)
                                    <p>Sucursal:
                                        <span class="{{$classesSpan}}">
                                            {{ $detallePago->sucursal }}
                                        </span>
                                    </p>
                                @endif
                                @if($detallePago->hora)
                                    <p>Hora:
                                        <span class="{{$classesSpan}}">
                                            {{ $detallePago->hora }}
                                        </span>
                                    </p>
                                @endif
                                @if($detallePago->cuenta)
                                    <p>Cuenta:
                                        <span class="{{$classesSpan}}">
                                            {{ $detallePago->cuenta }}
                                        </span>
                                    </p>
                                @endif
                                @if($detallePago->nombre_tercero)
                                    <p>Titular Cta:
                                        <span class="{{$classesSpan}}">
                                            {{ $detallePago->nombre_tercero }}
                                        </span>
                                    </p>
                                @endif
                                <p>Informado por:
                                    <span class="{{$classesSpan}}">
                                        {{ $detallePago->usuarioUltimaModificacion->name }}
                                        {{ $detallePago->usuarioUltimaModificacion->apellido }}
                                    </span>
                                </p>
                                <div class="flex mt-2 gap-1 px-2">
                                    @if($detallePago->comprobante)
                                    <div class="w-1/2 text-white rounded-md text-sm bg-green-700 border-2 text-center py-2.5 px-6">
                                        <span class="mt-2">
                                            <a href="{{ Storage::url('comprobantes/' . $detallePago->comprobante) }}"
                                                target="_blank">
                                                Ver Comprobante
                                            </a>
                                        </span>
                                    </div>                                  
                                    @else
                                    <div class="w-1/2 text-white rounded-md text-sm bg-red-700 border-2 text-center py-2.5 px-6">
                                        <span class=" mt-2">
                                            <p>
                                                Sin Comprobante
                                            </p>
                                        </span>
                                    </div>
                                    @endif
                                    <div class="w-1/2 text-white rounded-md text-sm bg-blue-800 border-2 text-center py-2.5 px-6">
                                        <button 
                                                wire:click="aplicarPago({{ $pagoInformado->id }})">
                                            Aplicar
                                        </button>
                                    </div>
                                </div>
                                
                                @if($aplicarPago && !$errors->any())
                                    <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50 bg-gray-90">
                                        <div class="flex flex-col items-center bg-white p-6 rounded-md border-8 border-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600 font-extrabold rounded-full cursor-not-allowed">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                            </svg>
                                            <div>
                                                <h1 class="font-extrabold text-2xl p-2 text-black text-center">Atención</h1>
                                                <p class="uppercase {{$classesSpan}} text-center">Vas a cambiar el estado del pago a Aplicado</p>
                                                <p>Si confirmas podrás ver el mismo en la sección de
                                                    <span class="{{$classesSpan}} uppercase">aplicados</span>
                                                </p>
                                                <div class="p-2 flex justify-center gap-2">
                                                    <button class="p-2 w-full justify-center bg-green-700 hover:bg-green-800 text-white"
                                                            wire:click="confirmarAplicarPago({{ $pagoIdParaConfirmar }})">
                                                            Confirmar
                                                    </button>
                                                    <button class="p-2 w-full justify-center bg-red-600 hover:bg-red-800 text-white"
                                                        wire:click="cancelarAplicarPago">
                                                            Cancelar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div> 
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-gray-800 p-6 mt-4 text-center font-bold">
                No hay pagos informados
            </p>
        @endif
        <div class="my-5 p-3">
            {{$pagosInformados->links()}}
        </div>
    </div>
</div>