@php
    $classesBtn ="text-white py-2 rounded text-sm";
@endphp
<div class="border p-1 mb-4">
    <livewire:cuotas.buscador-cuotas :contexto="3">
    @if(auth()->user()->rol === 'Administrador')
        <div class="mb-2 grid grid-cols-2 md:grid-cols-4 lg:flex gap-1 p-1">
            <!--botones de navegacion-->
            <button class="text-white bg-blue-800 rounded text-sm py-2 px-4"
                    wire:click="exportarPagosAplicados">
                Exp. Pagos
            </button>
            <button class="text-white  bg-green-600 rounded text-sm py-2 px-4"
                    wire:click="importarRendicionDePagos">
                Imp. Rend.
            </button> 
        </div>
    @endif
    @if($cuotasAplicadas->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($cuotasAplicadas as $cuotaAplicada)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 450px">
                    <p class="bg-indigo-600 mb-1 text-white uppercase py-1 text-center block">
                        {{$cuotaAplicada->acuerdo->propuesta->deudorId->nombre}}
                    </p>
                    <x-detalle-cuota
                        :cuotaActual="$cuotaAplicada"
                        :cuotaId="$cuotaAplicada->id"
                        :cliente="$cuotaAplicada->acuerdo->propuesta->operacionId->clienteId->nombre"
                        :dniDeudor="$cuotaAplicada->acuerdo->propuesta->deudorId->nro_doc"
                        :cuilDeudor="$cuotaAplicada->acuerdo->propuesta->deudorId->cuil"
                        :operacion="$cuotaAplicada->acuerdo->propuesta->operacionId->operacion"
                        :segmento="$cuotaAplicada->acuerdo->propuesta->operacionId->segmento"
                        :producto="$cuotaAplicada->acuerdo->propuesta->operacionId->productoId->nombre"
                        :responsable="$cuotaAplicada->acuerdo->propuesta->operacionId->usuarioAsignado->name . ' ' . $cuotaAplicada->acuerdo->propuesta->operacionId->usuarioAsignado->apellido"
                        :montoAcordado="$cuotaAplicada->monto_acordado"
                        :vencimientoCta="$cuotaAplicada->vencimiento_cuota"
                        :nroCuota="$cuotaAplicada->nro_cuota"
                        :conceptoCuota="$cuotaAplicada->concepto_cuota"
                    />
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay cuotas aplicadas
        </p>
    @endif
    @if($cuotasAplicadasTotales >= 30)
        <div class="p-2">
            {{$cuotasAplicadas->links('')}}
        </div>
    @endif
    <!--Modal Exportar pagos aplicados-->
    @if($modalExportarPagosAplicados)
        <x-modal-estado >
            <!--Contenedor Parrafos-->
            <div class="text-sm">
                <p>
                    Selecciona el segmento a rendir.
                </p>
            </div>
            <form class="w-full text-sm" wire:submit.prevent='descargarPagosParaRendir'>
                <!-- Seleccionar segmento -->
                <div>
                    <x-input-label for="segmento" :value="__('Segmento')" />
                    <select
                        id="segmento"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="segmento"
                    >
                        <option value="">Seleccionar</option>
                        <option value="Retail">Retail</option>
                        <option value="National">National</option>
                        <option value="Mutual">Mutual</option>
                        <option value="Campaña Retail">Campaña Retail</option>
                        <option value="Campaña National">Campaña National</option>
                        <option value="Campaña Mutual">Campaña Mutual</option>
                    </select>
                    <x-input-error :messages="$errors->get('segmento')" class="mt-2" />
                </div>
                <div class="grid grid-cols-2 gap-1">
                    <button class="{{$classesBtn}} w-full mt-2 bg-green-600 hover:bg-green-700">
                        Descargar
                    </button>
                    <button class="{{$classesBtn}} w-full mt-2 bg-red-600 hover:bg-red-700"
                            wire:click.prevent="cerrarModalExportarPagos">
                        Cerrar
                    </button>
                </div>
            </form>
        </x-modal-estado>
    @endif
    <!--Modal Exportar pagos aplicados-->
    @if($modalNoHayPagos)
        <x-modal-estado >
            <!--Contenedor Parrafos-->
            <div class="text-sm">
                <p>
                    No hay pagos Aplicados para el segmento elegido.
                </p>
            </div>
            <div class="w-full grid grid-cols-1">
                <button type="button" class="{{$classesBtn}} mt-2  bg-red-600 hover:bg-red-700"
                        wire:click="cerrarModalNoHayPagos">
                    Volver
                </button>
            </div>
        </x-modal-estado>
    @endif
    <!--Modal importar pagos rendidos-->
    @if($modalImportarPagosRendidos)
        <x-modal-estado >
            <!--Contenedor Parrafos-->
            <div class="text-sm">
                <p>
                    Ingresa la información requerida para la Rendición.
                </p>
            </div>
            <form class="w-full text-sm"
                enctype="multipart/form-data"
                wire:submit.prevent='importarPagosRendidos'>
                <!-- Numero de Rendicion -->
                <div class="mt-2">
                    <x-input-label for="rendicionCG" :value="__('Número de Rendición')" />
                    <x-text-input
                        id="rendicionCG"
                        class="block mt-1 w-full"
                        placeholder="Ingresar número de rendición"
                        type="text"
                        wire:model="rendicionCG"
                        :value="old('rendicionCG')"
                    />
                    <x-input-error :messages="$errors->get('rendicionCG')" class="mt-2" />
                </div>
                <!-- Numero de Proforma -->
                <div class="mt-1">
                    <x-input-label for="proforma" :value="__('Número de Proforma')" />
                    <x-text-input
                        id="proforma"
                        class="block mt-1 w-full"
                        placeholder="Ingresar número de Proforma"
                        type="text"
                        wire:model="proforma"
                        :value="old('proforma')"
                    />
                    <x-input-error :messages="$errors->get('proforma')" class="mt-2" />
                </div>
                <!-- Fecha de Rendicion -->
                <div class="mt-1">
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
                <!--Archivo a subir-->
                <div class="mt-1">
                    <x-input-label for="archivoSubido" :value="__('Archivo')" />
                    <x-text-input
                        id="archivoSubido"
                        placeholder="Seleccionar archivo excel"
                        class="block mt-1 w-full border p-1.5"
                        type="file"
                        wire:model="archivoSubido"
                        accept=".xls, .xlsx"
                        />
                    <x-input-error :messages="$errors->get('archivoSubido')" class="mt-2" />
                </div>
                <div class="grid grid-cols-2 gap-1">
                    <button class="{{$classesBtn}} w-full mt-2 bg-green-600 hover:bg-green-700">
                        Importar
                    </button>
                    <button class="{{$classesBtn}} w-full mt-2 bg-red-600 hover:bg-red-700"
                            wire:click.prevent="cerrarModalImportarPagosRendidos">
                        Cerrar
                    </button>
                </div>
            </form>
        </x-modal-estado>
    @endif
    <!--modal importando-->
    @if($modalImportando)
        <x-modal-estado>
            <div class="max-w-1/2 mx-auto text-sm">
                <!--Contenedor Parrafos-->
                <p class="px-1 text-center">
                    Realizando la Importanción.
                </p>
                <p class="px-1 text-center">
                    Aguarde unos instantes hasta que finalice.
                </p>
            </div>
        </x-modal-estado>
    @endif
</div>
