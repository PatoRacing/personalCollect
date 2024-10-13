<div class="p-1">
    @php
        $classesBtn ="text-white p-2 rounded text-sm"
    @endphp
    <x-subtitulo>
        Listado de Gestiones
    </x-subtitulo>
    <!--Alertas-->
    @if($alertaMensaje)
        @if(auth()->user() && auth()->user()->rol == 'Administrador')
            <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold my-1">
                <p>Pago Aplicado correctamente</p>
            </div>
        @else
            <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold my-1">
                <p>Pago Informado correctamente</p>
            </div>
        @endif
    @endif
    @if($alertaActualizado)
        <div class="px-2 py-1 bg-blue-100 border-l-4 border-blue-600 text-blue-800 text-sm font-bold my-1">
            <p>Pago Actualizado correctamente</p>
        </div>
    @endif
    @if($alertaEstadoActualizado)
        <div class="px-2 py-1 bg-blue-100 border-l-4 border-blue-600 text-blue-800 text-sm font-bold my-1">
            <p>Estado Actualizado correctamente</p>
        </div>
    @endif
    @if($alertaGestionEliminada)
        <div class="px-2 py-1 bg-red-100 border-l-4 border-red-600 text-red-800 text-sm font-bold my-1">
            <p>Gestión Eliminada Correctamente</p>
        </div>
    @endif
    <!--listado de informes-->
    @if($gestionesCuota->count())
        <div class="grid md:grid-cols-2 md:gap-2 lg:gap-0 lg:grid-cols-1 overflow-y-auto" style="max-height: 650px;">
            @foreach($gestionesCuota as $index => $gestionCuota)
                <div class="p-2 border border-gray-700 my-1 lg:my-1 {{ $index % 2 == 0 ? 'bg-blue-100' : 'bg-white' }}">
                    @if($gestionCuota->situacion == 1)
                        <h4 class="bg-cyan-600 text-white font-bold py-1 text-center mb-1">
                            Pago Informado
                        </h4>
                    @elseif($gestionCuota->situacion == 2)
                        <h4 class="bg-orange-500 text-white font-bold py-1 text-center mb-1">
                            Pago Aplicado
                        </h4>
                    @elseif($gestionCuota->situacion == 3)
                        <h4 class="bg-green-600 text-white font-bold py-1 text-center mb-1">
                            Pago Rendido
                        </h4>
                    @elseif($gestionCuota->situacion == 4)
                        <h4 class="bg-red-600 text-white font-bold py-1 text-center mb-1">
                            Pago Observado
                        </h4>
                    @elseif($gestionCuota->situacion == 5)
                        <h4 class="bg-gray-700 text-white font-bold py-1 text-center mb-1">
                            Pago Rechazado
                        </h4>
                    @endif
                    <p>Gestión ID:
                        <span class="font-bold">
                            {{$gestionCuota->id }}
                        </span>
                    </p>
                    @if($gestionCuota->fecha_de_pago)
                        <p>Fecha de Pago:
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($gestionCuota->fecha_de_pago)->format('d/m/Y') }}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->monto_a_rendir)
                        <p>Monto Rendido:
                            <span class="font-bold">
                                ${{ number_format($gestionCuota->monto_abonado, 2, ',', '.') }}
                            </span>
                        </p>
                    @else
                        <p>Monto Abonado:
                            <span class="font-bold">
                                ${{ number_format($gestionCuota->monto_abonado, 2, ',', '.') }}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->medio_de_pago)
                        <p>Medio de Pago:
                            <span class="font-bold">
                                {{$gestionCuota->medio_de_pago}}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->sucursal)
                        <p>Sucursal:
                            <span class="font-bold">
                                {{$gestionCuota->sucursal}}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->hora)
                        <p>Hora:
                            <span class="font-bold">
                                {{$gestionCuota->hora}}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->cuenta)
                        <p>Cuenta:
                            <span class="font-bold">
                                {{$gestionCuota->cuenta}}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->nombre_tercero)
                        <p>Titular Cuenta:
                            <span class="font-bold">
                                {{$gestionCuota->nombre_tercero}}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->central_de_pago)
                        <p>Central de Pago:
                            <span class="font-bold">
                                {{$gestionCuota->central_de_pago}}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->comprobante)
                        <p>Comprobante:
                            <a href="{{ Storage::url('comprobantes/' . $gestionCuota->comprobante) }}"
                                class="text-blue-800 font-bold"
                                target="_blank">
                                Ver
                            </a>
                        </p>
                    @endif
                    <p>Informado por:
                        <span class="font-bold">
                            {{$gestionCuota->usuarioInformador->name}}
                            {{$gestionCuota->usuarioInformador->apellido}}
                        </span>
                    </p>
                    <p>Fecha Informe:
                        <span class="font-bold">
                            {{ \Carbon\Carbon::parse($gestionCuota->fecha_informe)->format('d/m/Y') }}
                        </span>
                    </p>
                    @if($gestionCuota->proforma)
                        <p>Proforma y Rendicion CG:
                            <span class="font-bold">
                                {{$gestionCuota->proforma}}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->fecha_rendicion)
                        <p>Fecha de Rendición:
                            <span class="font-bold">
                                {{ \Carbon\Carbon::parse($gestionCuota->fecha_rendicion)->format('d/m/Y') }}
                            </span>
                        </p>
                    @endif
                    @if($gestionCuota->usuario_rendidor_id)
                        <p>Rendido por:
                            <span class="font-bold">
                                {{$gestionCuota->usuarioInformador->name}}
                                {{$gestionCuota->usuarioInformador->apellido}}
                            </span>
                        </p>
                    @endif
                    <p>Ult. Modif:
                        <span class="font-bold">
                            {{$gestionCuota->usuarioUltimaModificacion->name}}
                            {{$gestionCuota->usuarioUltimaModificacion->apellido}}
                        </span>
                    </p>
                    <p>Fecha Ult. Modif:
                        <span class="font-bold">
                            {{ \Carbon\Carbon::parse($gestionCuota->updated_at)->format('d/m/Y') }}
                        </span>
                    </p>
                    @if($gestionCuota->situacion == 1)
                        @if(auth()->user()->rol == 'Administrador')
                            <div class="grid grid-cols-1 md:grid-cols-3 justify-center gap-1 mt-2">
                                <button class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900"
                                        wire:click="mostrarModalActualizarGestion({{ $gestionCuota->id }})">
                                    Actualizar
                                </button>
                                <button class="{{$classesBtn}} bg-gray-600 hover:bg-gray-700"
                                            wire:click="mostrarModalCambiarEstado({{ $gestionCuota->id }})">
                                    Sin Aplicar
                                </button>
                                
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                        wire:click="mostrarModalEliminarGestion({{ $gestionCuota->id }})">
                                    Eliminar
                                </button>         
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 justify-center gap-1 mt-2">
                                <button class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900"
                                        wire:click="mostrarModalActualizarGestion({{ $gestionCuota->id }})">
                                    Actualizar
                                </button>
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                        wire:click="mostrarModalEliminarGestion({{ $gestionCuota->id }})">
                                    Eliminar
                                </button>         
                            </div>
                        @endif
                    @elseif($gestionCuota->situacion == 2)
                        <div class="grid grid-cols-1 md:grid-cols-2 justify-center gap-1 mt-2">
                            <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                                    wire:click="mostrarModalCambiarEstado({{ $gestionCuota->id }})">
                                Aplicado
                            </button>
                            <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                    wire:click="mostrarModalEliminarGestion({{ $gestionCuota->id }})">
                                Eliminar
                            </button>         
                        </div>
                    @elseif($gestionCuota->situacion == 3)
                        <div class="grid grid-cols-1 md:grid-cols-2 justify-center gap-1 mt-2">
                            <button class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900"
                                    wire:click="mostrarModalActualizarRendicion({{ $gestionCuota->id }})">
                                Editar Rendición
                            </button>
                            <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                    wire:click="mostrarModalEliminarRendicion({{ $gestionCuota->id }})">
                                Eliminar Rendición
                            </button>         
                        </div>
                    @elseif($gestionCuota->situacion == 4)
                        <div class="grid grid-cols-1 md:grid-cols-2 justify-center gap-1 mt-2">
                            <button class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900"
                                    wire:click="mostrarModalActualizarGestion({{ $gestionCuota->id }})">
                                Actualizar
                            </button>
                            <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                    wire:click="mostrarModalEliminarGestion({{ $gestionCuota->id }})">
                                Eliminar
                            </button>         
                        </div>
                    @elseif($gestionCuota->situacion == 5)
                        @if(auth()->user()->rol == 'Administrador')
                            <div class="grid grid-cols-1 md:grid-cols-2 justify-center gap-1 mt-2">
                                <button class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900"
                                        wire:click="mostrarModalActualizarGestion({{ $gestionCuota->id }})">
                                    Actualizar
                                </button>
                                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                                        wire:click="mostrarModalEliminarGestion({{ $gestionCuota->id }})">
                                    Eliminar
                                </button>         
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            La cuota no tiene gestiones
        </p>
    @endif
    <!--Modal actualizar Gestion-->
    @if($modalActualizarGestion)
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <div class="text-xs">
                <p>
                    Se podrá editar fecha de pago, monto abonado y situación.
                </p>
                <p>
                    Para más opciones, eliminá el informe y creá uno nuevo.
                </p>
            </div>
            <form class="w-full text-sm" wire:submit.prevent='actualizarGestion'>
                <!-- Si el pago tiene situacion de informado (1) -->
                @if($gestionCuota->situacion == 1) 
                    <!-- Fecha de Pago -->
                    <div class="mt-1">
                        <x-input-label for="fecha_de_pago" :value="__('Fecha de Pago')" />
                        <x-text-input
                            id="fecha_de_pago"
                            class="block mt-1 w-full"
                            type="date"
                            wire:model="fecha_de_pago"
                            :value="old('fecha_de_pago')"
                            :max="now()->format('Y-m-d')"
                        />
                        <x-input-error :messages="$errors->get('fecha_de_pago')" class="mt-2" />
                    </div>
                    <!-- Monto -->
                    <div class="mt-1">
                        <x-input-label for="monto_abonado" :value="__('Monto Abonado')" />
                        <x-text-input
                            id="monto_abonado"
                            placeholder="Monto abonado"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="monto_abonado"
                            :value="old('monto_abonado')"
                        />
                        <x-input-error :messages="$errors->get('monto_abonado')" class="mt-2" />
                    </div>
                    @if((auth()->user()->rol == 'Administrador'))
                        <!-- Situacion -->
                        <div class="mt-2">
                            <x-input-label for="situacion" :value="__('Situación')" />
                            <select
                                id="situacion"
                                class="block mt-1 w-full rounded-md border-gray-300"
                                wire:model="situacion"
                            >
                                <option value="">Seleccionar</option>
                                <option value="1">Informado</option>
                                <option value="5">Rechazado</option>
                            </select>
                            <x-input-error :messages="$errors->get('situacion')" class="mt-2" />
                        </div>
                    @endif
                <!-- Si el pago tiene situacion de rechazado (5) -->
                @else
                    <!-- Fecha de Pago -->
                    <div class="mt-1">
                        <x-input-label for="fecha_de_pago" :value="__('Fecha de Pago')" />
                        <x-text-input
                            id="fecha_de_pago"
                            class="block mt-1 w-full bg-gray-200"
                            type="date"
                            wire:model="fecha_de_pago"
                            :value="old('fecha_de_pago')"
                            :max="now()->format('Y-m-d')"
                            readonly
                        />
                        <x-input-error :messages="$errors->get('fecha_de_pago')" class="mt-2" />
                    </div>
                    <!-- Monto -->
                    <div class="mt-1">
                        <x-input-label for="monto_abonado" :value="__('Monto Abonado')" />
                        <x-text-input
                            id="monto_abonado"
                            placeholder="Monto abonado"
                            class="block mt-1 w-full bg-gray-200"
                            type="text"
                            wire:model="monto_abonado"
                            :value="old('monto_abonado')"
                            readonly
                        />
                        <x-input-error :messages="$errors->get('monto_abonado')" class="mt-2" />
                    </div>
                    <!-- Situacion -->
                    <div class="mt-2">
                        <x-input-label for="situacion" :value="__('Situación')" />
                        <select
                            id="situacion"
                            class="block mt-1 w-full rounded-md border-gray-300"
                            wire:model="situacion"
                        >
                            <option value="">Seleccionar</option>
                            <option value="1">Informado</option>
                            <option value="5">Rechazado</option>
                        </select>
                        <x-input-error :messages="$errors->get('situacion')" class="mt-2" />
                    </div>
                @endif
                <!--botones-->
                <div class="grid grid-cols-2 gap-1">
                    <button class="{{$classesBtn}} w-full mt-2 bg-red-600 hover:bg-red-700" wire:click.prevent="cerrarModalActualizarGestion">
                        Cerrar
                    </button>
                    <button class="{{$classesBtn}} w-full mt-2 bg-green-600 hover:bg-green-700">
                        Actualizar
                    </button>
                </div>
            </form>
        </x-modal-estado>
    @endif
    <!--Modal cambiar estado (informado o aplicado)-->
    @if($modalActualizarEstado)
        <x-modal-estado>
            <div>
                <!--Contenedor Parrafos-->
                <p class="px-1">
                    Confirmar aplicar el Informe de Pago
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="confirmarCambiarEstado({{ $gestionCuotaSeleccionada->id }})">
                    Actualizar
                </button>
                <button class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalActualizarEstado">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
    <!--Modal eliminar gestion (informado o aplicado)-->
    @if($modalElimminarGestion)
        <x-modal-estado>
            <div>
                <!--Contenedor Parrafos-->
                <p class="px-1">
                    Confirmar eliminar el Informe de Pago
                    <span class="font-bold">
                        ID: {{$gestionCuotaSeleccionada->id}}
                    </span>
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="confirmarEliminarGestion({{ $gestionCuotaSeleccionada->id }})">
                    Eliminar
                </button>
                <button class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalEliminarGestion">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
    <!--Modal actualizar rendicion-->
    @if($modalActualizarRendicion)
        <x-modal-estado>
            <div>
                <!--Contenedor Parrafos-->
                <div class="text-xs">
                    <p>
                        Solo se podrá editar la rendicion CG y la fecha de rendición.
                    </p>
                    <p>
                        Para más opciones eliminá la rendición y crea una nueva.
                    </p>
                </div>
            </div>
            <form wire:submit.prevent='actualizarRendicionRendida' class="p-1 overflow-y-auto" style="max-height: 210px">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 my-1">
                    <!-- Gestion ID -->
                    <div>
                        <x-input-label for="gestion_id" :value="__('Rendicion ID:')" />
                        <x-text-input
                            id="gestion_id"
                            placeholder="Id del Pago Aplicado"
                            class="block mt-1 w-full bg-gray-200"
                            type="number"
                            wire:model="gestion_id"
                            :value="old('gestion_id')"
                            readonly
                            />
                        <x-input-error :messages="$errors->get('gestion_id')" class="mt-2" />
                    </div>
                    <!-- Monto a Rendir -->
                    <div>
                        <x-input-label for="monto_a_rendir" :value="__('Monto Rendido')" />
                        <x-text-input
                            id="monto_a_rendir"
                            placeholder="Monto a Rendir"
                            class="block mt-1 w-full bg-gray-200"
                            type="text"
                            wire:model="monto_a_rendir"
                            :value="old('monto_a_rendir')"
                            readonly
                            />
                        <x-input-error :messages="$errors->get('monto_a_rendir')" class="mt-2" />
                    </div>
                    <!-- Rendicion CG -->
                    <div>
                        <x-input-label for="proforma" :value="__('Rendicion CG')" />
                        <x-text-input
                            id="proforma"
                            placeholder="Proforma Y rendición CG"
                            class="block mt-1 w-full"
                            type="text"
                            wire:model="proforma"
                            :value="old('proforma')"
                            />
                        <x-input-error :messages="$errors->get('proforma')" class="mt-2" />
                    </div>
                    <!-- Fecha de Rendicion -->
                    <div>
                        <x-input-label for="fecha_rendicion" :value="__('Fecha de Rendición')" />
                        <x-text-input
                            id="fecha_rendicion"
                            class="block mt-1 w-full"
                            type="date"
                            wire:model="fecha_rendicion"
                            :value="old('fecha_rendicion')"
                            :max="now()->format('Y-m-d')"
                            />
                        <x-input-error :messages="$errors->get('fecha_rendicion')" class="mt-2" />
                    </div>
                </div>
                <!--botones-->
                <div class="grid grid-cols-2 gap-1">
                    <button class="{{$classesBtn}} w-full mt-2 bg-red-600 hover:bg-red-700" wire:click.prevent="cerrarModalActualizarRendicion">
                        Cerrar
                    </button>
                    <button class="{{$classesBtn}} w-full mt-2 bg-green-600 hover:bg-green-700">
                        Actualizar
                    </button>
                </div>
            </form>
        </x-modal-estado>
    @endif
    <!--Modal eliminar rendicion (de rendido a aplicado)-->
    @if($modalEliminarRendicion)
        <x-modal-estado>
            <div>
                <!--Contenedor Parrafos-->
                <p class="px-1">
                    Confirmar eliminar la rendición del Pago
                    <span class="font-bold">
                        ID: {{$gestionCuotaSeleccionada->id}}
                    </span>
                </p>
            </div>
            <!--Contenedor Botones-->
            <div class="w-full grid grid-cols-2 gap-1">
                <button class="{{$classesBtn}} mt-2  bg-green-600 hover:bg-green-700"
                        wire:click="confirmarEliminarRendicion({{ $gestionCuotaSeleccionada->id }})">
                    Eliminar
                </button>
                <button class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalEliminarRendicion">
                    Cancelar
                </button>
            </div>
        </x-modal-estado>
    @endif
</div>
