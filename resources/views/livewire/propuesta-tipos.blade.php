<div class="border bg-white rounded p-1">
    
    <!--Classes-->
    @php
        $classesSpan = "font-bold text-black";
        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded uppercase";
    @endphp

    <h2 class="{{$classesTitulo}}">Nueva gestión:</h2>
    @if(!$ultimaPropuesta ||
        $ultimaPropuesta->estado == 'Negociación' ||
        $ultimaPropuesta->estado == 'Incobrable' ||
        $ultimaPropuesta->estado == 'Rechazada' )

        <!--Operacion con politicas-->
        @if(auth()->user()->rol === 'Agente')
            <div class="p-1 text-center mt-2 border text-sm">
                <h2 class="border-b p-2 bg-blue-100 uppercase">La gestión debe respetar las siguientes politicas:</h2>
                <div class="flex justify-center gap-4 p-2 font-bold mt-2">
                    <p>Límite de Quita: {{$limiteQuita}}%</p>
                    <p>Límite de Cuotas: {{$limiteCuotas}} cuotas</p>
                    <p>Límite de Quita con dto: {{$limiteQuitaConDescuento}}%</p>
                    <p>Límite de Cuotas con dto: {{$limiteCuotasQuitaConDescuento}} cuotas</p>
                </div>
                
                <!--Producto con cuotas variables-->
                @if($operacion->productoId->acepta_cuotas_variables == 1)
                    <div class="flex justify-center gap-2 p-1">
                        <div class="flex-1">
                            <livewire:propuesta-para-cancelacion
                                :operacion="$operacion" 
                                :limiteQuita="$limiteQuita"
                            />
                        </div>
                        <div class="flex-1">
                            <livewire:propuesta-para-cuotas
                                :operacion="$operacion" 
                                :limiteCuotas="$limiteCuotas"
                            />
                        </div>
                        <div class="flex-1">
                            <livewire:propuesta-para-cancelacion-con-descuento
                                :operacion="$operacion" 
                                :limiteQuitaConDescuento="$limiteQuitaConDescuento"
                                :limiteCuotasQuitaConDescuento="$limiteCuotasQuitaConDescuento"
                            />
                        </div>
                        <div class="flex-1">
                            <livewire:propuesta-para-cuotas-variables
                                :operacion="$operacion"
                                :limiteCuotas="$limiteCuotas"
                            />
                        </div>
                    </div>
                <!--Producto sin cuotas variables-->
                @else
                    <div class="flex justify-center gap-2 p-2">
                        <div class="flex-1">
                            <livewire:propuesta-para-cancelacion
                                :operacion="$operacion" 
                                :limiteQuita="$limiteQuita"
                            />
                        </div>
                        <div class="flex-1">
                            <livewire:propuesta-para-cuotas
                                :operacion="$operacion" 
                                :limiteCuotas="$limiteCuotas"
                            />
                        </div>
                        <div class="flex-1">
                            <livewire:propuesta-para-cancelacion-con-descuento
                                :operacion="$operacion" 
                                :limiteQuitaConDescuento="$limiteQuitaConDescuento"
                                :limiteCuotasQuitaConDescuento="$limiteCuotasQuitaConDescuento"
                            />
                        </div>
                    </div>
                @endif
            </div>

        <!--Operacion sin politicas-->
        @else
            <div class="p-2 text-center mt-2 border ">
                <h2 class="border-b p-2 bg-blue-100 uppercase">Gestión exclusiva para usuarios administradores</h2>
            </div>
            <!--Producto con cuotas variables-->
            @if($operacion->productoId->acepta_cuotas_variables == 1)
                <div class="flex justify-center gap-2 p-1">
                    <div class="flex-1">
                        <livewire:propuesta-para-cancelacion-sin-politica
                            :operacion="$operacion" 
                        />
                    </div>
                    <div class="flex-1">
                        <livewire:propuesta-para-cuotas-sin-politica
                            :operacion="$operacion" 
                        />
                    </div>
                    <div class="flex-1">
                        <livewire:propuesta-para-cancelacion-con-descuento-sin-politicas
                            :operacion="$operacion" 
                        />
                    </div>
                    <div class="flex-1">
                        <livewire:propuesta-para-cuotas-variables-sin-politicas
                            :operacion="$operacion" 
                        />
                    </div>
                </div>
            <!--Producto sin cuotas variables-->
            @else
                <div class="flex justify-center gap-2 p-2">
                    <div class="flex-1">
                        <livewire:propuesta-para-cancelacion-sin-politica
                            :operacion="$operacion" 
                        />
                    </div>
                    <div class="flex-1">
                        <livewire:propuesta-para-cuotas-sin-politica
                            :operacion="$operacion" 
                        />
                    </div>
                    <div class="flex-1">
                        <livewire:propuesta-para-cancelacion-con-descuento-sin-politicas
                            :operacion="$operacion" 
                        />
                    </div>
                </div>
            @endif
        @endif
    @elseif($ultimaPropuesta->estado == 'Enviado' ||
        $ultimaPropuesta->estado == 'Propuesta de Pago' ||
        $ultimaPropuesta->estado == 'Acuerdo de Pago')
        <div class="text-center p-4 mt-4">
            <span class="{{$classesSpan}}">La operación tiene una acción en curso de una gestión anterior</span>
        </div>
    @endif
</div> 