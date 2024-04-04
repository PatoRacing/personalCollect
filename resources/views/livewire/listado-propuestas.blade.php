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
    <div class="px-4 py-2 sticky left-0">
        <h1 class="font-bold uppercase bg-gray-200 p-4 text-gray-900 hover:text-gray-500 text-center mb-2 flex items-center justify-center space-x-8">
            Propuestas de Pago
        </h1>
    
        @if(session('message'))
            <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-3 p-3 ">
                {{ session('message') }}
            </div>
        @endif                
    </div>
    <div class="px-4 py-1 border bg-gray-200 rounded-lg">
        <div class="flex justify-end px-5 my-2">
            @if($noEnviadas)
                <button class="{{$classesButtonTrue}} bg-blue-800"
                        wire:click="confirmarExportar({{ $totalPropuestasNoEnviadas }})">
                    Exportar
                </button>
                <button class="{{$classesButtonTrue}}" wire:click="noEnviadas">
                    Sin Enviar
                </button>
                <button class="{{$classesButtonFalse}}" wire:click="enviadas">
                    Enviadas
                </button>
            @elseif($enviadas)
                <button class="{{$classesButtonFalse}}" wire:click="noEnviadas">
                    Sin Enviar
                </button>
                <button class="{{$classesButtonTrue}}" wire:click="enviadas">
                    Enviadas
                </button>
            @endif
        </div>
        @if($noEnviadas)
            @if($propuestasNoEnviadas->count())
                <!--contenedor de operaciones-->
                <div class="container grid grid-cols-4 gap-2">
                    @foreach ($propuestasNoEnviadas as $propuestaNoEnviada)
                        <!--operacion-->
                        <div class="border rounded bg-white">
                            <div class="px-2 text-gray-600">
                                <!-- detalle propuesta-->
                                <h2 class= "{{$classesNombre}}">
                                    {{$propuestaNoEnviada->deudorId->nombre}}
                                </h2>
                                <h3 class="{{$classesTitulo}}">Detalle de la operación:</h3>
                                <p>Cliente: <span class="{{$classesSpan}}">{{ $propuestaNoEnviada->operacionId->clienteId->nombre }}</span></p>
                                <p>DNI Deudor: <span class="{{$classesSpan}}">{{ $propuestaNoEnviada->deudorId->nro_doc }}</span></p>
                                <p>Operación: <span class="{{$classesSpan}}">{{ $propuestaNoEnviada->operacionId->operacion }}</span></p>
                                <p>Segmento:
                                    <span class="{{$classesSpan}}">
                                        @if ( $propuestaNoEnviada->operacionId->segmento)
                                            {{ $propuestaNoEnviada->operacionId->segmento }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif
                                    </span>
                                </p>
                                <p>Producto: <span class="{{$classesSpan}}">{{ $propuestaNoEnviada->operacionId->productoId->nombre }}</span></p>
                                <p>Fecha Asig.:
                                    <span class="{{$classesSpan}}">
                                        @if ( $propuestaNoEnviada->operacionId->fecha_asignacion)
                                            {{ \Carbon\Carbon::parse($propuestaNoEnviada->operacionId->fecha_asignacion)->format('d/m/Y') }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif      
                                    </span>
                                </p>
                                <h3 class="{{$classesTitulo}}">Detalle de la Propuesta:</h3>
                                <p>Agente: 
                                    <span class="{{$classesSpan}}">
                                        {{$propuestaNoEnviada->usuarioUltimaModificacion->name}}
                                        {{$propuestaNoEnviada->usuarioUltimaModificacion->apellido}}
                                    </span>
                                </p>
                                <p>Monto a Pagar: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaNoEnviada->monto_ofrecido, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Total ACP: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaNoEnviada->total_acp, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Honorarios: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaNoEnviada->honorarios, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Deuda Capital: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaNoEnviada->operacionId->deuda_capital, 2, ',', '.') }}
                                    </span>
                                </p>
                                @if($propuestaNoEnviada->porcentaje_quita)
                                    <p>% Quita: 
                                        <span class="{{$classesSpan}}">
                                            {{ number_format($propuestaNoEnviada->porcentaje_quita, 2, ',', '.') }}%
                                        </span>
                                    </p>
                                @endif
                                <p>Fecha de Pago cuota: 
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($propuestaNoEnviada->fecha_pago_cuota)->format('d/m/Y') }}
                                    </span>
                                </p>
                                @if($propuestaNoEnviada->anticipo)
                                    <p>Anticipo: 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaNoEnviada->anticipo, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaNoEnviada->fecha_pago_anticipo)
                                    <p>Fecha de Pago Anticipo: 
                                        <span class="{{$classesSpan}}">
                                            {{ \Carbon\Carbon::parse($propuestaNoEnviada->fecha_pago_anticipo)->format('d/m/Y') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaNoEnviada->cantidad_de_cuotas_uno)
                                    <p>Cantidad de Ctas (1): 
                                        <span class="{{$classesSpan}}">
                                            {{ $propuestaNoEnviada->cantidad_de_cuotas_uno}}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaNoEnviada->monto_de_cuotas_uno)
                                    <p>$ de Cuotas (1): 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaNoEnviada->monto_de_cuotas_uno, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaNoEnviada->cantidad_de_cuotas_dos)
                                    <p>Cantidad de Ctas (2): 
                                        <span class="{{$classesSpan}}">
                                            {{ $propuestaNoEnviada->cantidad_de_cuotas_dos}}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaNoEnviada->monto_de_cuotas_dos)
                                    <p>$ de Cuotas (2): 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaNoEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaNoEnviada->cantidad_de_cuotas_tres)
                                    <p>Cantidad de Ctas (3): 
                                        <span class="{{$classesSpan}}">
                                            {{ $propuestaNoEnviada->cantidad_de_cuotas_dos}}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaNoEnviada->monto_de_cuotas_tres)
                                    <p>$ de Cuotas (3): 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaNoEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                <h2 class= "{{$classesTipo}}">
                                    Tipo: 
                                    @if($propuestaNoEnviada->tipo_de_propuesta == 1)
                                        Cancelación
                                    @elseif($propuestaNoEnviada->tipo_de_propuesta == 2)
                                        Cuotas Fijas
                                    @elseif($propuestaNoEnviada->tipo_de_propuesta == 3)
                                        Cuotas C/Descuento
                                    @elseif($propuestaNoEnviada->tipo_de_propuesta == 4)
                                        Cuotas Variables
                                    @endif
                                </h2>
                            </div>  
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-1/3 mx-auto bg-white">
                    <p class="text-gray-800 p-8 text-center font-bold shadow-sm">
                        No hay propuestas sin enviar
                    </p>
                </div>
            @endif
            <div class="my-5 pb-3">
                {{$propuestasNoEnviadas->links()}}
            </div>
        @elseif($enviadas)
            @if($propuestasEnviadas->count())
                <!--contenedor de operaciones-->
                <div class="p-1 container grid grid-cols-4 gap-2">
                    @foreach ($propuestasEnviadas as $propuestaEnviada)
                        <!--operacion-->
                        <div class="border rounded bg-white">
                            <div class="px-2 text-gray-600">
                                <!-- detalle propuesta-->
                                <h2 class= "{{$classesNombre}}">
                                    {{$propuestaEnviada->deudorId->nombre}}
                                </h2>
                                <h3 class="{{$classesTitulo}}">Detalle de la operación:</h3>
                                <p>Cliente: <span class="{{$classesSpan}}">{{ $propuestaEnviada->operacionId->clienteId->nombre }}</span></p>
                                <p>DNI Deudor: <span class="{{$classesSpan}}">{{ $propuestaEnviada->deudorId->nro_doc }}</span></p>
                                <p>Operación: <span class="{{$classesSpan}}">{{ $propuestaEnviada->operacionId->operacion }}</span></p>
                                <p>Segmento:
                                    <span class="{{$classesSpan}}">
                                        @if ( $propuestaEnviada->operacionId->segmento)
                                            {{ $propuestaEnviada->operacionId->segmento }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif
                                    </span>
                                </p>
                                <p>Producto: <span class="{{$classesSpan}}">{{ $propuestaEnviada->operacionId->productoId->nombre }}</span></p>
                                <p>Fecha Asig.:
                                    <span class="{{$classesSpan}}">
                                        @if ( $propuestaEnviada->operacionId->fecha_asignacion)
                                            {{ \Carbon\Carbon::parse($propuestaEnviada->operacionId->fecha_asignacion)->format('d/m/Y') }}
                                        @else
                                            <span class="text-red-600"> Sin datos </span>
                                        @endif      
                                    </span>
                                </p>
                                <h3 class="{{$classesTitulo}}">Detalle de la Propuesta:</h3>
                                <p>Agente: 
                                    <span class="{{$classesSpan}}">
                                        {{$propuestaEnviada->usuarioUltimaModificacion->name}}
                                        {{$propuestaEnviada->usuarioUltimaModificacion->apellido}}
                                    </span>
                                </p>
                                <p>Monto a Pagar: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaEnviada->monto_ofrecido, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Total ACP: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaEnviada->total_acp, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Honorarios: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaEnviada->honorarios, 2, ',', '.') }}
                                    </span>
                                </p>
                                <p>Deuda Capital: 
                                    <span class="{{$classesSpan}}">
                                        ${{ number_format($propuestaEnviada->operacionId->deuda_capital, 2, ',', '.') }}
                                    </span>
                                </p>
                                @if($propuestaEnviada->porcentaje_quita)
                                    <p>% Quita: 
                                        <span class="{{$classesSpan}}">
                                            {{ number_format($propuestaEnviada->porcentaje_quita, 2, ',', '.') }}%
                                        </span>
                                    </p>
                                @endif
                                <p>Fecha de Pago Cuota: 
                                    <span class="{{$classesSpan}}">
                                        {{ \Carbon\Carbon::parse($propuestaEnviada->fecha_pago_cuota)->format('d/m/Y') }}
                                    </span>
                                </p>
                                @if($propuestaEnviada->anticipo)
                                    <p>Anticipo: 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaEnviada->anticipo, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaEnviada->fecha_pago_anticipo)
                                    <p>Fecha de Pago Anticipo: 
                                        <span class="{{$classesSpan}}">
                                            {{ \Carbon\Carbon::parse($propuestaEnviada->fecha_pago_anticipo)->format('d/m/Y') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaEnviada->cantidad_de_cuotas_uno)
                                    <p>Cantidad de Ctas (1): 
                                        <span class="{{$classesSpan}}">
                                            {{ $propuestaEnviada->cantidad_de_cuotas_uno}}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaEnviada->monto_de_cuotas_uno)
                                    <p>$ de Cuotas (1): 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaEnviada->monto_de_cuotas_uno, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaEnviada->cantidad_de_cuotas_dos)
                                    <p>Cantidad de Ctas (2): 
                                        <span class="{{$classesSpan}}">
                                            {{ $propuestaEnviada->cantidad_de_cuotas_dos}}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaEnviada->monto_de_cuotas_dos)
                                    <p>$ de Cuotas (2): 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaEnviada->cantidad_de_cuotas_tres)
                                    <p>Cantidad de Ctas (3): 
                                        <span class="{{$classesSpan}}">
                                            {{ $propuestaEnviada->cantidad_de_cuotas_dos}}
                                        </span>
                                    </p>
                                @endif
                                @if($propuestaEnviada->monto_de_cuotas_tres)
                                    <p>$ de Cuotas (3): 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($propuestaEnviada->monto_de_cuotas_dos, 2, ',', '.') }}
                                        </span>
                                    </p>
                                @endif
                                <h2 class= "{{$classesTipo}}">
                                    Tipo: 
                                    @if($propuestaEnviada->tipo_de_propuesta == 1)
                                        Cancelación
                                    @elseif($propuestaEnviada->tipo_de_propuesta == 2)
                                        Cuotas Fijas
                                    @elseif($propuestaEnviada->tipo_de_propuesta == 3)
                                        Cuotas C/Descuento
                                    @elseif($propuestaEnviada->tipo_de_propuesta == 4)
                                        Cuotas Variables
                                    @endif
                                </h2>
                            </div>  
                        </div>
                    @endforeach
                </div>
            @else
                <div class="w-1/3 mx-auto bg-white">
                    <p class="text-gray-800 p-8 text-center font-bold shadow-sm">
                        No hay propuestas enviadas
                    </p>
                </div>
            @endif
            <div class="my-5 pb-3">
                {{$propuestasEnviadas->links()}}
            </div>
        @endif
    </div>
    @if($confirmarExportacion && !$errors->any())
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50 bg-gray-90">
            <div class="flex flex-col items-center bg-white p-6 rounded-md border-8 border-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600 font-extrabold rounded-full cursor-not-allowed">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <div>
                    <h1 class="font-extrabold text-2xl p-2 text-black text-center">Atención</h1>
                    <p class="uppercase {{$classesSpan}} text-center">Vas a exportar {{$this->totalPropuestasNoEnviadas}} propuestas</p>
                    <p>Si confirmas las mismas van cambiar su estado a
                        <span class="{{$classesSpan}} uppercase">Enviado</span>
                    </p>
                    <div class="p-2 flex justify-center gap-2">
                        <button class="p-2 w-full justify-center bg-green-700 hover:bg-green-800 text-white"
                            wire:click="confirmarExportarPropuestas">
                                Confirmar
                        </button>
                        <button class="p-2 w-full justify-center bg-red-600 hover:bg-red-800 text-white"
                            wire:click="cancelarExportarPropuestas">
                                Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

