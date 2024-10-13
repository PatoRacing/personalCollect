<div class="mt-1">
    <div class="grid grid-cols-3 md:flex gap-1 mb-2">
        @php
            $classesBtnActivo = "text-white rounded text-sm bg-blue-400 hover:bg-blue-500 py-2 py-2 px-6";
            $classesBtnInactivo = "rounded text-sm border shadow hover:bg-gray-100 md:py-2 py-2 px-6";
        @endphp
        <!--botones de navegacion-->
        @if($pagosVigentes)
            <button class="{{$classesBtnActivo}}"
                    wire:click="mostrarPagosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosInformados">
                Informados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosAplicados">
                Aplicados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosRendidos">
                Rendidos
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosObservados">
                Observados
            </button>
        @elseif($pagosInformados)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnActivo}}"
                    wire:click="mostrarPagosInformados">
                Informados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosAplicados">
                Aplicados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosRendidos">
                Rendidos
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosObservados">
                Observados
            </button>
        @elseif($pagosAplicados)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosInformados">
                Informados
            </button>
            <button class="{{$classesBtnActivo}}"
                    wire:click="mostrarPagosAplicados">
                Aplicados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosRendidos">
                Rendidos
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosObservados">
                Observados
            </button>
        @elseif($pagosRendidos)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosInformados">
                Informados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosAplicados">
                Aplicados
            </button>
            <button class="{{$classesBtnActivo}}"
                    wire:click="mostrarPagosRendidos">
                Rendidos
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosObservados">
                Observados
            </button>
        @elseif($pagosObservados)
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosVigentes">
                Vigentes
            </button>         
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosInformados">
                Informados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosAplicados">
                Aplicados
            </button>
            <button class="{{$classesBtnInactivo}}"
                    wire:click="mostrarPagosRendidos">
                Rendidos
            </button>
            <button class="{{$classesBtnActivo}}"
                    wire:click="mostrarPagosObservados">
                Observados
            </button>
        @endif     
    </div>
    @if($alertaPagoInformado)
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1">
            <p>Pago Informado Correctamente</p>
        </div>
    @elseif($alertaPagoAplicado)
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1">
            <p>Pago Aplicado Correctamente</p>
        </div>
    @elseif($alertaPagoAplicadoEnviado)
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1">
            <p>Pagos Aplicados Exportados Correctamente</p>
        </div>
    @endif 
    @if($pagosVigentes)
        <livewire:pagos-vigentes />
    @elseif($pagosInformados)
        <livewire:pagos-informados />
    @elseif($pagosAplicados)
        <livewire:pagos-aplicados />
    @elseif($pagosRendidos)
        pagos rendidos
    @elseif($pagosObservados)
        pagos Observados
    @endif
</div>