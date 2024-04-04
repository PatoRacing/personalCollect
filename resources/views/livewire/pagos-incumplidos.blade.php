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
            Pagos Incumplidos
        </h1>               
    </div>
    <div class="bg-white pt-4 px-4">
        <livewire:buscar-pagos-incumplidos />
        @if($pagosIncumplidos->count())
            <div>
                <div class="container grid grid-cols-3 gap-2">
                    @foreach ($pagosIncumplidos as $pagoIncumplido)
                    <!--Pagos-->
                        <div class="border rounded">
                            <div class="px-2 text-gray-600">
                                <!-- detalle pago-->
                                <h2 class= "{{$classesNombre}}">
                                    {{$pagoIncumplido->acuerdo->propuesta->deudorId->nombre}}
                                </h2>
                                <h3 class="{{$classesTitulo}}">Detalle del Pago:</h3>
                                <p>Cliente:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoIncumplido->acuerdo->propuesta->operacionId->clienteId->nombre }}
                                    </span>
                                </p>
                                <p>DNI Deudor:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoIncumplido->acuerdo->propuesta->deudorId->nro_doc }}
                                    </span>
                                </p>
                                <p>CUIL Deudor:
                                    @if($pagoIncumplido->acuerdo->propuesta->deudorId->cuil)
                                        <span class="{{$classesSpan}}">
                                            {{ $pagoIncumplido->acuerdo->propuesta->deudorId->cuil}}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>Operación:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoIncumplido->acuerdo->propuesta->operacionId->operacion }}
                                    </span>
                                </p>
                                <p>Segmento:
                                    <span class="{{$classesSpan}}">
                                        @if ( $pagoIncumplido->acuerdo->propuesta->operacionId->segmento)
                                            {{ $pagoIncumplido->acuerdo->propuesta->operacionId->segmento }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif
                                    </span>
                                </p>
                                <p>Producto:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoIncumplido->acuerdo->propuesta->operacionId->productoId->nombre }}
                                    </span>
                                </p>
                                <p>Nro. Cuota: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoIncumplido->nro_cuota}}
                                    </span>
                                </p>
                                <p>Concepto: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoIncumplido->concepto}}
                                    </span>
                                </p>
                                <p>$ de Cuota: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($pagoIncumplido->monto, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Vencimiento: 
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($pagoIncumplido->vencimiento)->format('d/m/Y') }}
                                    </span>
                                </p>
                                <p>Responsable: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoIncumplido->acuerdo->propuesta->usuarioUltimaModificacion->name}}
                                        {{$pagoIncumplido->acuerdo->propuesta->usuarioUltimaModificacion->apellido}}
                                    </span>
                                </p>
                            </div>  
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-gray-800 p-6 mt-4 text-center font-bold">
                No hay pagos incumplidos
            </p>
        @endif
        <div class="my-5 p-3">
            {{$pagosIncumplidos->links()}}
        </div>
    </div>
</div>
