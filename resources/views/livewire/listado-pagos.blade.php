<div>
    <!-- clases-->
    @php
        $classesSpan = "font-bold text-black";
        $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-2 text-center py-2";
        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
        $classesTipo = "text-center bg-blue-800 text-white py-2 font-bold rounded my-4 uppercase";
        $classesButtonTrue = "text-white rounded-md text-sm bg-blue-800 border-2 text-center py-3 px-6";
        $classesButtonFalse = "text-white rounded-md bg-blue-400 text-sm border-2 text-center py-3 px-6";
    @endphp
    <div class="px-4 py-2 sticky left-0">
        <h1 class="font-bold uppercase bg-gray-200 p-4 text-gray-900 hover:text-gray-500 text-center mb-2 flex items-center justify-center space-x-8">
            Listado de Pagos
        </h1>                
    </div>
    <div class="px-4 py-2 bg-gray-200 rounded">
        <div class="flex justify-end mb-2">
            <button class="{{ $pagosVigentes ? $classesButtonTrue : $classesButtonFalse }}"
                    wire:click="pagosVigentesActivo">
                Vigentes
            </button>
            <button class="{{ $pagosInformados ? $classesButtonTrue : $classesButtonFalse }}"
                    wire:click="pagosInformadosActivo">
                Informados
            </button>
            <button class="{{ $pagosAplicados ? $classesButtonTrue : $classesButtonFalse }}"
                    wire:click="pagosAplicadosActivo">
                Aplicados
            </button>
            <button class="{{ $pagosEnviados ? $classesButtonTrue : $classesButtonFalse }}"
                    wire:click="pagosEnviadosActivo">
                Enviados
            </button>
            <button class="{{ $pagosRendidos ? $classesButtonTrue : $classesButtonFalse }}"
                    wire:click="pagosRendidosActivo">
                Rendidos
            </button>
            <button class="{{ $pagosIncumplidos ? $classesButtonTrue : $classesButtonFalse }}"
                    wire:click="pagosIncumplidosActivo">
                Incumplidos
            </button>
        </div>
        @if($pagosVigentes)
            <livewire:pagos-vigentes />
        @elseif($pagosInformados)
            <livewire:pagos-informados />
        @elseif($pagosAplicados)
            <livewire:pagos-aplicados />
        @elseif($pagosEnviados)
            <livewire:pagos-enviados />
        @elseif($pagosRendidos)
            <livewire:pagos-rendidos />
        @elseif($pagosIncumplidos)
            <livewire:pagos-incumplidos />
        @endif
    </div>
</div>