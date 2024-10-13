<div>
    <form wire:submit.prevent='guardarNuevaOperacion'class="mt-2 border p-1">
        @php
            $classesBtn ="text-white px-4 py-2 rounded text-sm"
        @endphp
        @if($paso === 1)
            <x-subtitulo-h-cuatro>
                Paso 1: Información del deudor
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 p-2">
                <!-- Nombre -->
                <div class="mt-1">
                    <x-input-label for="nombre" :value="__('Nombre del deudor')" />
                    <x-text-input
                        id="nombre"
                        placeholder="Nombre del deudor"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="nombre"
                        :value="old('nombre')"
                        />
                </div>
                <!-- Tipo Doc -->
                <div class="mt-1">
                    <x-input-label for="tipo_doc" :value="__('Tipo Documento')" />
                    <x-text-input
                        id="tipo_doc"
                        placeholder="Tipo de documento"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="tipo_doc"
                        :value="old('tipo_doc')"
                        />
                </div>
                <!-- Nro Doc -->
                <div class="mt-1">
                    <x-input-label for="nro_doc" :value="__('Número de documento')" />
                    <x-text-input
                        id="nro_doc"
                        placeholder="Número de documento"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="nro_doc"
                        :value="old('nro_doc')"
                        />
                    <x-input-error :messages="$errors->get('nro_doc')" class="mt-2" />
                </div>
                <!-- Domicilio -->
                <div class="mt-1">
                    <x-input-label for="domicilio" :value="__('Domicilio')" />
                    <x-text-input
                        id="domicilio"
                        placeholder="Domicilio del deudor"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="domicilio"
                        :value="old('domicilio')"
                        />
                </div>
                <!-- Localidad -->
                <div class="mt-1">
                    <x-input-label for="localidad" :value="__('Localidad')" />
                    <x-text-input
                        id="localidad"
                        placeholder="Localidad del deudor"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="localidad"
                        :value="old('localidad')"
                        />
                </div>
                <!-- Codigo Postal -->
                <div class="mt-1">
                    <x-input-label for="codigo_postal" :value="__('Codigo Postal')" />
                    <x-text-input
                        id="codigo_postal"
                        placeholder="Localidad del deudor"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="codigo_postal"
                        :value="old('codigo_postal')"
                        />
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 p-2">
                <span>
                </span>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoUno">
                    Siguiente
                </button>
            </div>
        
        @elseif($paso === 2)
            <x-subtitulo-h-cuatro>
                Paso 2: Información de contacto
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 p-2">  
                <!-- Tipo -->
                <div class="mt-1">
                    <x-input-label for="tipo" :value="__('Tipo de Contacto:')" />
                    <select
                        id="tipo"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="tipo"
                    >
                        <option value="">Seleccionar</option>
                        <option value="Celular">Celular</option>
                        <option value="Tel. Fijo">Tel. Fijo</option>
                        <option value="WhastApp">WhastApp</option>
                        <option value="Email">Email</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                </div>
                <!-- Contacto -->
                <div class="mt-1">
                    <x-input-label for="contacto" :value="__('Contacto:')" />
                    <select
                        id="contacto"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="contacto"
                    >
                        <option value="">Seleccionar</option>
                        <option value="Celular">Titular</option>
                        <option value="Tel. Fijo">Referencia</option>
                        <option value="WhastApp">Laboral</option>
                        <option value="Email">Familiar</option>
                    </select>
                    <x-input-error :messages="$errors->get('contacto')" class="mt-2" />
                </div>
                <!-- Número -->
                <div class="mt-1">
                    <x-input-label for="numero" :value="__('Número de Teléfono')" />
                    <x-text-input
                        id="numero"
                        placeholder="Número de Teléfono"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="numero"
                        />
                </div>
                <!-- Cuil -->
                <div class="mt-1">
                    <x-input-label for="cuil" :value="__('CUIL')" />
                    <x-text-input
                        id="cuil"
                        placeholder="CUIL"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="cuil"
                        :value="old('cuil')"
                        />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                    Anterior
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoDos">
                    Siguiente
                </button>
            </div>
        
        @elseif($paso === 3)
            <x-subtitulo-h-cuatro>
                Paso 3: Información general de la operación
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 p-2"> 
                <!-- Cliente -->
                <div class="mt-1">
                    <x-input-label for="cliente_id" :value="__('Selecciona un cliente')" />
                    <select
                        id="cliente_id"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="cliente_id"
                        wire:change="clienteSeleccionado"
                    >
                        <option value="">Selecciona un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
                </div>
                <!-- Producto -->
                <div class="mt-1">
                    <x-input-label for="producto_id" :value="__('Selecciona un producto')" />
                    <select
                        id="producto_id"
                        class="block mt-1 w-full rounded-md border-gray-300"
                        wire:model="producto_id"
                    >
                        <option value="">Selecciona un producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('producto_id')" class="mt-2" />
                </div>
                <!-- Segmento -->
                <div class="mt-1">
                    <x-input-label for="segmento" :value="__('Segmento')" />
                    <x-text-input
                        id="segmento"
                        placeholder="Segmento"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="segmento"
                        />
                </div>
                <!-- Operación -->
                <div class="mt-1">
                    <x-input-label for="operacion" :value="__('Nro. Operación')" />
                    <x-text-input
                        id="operacion"
                        placeholder="Nro. Operación"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="operacion"
                        />
                    <x-input-error :messages="$errors->get('operacion')" class="mt-2" />
                </div>
                <!-- Sucursal -->
                <div class="mt-1">
                    <x-input-label for="sucursal" :value="__('Sucursal')" />
                    <x-text-input
                        id="sucursal"
                        placeholder="Sucursal"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="sucursal"
                        />
                </div>
                <!-- Dias atraso -->
                <div class="mt-1">
                    <x-input-label for="dias_atraso" :value="__('Días de Atraso')" />
                    <x-text-input
                        id="dias_atraso"
                        placeholder="Días de Atraso"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="dias_atraso"
                        />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                    Anterior
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoTres">
                    Siguiente
                </button>
            </div>
        
        @elseif($paso === 4)
            <x-subtitulo-h-cuatro>
                Paso 4: Valores de la operación:
            </x-subtitulo-h-cuatro>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-4 p-2">
                <!-- Deuda Capital -->
                <div class="mt-1">
                    <x-input-label for="deuda_capital" :value="__('Deuda Capital')" />
                    <x-text-input
                        id="deuda_capital"
                        placeholder="Monto de la deuda"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="deuda_capital"
                        />
                    <x-input-error :messages="$errors->get('deuda_capital')" class="mt-2" />
                </div>
                <!-- Deuda Total -->
                <div class="mt-1">
                    <x-input-label for="deuda_total" :value="__('Monto total')" />
                    <x-text-input
                        id="deuda_total"
                        placeholder="Monto total"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="deuda_total"
                        />
                </div>
                <!-- Estado -->
                <div class="mt-1">
                    <x-input-label for="estado" :value="__('Estado')" />
                    <x-text-input
                        id="estado"
                        placeholder="Estado"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="estado"
                        />
                </div>
                <!-- Ciclo -->
                <div class="mt-1">
                    <x-input-label for="ciclo" :value="__('Ciclo')" />
                    <x-text-input
                        id="ciclo"
                        placeholder="Ciclo"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="ciclo"
                        />
                </div>
                <!-- Fecha de Asignacion -->
                <div class="mt-1">
                    <x-input-label for="fecha_asignacion" :value="__('Fecha de asignacion')" />
                    <x-text-input
                        id="fecha_asignacion"
                        class="block mt-1 w-full"
                        type="date"
                        wire:model="fecha_asignacion"
                        :value="old('fecha_asignacion')" 
                        />
                    <x-input-error :messages="$errors->get('fecha_asignacion')" class="mt-2" />
                </div>
                <!-- Subproducto -->
                <div class="mt-1">
                    <x-input-label for="sub_producto" :value="__('Subproducto')" />
                    <x-text-input
                        id="sub_producto"
                        placeholder="Subproducto"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="sub_producto"
                        />
                </div>
                <!-- Compensatorio -->
                <div class="mt-1">
                    <x-input-label for="compensatorio" :value="__('Compensatorio')" />
                    <x-text-input
                        id="compensatorio"
                        placeholder="Compensatorio"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="compensatorio"
                        />
                </div>
                <!-- Punitivos -->
                <div class="mt-1">
                    <x-input-label for="punitivos" :value="__('Punitivos')" />
                    <x-text-input
                        id="punitivos"
                        placeholder="Punitivos"
                        class="block mt-1 w-full"
                        type="text"
                        wire:model="punitivos"
                        />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                    Anterior
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="siguientePasoCuatro">
                    Siguiente
                </button>
            </div>
        @elseif($paso === 5)
            <x-subtitulo-h-cuatro>
                Resumen:
            </x-subtitulo-h-cuatro>
            <div class="p-2 grid grid-cols-1 gap-4 lg:grid-cols-3">
                <!--Info del deudor-->
                <div>
                    <x-subtitulo-h-cuatro>
                        Información del Deudor:
                    </x-subtitulo-h-cuatro>
                    <div class="p-2">
                        @if($this->nombre)
                            <p>Nombre del deudor:
                                <span class="font-bold">
                                    {{$this->nombre}}
                                </span>
                            </p>
                        @endif
                        @if($this->tipo_doc)
                            <p>Tipo de Documento:
                                <span class="font-bold">
                                    {{$this->tipo_doc}}
                                </span>
                            </p>
                        @endif
                        <p>Número de Documento:
                            <span class="font-bold">
                                {{$this->nro_doc}}
                            </span>
                        </p>
                        @if($this->cuil)
                            <p>CUIL:
                                <span class="font-bold">
                                    {{$this->cuil}}
                                </span>
                            </p>
                        @endif
                        @if($this->domicilio)
                            <p>Domicilio:
                                <span class="font-bold">
                                    {{$this->domicilio}}
                                </span>
                            </p>
                        @endif
                        @if($this->localidad)
                            <p>Localidad:
                                <span class="font-bold">
                                    {{$this->localidad}}
                                </span>
                            </p>
                        @endif
                        @if($this->codigo_postal)
                            <p>Cod. Postal:
                                <span class="font-bold">
                                    {{$this->codigo_postal}}
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
                <!--Info de Contacto-->
                <div>
                    <x-subtitulo-h-cuatro>
                        Información de Contacto:
                    </x-subtitulo-h-cuatro>
                    <div class="p-2">
                        @if($this->tipo)
                            <p>Tipo de Contacto:
                                <span class="font-bold">
                                    {{$this->tipo}}
                                </span>
                            </p>
                        @endif
                        @if($this->contacto)
                            <p>Contacto:
                                <span class="font-bold">
                                    {{$this->contacto}}
                                </span>
                            </p>
                        @endif
                        @if($this->numero)
                            <p>Número de Teléfono:
                                <span class="font-bold">
                                    {{$this->numero}}
                                </span>
                            </p>
                        @endif
                        @if(!$this->tipo && !$this->contacto && !$this->numero)
                            <p><span class="font-bold text-black">Sin información</span></p>
                        @endif
                    </div>
                </div>
                <!--Info de Operacion-->
                <div>
                    <x-subtitulo-h-cuatro class="bg-blue-300 text-white">
                            Información de la Operación
                    </x-subtitulo-h-cuatro>
                    <div class="p-2">
                        <p>Cliente:
                            <span class="font-bold">
                                {{$this->nombreCliente($this->cliente_id)}}
                            </span>
                        </p>
                        <p>Producto:
                            <span class="font-bold">
                                {{$this->nombreProducto($this->producto_id)}}
                            </span>
                        </p>
                        @if($this->segmento)
                            <p>Segmento:
                                <span class="font-bold">
                                    {{$this->segmento}}
                                </span>
                            </p>
                        @endif
                        <p>Nro. de Operación:
                            <span class="font-bold">
                                {{$this->operacion}}
                            </span>
                        </p>
                        @if($this->sucursal)
                            <p>Sucursal:
                                <span class="font-bold">
                                    {{$this->sucursal}}
                                </span>
                            </p>
                        @endif
                        @if($this->dias_atraso)
                            <p>Dias de Atraso:
                                <span class="font-bold">
                                    {{$this->dias_atraso}} días
                                </span>
                            </p>
                        @endif
                        @if($this->deuda_capital)
                            <p>Monto de la Deuda:
                                <span class="font-bold">
                                    ${{ number_format($this->deuda_capital, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($this->deuda_total)
                            <p>Monto Total:
                                <span class="font-bold">
                                    ${{ number_format($this->deuda_total, 2, ',', '.') }}
                                </span>
                            </p>
                        @endif
                        @if($this->estado)
                            <p>Estado: <span class="font-bold">
                                {{$this->estado}}
                            </span>
                        </p>
                        @endif
                        @if($this->ciclo)
                            <p>Ciclo:
                                <span class="font-bold">
                                    {{$this->ciclo}}
                                </span>
                            </p>
                        @endif
                        @if($this->fecha_asignacion)
                            <p>Fecha de Asignación:
                                <span class="font-bold">
                                    {{ \Carbon\Carbon::parse($this->fecha_asignacion)->format('d/m/Y') }}
                                </span>
                            </p>
                        @endif
                        @if($this->sub_producto)
                            <p>Subproducto:
                                <span class="font-bold">
                                    {{$this->sub_producto}}
                                </span>
                            </p>
                        @endif
                        @if($this->compensatorio)
                            <p>Compensatorios:
                                <span class="font-bold">
                                    {{$this->compensatorio}}
                                </span>
                            </p>
                        @endif
                        @if($this->punitivos)
                            <p>Punitivos:
                                <span class="font-bold">
                                    {{$this->punitivos}}
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>  
            <div class="grid grid-cols-2 gap-2 p-2">
                <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700" wire:click.prevent="anterior">
                    Volver
                </button>
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700" wire:click.prevent="guardarNuevaOperacion">
                    Guardar
                </button>
            </div>
        @endif
    </form>
</div>
