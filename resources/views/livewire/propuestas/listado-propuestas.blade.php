<div class="mt-1">
    <div class="flex gap-1 mb-2">
        @php
            $classesBtnActivo = "text-white rounded text-sm bg-blue-400 hover:bg-blue-500 py-2 px-6";
            $classesBtnInactivo = "rounded text-sm border shadow hover:bg-gray-100 py-2 px-6";
        @endphp
        <!--botones de navegacion-->
        @if($propuestasSinEnviar)
            <button class="{{$classesBtnActivo}}"
                    wire:click="mostrarPropuestasSinEnviar">
                Sin enviar
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPropuestasEnviadas">
                Enviadas
            </button>
        @elseif($propuestasEnviadas)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPropuestasSinEnviar">
                Sin enviar
            </button>         
            <button class="{{$classesBtnActivo}}"
                    wire:click="mostrarPropuestasEnviadas">
                Enviadas
            </button>
        @endif       
    </div>
    @if($propuestasSinEnviar)
        <livewire:propuestas-sin-enviar />
    @elseif($propuestasEnviadas)
        <livewire:propuestas-enviadas />
    @endif
</div>