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
            Pagos Vigentes
        </h1>             
    </div>
    
    <div class="bg-white pt-4 px-4">
        <div class="mb-4">
            <a class="text-white rounded-md text-sm bg-green-700 border-2 text-center py-3 px-6"
                href="{{route('importar.pagos')}}">
                + Importar
            </a>
        </div>
        
        <livewire:buscar-pagos-vigentes />
        @if($pagosVigentes->count())
            <div>
                <div class="container grid grid-cols-3 gap-2">
                    @foreach ($pagosVigentes as $pagoVigente)
                    <!--Pagos-->
                        <div class="border rounded">
                            <div class="px-2 text-gray-600">
                                <!-- detalle pago-->
                                <h2 class= "{{$classesNombre}}">
                                    {{$pagoVigente->acuerdo->propuesta->deudorId->nombre}}
                                </h2>
                                <h3 class="{{$classesTitulo}}">Detalle del Pago:</h3>
                                <p>Cliente:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoVigente->acuerdo->propuesta->operacionId->clienteId->nombre }}
                                    </span>
                                </p>
                                <p>DNI Deudor:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoVigente->acuerdo->propuesta->deudorId->nro_doc }}
                                    </span>
                                </p>
                                <p>CUIL Deudor:
                                    @if($pagoVigente->acuerdo->propuesta->deudorId->cuil)
                                        <span class="{{$classesSpan}}">
                                            {{ $pagoVigente->acuerdo->propuesta->deudorId->cuil}}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </p>
                                <p>Operación:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoVigente->acuerdo->propuesta->operacionId->operacion }}
                                    </span>
                                </p>
                                <p>Segmento:
                                    <span class="{{$classesSpan}}">
                                        @if ( $pagoVigente->acuerdo->propuesta->operacionId->segmento)
                                            {{ $pagoVigente->acuerdo->propuesta->operacionId->segmento }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif
                                    </span>
                                </p>
                                <p>Producto:
                                    <span class="{{$classesSpan}}">
                                        {{ $pagoVigente->acuerdo->propuesta->operacionId->productoId->nombre }}
                                    </span>
                                </p>
                                <p>Nro. Cuota: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoVigente->nro_cuota}}
                                    </span>
                                </p>
                                <p>Concepto: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoVigente->concepto}}
                                    </span>
                                </p>
                                <p>$ de Cuota: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($pagoVigente->monto, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Vencimiento: 
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($pagoVigente->vencimiento)->format('d/m/Y') }}
                                    </span>
                                </p>
                                <p>Responsable: 
                                    <span class="{{$classesSpan}}">
                                        {{$pagoVigente->acuerdo->propuesta->usuarioUltimaModificacion->name}}
                                        {{$pagoVigente->acuerdo->propuesta->usuarioUltimaModificacion->apellido}}
                                    </span>
                                </p>
                                <div class="p-4 flex justify-center gap-2">  
                                    <a class="text-white w-full rounded-md text-sm bg-green-700 border-2 text-center py-2.5 px-6"
                                        href="{{ route('informar.pagos', ['pagoId' => $pagoVigente->id]) }}">
                                        Informar
                                    </a>
                                    <button class="text-white w-full rounded-md text-sm bg-blue-800 border-2 text-center py-2.5 px-6"
                                            wire:click="aplicarPago({{ $pagoVigente->id }})">
                                        Aplicar
                                    </button>
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
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-gray-800 p-6 mt-4 text-center font-bold">
                No hay pagos vigentes
            </p>
        @endif
        <div class="my-5 p-3">
            {{$pagosVigentes->links()}}
        </div>
    </div>
</div>
