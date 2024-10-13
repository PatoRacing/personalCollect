<div class="mt-1">
    <div class="md:flex gap-1 mb-2 grid grid-cols-2">
        @php
            $classesBtnActivo = "text-white rounded text-sm py-2 px-4";
            $classesBtnInactivo = "rounded text-sm border shadow hover:bg-gray-100 py-2 px-4";
        @endphp
        <!--botones de navegacion-->
        @if($acuerdosVigentes)
            <button class="{{$classesBtnActivo}} bg-blue-800"
                    wire:click="mostrarAcuerdosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosEnProceso">
                En Proceso
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosFinalizados">
                Finalizados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosObservados">
                Observados
            </button>
        @elseif($acuerdosEnProceso)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnActivo}} bg-orange-500"
                    wire:click="mostrarAcuerdosEnProceso">
                En Proceso
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosFinalizados">
                Finalizados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosObservados">
                Observados
            </button>
        @elseif($acuerdosFinalizados)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosEnProceso">
                En Proceso
            </button>
            <button class="{{$classesBtnActivo}} bg-green-600"
                    wire:click="mostrarAcuerdosFinalizados">
                Finalizados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosObservados">
                Observados
            </button>
        @elseif($acuerdosObservados)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosEnProceso">
                En Proceso
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarAcuerdosFinalizados">
                Finalizados
            </button>
            <button class="{{$classesBtnActivo}} bg-red-600"
                    wire:click="mostrarAcuerdosObservados">
                Observados
            </button>
        @endif       
    </div>
    @if($acuerdosVigentes)
        <livewire:acuerdos-vigentes />
    @elseif($acuerdosEnProceso)
        Acuerdos En Proceso
    @elseif($acuerdosFinalizados)
        Acuerdos Finalizados
    @elseif($acuerdosObservados)
        Acuerdos Observados
    @endif
</div>
