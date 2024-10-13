@php
    $classesBtn ="text-white py-2 rounded text-sm";
    if(auth()->user()->rol === 'Administrador')
        {
            $texto = 'Aplicar/Observar un pago';
        } else {
            $texto = 'Informar un pago';
        }
@endphp
<div>
    @if(session('imprimirAlertaExito'))
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-sm text-green-800 font-bold mt-3">
            <p>Gestion generada correctamente</p>
        </div>
    @elseif(session('imprimirAlertaEliminacion'))
        <div class="px-2 py-1 bg-red-100 border-l-4 border-red-600 text-red-800 text-sm font-bold mt-3">
            <p>Gestion eliminada correctamente</p>
        </div>
    @endif
    <x-deudor-gestion-cuota :cuota="$cuota"/>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-1">
        <div class="col-span-2">
            <x-detalle-gestion-cuota
                :cuota="$cuota"
            />
            <div class="p-1 border mt-2 lg:mt-0">
                <x-subtitulo-h-cuatro>
                    {{$texto}}
                </x-subtitulo-h-cuatro>
                @if(auth()->user()->rol === 'Administrador')
                    @if($mostrarFormulario)
                        <livewire:gestiones.cuota.formulario-gestion-cuota :cuota="$cuota" :classesBtn="$classesBtn"/>
                    @else
                        <p class="font-bold text-center pt-3">
                            No se puede aplicar nuevo pago (cuota con gestión de pago previa)
                        </p>
                    @endif
                @else
                    <livewire:gestiones.cuota.formulario-gestion-cuota :cuota="$cuota" :classesBtn="$classesBtn"/>   
                @endif
            </div>
        </div>
        <div class="grid-cols-1 gap-1 lg:mt-2 border p-3">
            <x-subtitulo-h-cuatro>
                Gestiones de Pago
            </x-subtitulo-h-cuatro>
            @if($botonProcesarPagosIncompletos && auth()->user()->rol === 'Administrador')
                <button type="button" class="{{$classesBtn}} mt-1 px-4 bg-blue-800 hover:bg-blue-900"
                        wire:click="modalProcesarPagosIncompletos">
                    Procesar
                </button>
            @endif
            @if($botonDevolverPagoAplicadoEnCuotaSaldoExcedente && auth()->user()->rol === 'Administrador')
                <button type="button" class="{{$classesBtn}} mt-1 px-4 bg-gray-600 hover:bg-gray-700"
                        wire:click="modalDevolverPagoAplicadoEnCuotaSaldoExcedente">
                    Devolver
                </button>
            @endif
            @if($pagosDeCuota->count())
                @foreach($pagosDeCuota as $index => $pagoDeCuota)
                    <div class="p-2 border border-gray-300 my-1 lg:my-1 {{ $index % 2 == 0 ? 'bg-blue-100' : 'bg-white' }}">    
                        <x-pago-de-cuota :pagoDeCuota="$pagoDeCuota"/>
                    </div>
                    <!--Modal boton actualizar Pago Informado-->
                    @if(isset($actualizarPagoInformado[$pagoDeCuota->id]) && $actualizarPagoInformado[$pagoDeCuota->id])
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <!--Contenedor Parrafos-->
                            <div class="text-xs">
                                <p>
                                    Se podrá editar fecha de pago, monto abonado y situación.
                                </p>
                                <p>
                                    Para más opciones, eliminá el informe y creá uno nuevo.
                                </p>
                            </div>
                            <form class="w-full text-sm"
                                    wire:submit.prevent='actualizarPagoInformado({{$pagoDeCuota->id}})'>
                                <!-- Fecha de Pago -->
                                <div class="mt-1">
                                    <x-input-label for="fecha_de_pago_formulario" :value="__('Fecha de Pago')" />
                                    <x-text-input
                                        id="fecha_de_pago_formulario"
                                        class="block mt-1 w-full"
                                        type="date"
                                        wire:model="fecha_de_pago_formulario"
                                        :value="old('fecha_de_pago_formulario')"
                                        :max="now()->format('Y-m-d')"
                                    />
                                    <x-input-error :messages="$errors->get('fecha_de_pago_formulario')" class="mt-2" />
                                </div>
                                <!-- Monto -->
                                <div class="mt-1">
                                    <x-input-label for="monto_abonado_formulario" :value="__('Monto Abonado')" />
                                    <x-text-input
                                        id="monto_abonado_formulario"
                                        placeholder="Monto abonado"
                                        class="block mt-1 w-full"
                                        type="text"
                                        wire:model="monto_abonado_formulario"
                                        :value="old('monto_abonado_formulario')"
                                    />
                                    <x-input-error :messages="$errors->get('monto_abonado_formulario')" class="mt-2" />
                                </div>
                                @if((auth()->user()->rol == 'Administrador'))
                                    <!-- Situacion -->
                                    <div class="mt-2">
                                        <x-input-label for="situacion_formulario" :value="__('Situación')" />
                                        <select
                                            id="situacion_formulario"
                                            class="block mt-1 w-full rounded-md border-gray-300"
                                            wire:model="situacion_formulario"
                                        >
                                            <option value="">Seleccionar</option>
                                            <option value="1">Informado</option>
                                            <option value="2">Rechazado</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('situacion_formulario')" class="mt-2" />
                                    </div>
                                @endif
                                <div class="grid grid-cols-2 gap-1">
                                    <button class="{{$classesBtn}} w-full mt-2 bg-red-600 hover:bg-red-700"
                                            wire:click.prevent="cerrarModalPagoInformadoActualizar({{$pagoDeCuota->id}})">
                                        Cerrar
                                    </button>
                                    <button class="{{$classesBtn}} w-full mt-2 bg-green-600 hover:bg-green-700">
                                        Actualizar
                                    </button>
                                </div>
                            </form>
                        </x-modal-estado>
                    @endif
                    <!--Modal boton aplicar Pago Informado-->
                    @if(isset($aplicarPagoInformado[$pagoDeCuota->id]) && $aplicarPagoInformado[$pagoDeCuota->id])
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$this->mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$this->mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás el procedimiento?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid grid-cols-2 gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="aplicarPagoInformado({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalPagoInformadoAplicar({{$pagoDeCuota->id}})">
                                    Cancelar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal boton aplicar Pago Informado con incompletos-->
                    @if(isset($aplicarPagoInformadoConIncompletos[$pagoDeCuota->id]) && $aplicarPagoInformadoConIncompletos[$pagoDeCuota->id])
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$this->mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$this->mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás el procedimiento?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid grid-cols-2 gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="aplicarPagoInformadoConIncompletos({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalAplicarPagoInformadoConIncompletos({{$pagoDeCuota->id}})">
                                    Cancelar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal boton eliminar Pago Informado-->
                    @if(isset($eliminarPagoInformado[$pagoDeCuota->id]) && $eliminarPagoInformado[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    El Pago Informado se eliminará.
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la eliminación?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid grid-cols-2 gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="eliminarPagoInformado({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalPagoInformadoEliminar({{$pagoDeCuota->id}})">
                                    Cancelar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal boton Reversar Pago Rechazado-->
                    @if(isset($reversarPagoRechazado[$pagoDeCuota->id]) && $reversarPagoRechazado[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid grid-cols-2 gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="reversarPagoRechazado({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalPagoRechazadoReversar({{$pagoDeCuota->id}})">
                                    Cancelar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal boton Reversar Pago Incompleto-->
                    @if(isset($reversarPagoIncompleto[$pagoDeCuota->id]) && $reversarPagoIncompleto[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid grid-cols-2 gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="reversarPagoIncompleto({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalPagoIncompletoReversar({{$pagoDeCuota->id}})">
                                    Cancelar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal boton Reversar Pago Aplicado-->
                    @if(isset($reversarPagoAplicado[$pagoDeCuota->id]) && $reversarPagoAplicado[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid grid-cols-2 gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="reversarPagoAplicado({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalPagoAplicadoReversar({{$pagoDeCuota->id}})">
                                    Cancelar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal boton confirmar cuotas aplicadas siguientes-->
                    @if(isset($cuotasSiguientesAplicadas[$pagoDeCuota->id]) && $cuotasSiguientesAplicadas[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid grid-cols-2 gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="reversarPagoAplicadoYReversarCuotasSiguientes({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalPagoAplicadoConCuotasSiguientesAplicadas({{$pagoDeCuota->id}})">
                                    Cancelar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal revesar Pago Rendido-->
                    @if(isset($modalReversarPagoRendido[$pagoDeCuota->id]) && $modalReversarPagoRendido[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                @if($contexto != 1 || $contexto !=8)
                                    <p class="px-1 text-center">
                                        {{$mensajeModalTres}}
                                    </p>
                                @endif
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid {{ $this->contexto == 1 ? 'grid-cols-1' : 'grid-cols-2' }} gap-1">
                                @if($this->contexto != 1)
                                    <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                            wire:click="reversarPagoRendido({{$pagoDeCuota->id}}, {{$contexto}})">
                                        Confirmar
                                    </button>
                                @endif
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalReversarPagoRendido({{$pagoDeCuota->id}})">
                                    Cerrar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal revesar Pago Para Rendir-->
                    @if(isset($modalReversarPagoParaRendir[$pagoDeCuota->id]) && $modalReversarPagoParaRendir[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalTres}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid {{ $this->contexto == 1 ? 'grid-cols-1' : 'grid-cols-2' }} gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="reversarPagoParaRendir({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalReversarPagoParaRendir">
                                    Cerrar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal revesar Pago Para Rendir-->
                    @if(isset($modalReversarPagoRendidoACuenta[$pagoDeCuota->id]) && $modalReversarPagoRendidoACuenta[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalTres}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid {{ $this->contexto == 1 ? 'grid-cols-1' : 'grid-cols-2' }} gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="reversarPagoRendidoACuenta({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalReversarPagoRendidoACuenta">
                                    Cerrar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                    <!--Modal revesar Pago Devuelto-->
                    @if(isset($modalReversarPagoDevuelto[$pagoDeCuota->id]) && $modalReversarPagoDevuelto[$pagoDeCuota->id]) 
                        <!--Modal cambiar confirmar monto superior-->
                        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
                            <div class="max-w-1/2 mx-auto text-sm">
                                <!--Contenedor Parrafos-->
                                <p class="px-1 text-center">
                                    {{$mensajeModalUno}}
                                </p>
                                <p class="px-1 text-center">
                                    {{$mensajeModalDos}}
                                </p>
                                <p class="px-1 text-center">
                                    Confirmás la acción?
                                </p>
                            </div>
                            <!--Contenedor Botones-->
                            <div class="w-full grid {{ $this->contexto == 1 ? 'grid-cols-1' : 'grid-cols-2' }} gap-1">
                                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                                        wire:click="reversarPagoDevuelto({{$pagoDeCuota->id}})">
                                    Confirmar
                                </button>
                                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                                        wire:click="cerrarModalReversarPagoDevuelto">
                                    Cerrar
                                </button>
                            </div>
                        </x-modal-estado>
                    @endif
                @endforeach
            @else
                <p class="font-bold text-center pt-3">
                    La cuota no tiene gestiones
                </p>
            @endif 
        </div>
    </div>
    @if($modalProcesarPagosIncompletos)
        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
            <div class="max-w-1/2 mx-auto text-sm">
                <!--Contenedor Parrafos-->
                <p class="px-1 text-center">
                    {{$this->mensajeModalUno}}
                </p>
                <p class="px-1 text-center">
                    {{$this->mensajeModalDos}}
                </p>
                <p class="px-1 text-center">
                    Confirmás el procedimiento?
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="procesarPagosIncompletos">
                    Confirmar
                </button>
                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalProcesarPagosIncompletos">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
    @if($modalDevolverPagoAplicadoEnCuotaSaldoExcedente)
        <x-modal-estado wire:key="modal-estado-{{ $pagoDeCuota->id }}" id="modal-actualizar-{{ $pagoDeCuota->id }}">
            <div class="max-w-1/2 mx-auto text-sm">
                <!--Contenedor Parrafos-->
                <p class="px-1 text-center">
                    {{$this->mensajeModalUno}}
                </p>
                <p class="px-1 text-center">
                    {{$this->mensajeModalDos}}
                </p>
                <p class="px-1 text-center">
                    Confirmás el procedimiento?
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button type="button" class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="devolverPagoAplicadoEnCuotaSaldoExcedente">
                    Confirmar
                </button>
                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalDevolverPagoAplicadoEnCuotaSaldoExcedente">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
</div>

