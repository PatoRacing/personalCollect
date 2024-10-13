<div class="mt-1">
    <div class="mb-2 grid grid-cols-2 md:grid-cols-4 lg:flex gap-2">
        @php
            $classesBtnActivo = "text-white rounded text-sm py-2 px-4";
            $classesBtnInactivo = "rounded text-sm border shadow hover:bg-gray-100 py-2 px-4";
        @endphp
        <!--botones de navegacion-->
        <button class="{{ $cuotasVigentes ? $classesBtnActivo . ' bg-blue-800' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('vigentes')">
            Vigentes
        </button>
        <button class="{{ $cuotasObservadas ? $classesBtnActivo . ' bg-red-600' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('observadas')">
            Observadas
        </button>       
        <button class="{{ $cuotasAplicadas ? $classesBtnActivo . ' bg-indigo-600' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('aplicadas')">
            Aplicadas
        </button>
        <button class="{{ $cuotasRendidasParcial ? $classesBtnActivo . ' bg-cyan-600' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('rendidasParcial')">
            Rend. Parcial
        </button>
        <button class="{{ $cuotasRendidasTotal ? $classesBtnActivo . ' bg-green-600' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('rendidasTotal')">
            Rend. Total
        </button>  
        <button class="{{ $cuotasProcesadas ? $classesBtnActivo . ' bg-yellow-500' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('procesadas')">
            Procesadas
        </button>  
        <button class="{{ $cuotasRendidasACuenta ? $classesBtnActivo . ' bg-orange-500' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('rendidasACuenta')">
            R. a Cuenta
        </button>
        <button class="{{ $cuotasDevueltas ? $classesBtnActivo . ' bg-gray-600' : $classesBtnInactivo }}"
                wire:click="mostrarCuotas('devueltas')">
            Devueltas
        </button>       
    </div>
    @if($cuotasVigentes)
        <livewire:cuotas.vigentes />
    @elseif($cuotasObservadas)
        <livewire:cuotas.observadas />
    @elseif($cuotasAplicadas)
        <livewire:cuotas.aplicadas />
    @elseif($cuotasRendidasParcial)
        <livewire:cuotas.rendidas-parcial />
    @elseif($cuotasRendidasTotal)
        <livewire:cuotas.rendidas-total />
    @elseif($cuotasProcesadas)
        <livewire:cuotas.procesadas />
    @elseif($cuotasRendidasACuenta)
        <livewire:cuotas.rendidas-a-cuenta />
    @elseif($cuotasDevueltas)
        <livewire:cuotas.devueltas />
    @endif
</div>