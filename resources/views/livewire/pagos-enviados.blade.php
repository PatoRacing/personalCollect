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
            Pagos Enviados
        </h1>                
    </div>
    <div class="bg-white pt-4 px-4">
        <livewire:buscar-pagos-enviados />
        @if($pagosEnviados->count())
            <div>
                <div class="container grid grid-cols-3 gap-2">
                    @foreach ($pagosEnviados as $pagoEnviado)
                    <!--Pagos-->
                        <div class="border rounded">
                            <div class="px-2 text-gray-600">
                                <!-- detalle pago-->
                                <h2 class= "{{$classesNombre}}">
                                    {{$pagoEnviado->acuerdo->propuesta->deudorId->nombre}}
                                </h2>
                                <h3 class="{{$classesTitulo}}">Detalle del Pago:</h3>
                                <p>Cliente:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoEnviado->acuerdo->propuesta->operacionId->clienteId->nombre }}
                                    </span>
                                </p>
                                <p>DNI Deudor:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoEnviado->acuerdo->propuesta->deudorId->nro_doc }}
                                    </span>
                                </p>
                                <p>CUIL Deudor:
                                    @if($pagoEnviado->acuerdo->propuesta->deudorId->cuil)
                                        <span class="{{$classesSpan}}">
                                            {{ $pagoEnviado->acuerdo->propuesta->deudorId->cuil}}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>Operación:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoEnviado->acuerdo->propuesta->operacionId->operacion }}
                                    </span>
                                </p>
                                <p>Segmento:
                                    <span class="{{$classesSpan}}">
                                        @if ( $pagoEnviado->acuerdo->propuesta->operacionId->segmento)
                                            {{ $pagoEnviado->acuerdo->propuesta->operacionId->segmento }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif
                                    </span>
                                </p>
                                <p>Producto:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoEnviado->acuerdo->propuesta->operacionId->productoId->nombre }}
                                    </span>
                                </p>
                                <p>Nro. Cuota: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoEnviado->nro_cuota}}
                                    </span>
                                </p>
                                <p>Concepto: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoEnviado->concepto}}
                                    </span>
                                </p>
                                <p>$ de Cuota: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($pagoEnviado->monto, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Vencimiento: 
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($pagoEnviado->vencimiento)->format('d/m/Y') }}
                                    </span>
                                </p>
                                <p>Responsable: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoEnviado->acuerdo->propuesta->usuarioUltimaModificacion->name}}
                                        {{$pagoEnviado->acuerdo->propuesta->usuarioUltimaModificacion->apellido}}
                                    </span>
                                </p>
                            </div>  
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-gray-800 p-6 mt-4 text-center font-bold">
                No hay pagos enviados
            </p>
        @endif
        <div class="my-5 p-3">
            {{$pagosEnviados->links()}}
        </div>
    </div>
</div>
