<div>
    <form class="container p-2" wire:submit.prevent='guardarNuevaOperacion'>
        <h2 class="text-center bg-white font-bold text-gray-500 border-y-2 p-4 mb-2">Ingresa los valores para Deudor, Contacto y Operación</h2>
        @if($paso === 1)
            <div class="bg-white px-4 py-4 border">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Paso 1: Información del deudor</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Nombre -->
                    <div class="mt-3">
                        <x-input-label for="nombre" :value="__('Nombre y Apellido del deudor')" />
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
                    <div class="mt-3">
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
                    <div>
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
                    <div>
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
                    <div>
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
                    <div>
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
                <div class="flex justify-end">
                    <button class="text-black text-sm bg-gray-100 hover:text-white hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoUno"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif
        @if($paso === 2)
            <div class="bg-white px-4 py-4">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Paso 2: Información de contacto</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    
                    <!-- Tipo -->
                    <div class="mt-3">
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
                    <div class="mt-3">
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
                    <div>
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
                    <div>
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
                <div class="flex justify-between">
                    <button class="text-black text-sm hover:text-white bg-gray-100 hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="anterior"
                    >
                        Anterior
                    </button>
                    <button class="text-black text-sm hover:text-white bg-gray-100 hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoDos"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif
        @if($paso === 3)
            <div class="bg-white px-4 py-4">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Paso 3: Información general de la operación</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Cliente -->
                    <div class="mt-3">
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
                    <div class="mt-3">
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
                    <div>
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
                    <div>
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
                    <div>
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
                    <div>
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
                <div class="flex justify-between">
                    <button class="text-black text-sm hover:text-white bg-gray-100 hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="anterior"
                    >
                        Anterior
                    </button>
                    <button class="text-black text-sm hover:text-white bg-gray-100 hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoTres"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif
        @if($paso === 4)
            <div class="bg-white px-4 py-4">
                <h3 class="text-center bg-gray-200 py-4 font-bold rounded">Paso 4: Valores de la operación:</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- Deuda Capital -->
                    <div class="mt-3">
                        <x-input-label for="deuda_capital" :value="__('Monto de la deuda')" />
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
                    <div class="mt-3">
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
                    <div>
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
                    <div>
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
                    <div>
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
                    <div>
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
                    <div>
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
                    <div>
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
                <div class="flex justify-between">
                    <button class="text-black text-sm hover:text-white bg-gray-100 hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="anterior"
                    >
                        Anterior
                    </button>
                    <button class="text-black text-sm hover:text-white bg-gray-100 hover:bg-gray-400 border border-gray-300 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="siguientePasoCuatro"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        @endif
        @if($paso === 5)
            <div class="bg-white px-8 py-4">
                <h3 class="text-center border border-gray-300 shadow-sm uppercase text-2xl py-4 font-bold rounded">Resumen</h3>
                <div class="p-6 container grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <!--Info del deudor-->
                        <div class="px-4">
                            <h3 class="text-center border-b-2 py-4 font-bold rounded mb-4 uppercase">Información del Deudor</h3>

                            @if($this->nombre)
                                <p class="text-gray-600">Nombre y apellido del deudor: <span class="font-bold text-black">{{$this->nombre}}</span></p>
                            @endif

                            @if($this->tipo_doc)
                                <p class="text-gray-600">Tipo de Documento: <span class="font-bold text-black">{{$this->tipo_doc}}</span></p>
                            @endif
                            
                            <p class="text-gray-600">Número de Documento: <span class="font-bold text-black">{{$this->nro_doc}}</span></p>

                            @if($this->cuil)
                                <p class="text-gray-600">CUIL: <span class="font-bold text-black">{{$this->cuil}}</span></p>
                            @endif

                            @if($this->domicilio)
                                <p class="text-gray-600">Domicilio: <span class="font-bold text-black">{{$this->domicilio}}</span></p>
                            @endif

                            @if($this->localidad)
                                <p class="text-gray-600">Localidad: <span class="font-bold text-black">{{$this->localidad}}</span></p>
                            @endif

                            @if($this->codigo_postal)
                                <p class="text-gray-600">CUIL: <span class="font-bold text-black">{{$this->codigo_postal}}</span></p>
                            @endif
                        </div>
                        <!--Info de Contacto-->
                        <div class="px-4 mt-4">
                            <h3 class="text-center border-b-2 py-4 font-bold rounded mb-4 uppercase">Información de Contacto</h3>

                            @if($this->tipo)
                                <p class="text-gray-600">Tipo de Contacto: <span class="font-bold text-black">{{$this->tipo}}</span></p>
                            @endif

                            @if($this->contacto)
                                <p class="text-gray-600">Contacto: <span class="font-bold text-black">{{$this->contacto}}</span></p>
                            @endif

                            @if($this->numero)
                                <p class="text-gray-600">Número de Teléfono: <span class="font-bold text-black">{{$this->numero}}</span></p>
                            @endif

                            @if(!$this->tipo && !$this->contacto && !$this->numero)
                                <p class="text-gray-600"><span class="font-bold text-black">Sin información</span></p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <!--Info de la operacion-->
                        <div class="px-4">
                            <h3 class="text-center border-b-2 py-4 font-bold rounded mb-4 uppercase">Información de la Operación</h3>

                            <p class="text-gray-600">Cliente: <span class="font-bold text-black">{{$this->nombreCliente($this->cliente_id)}}</span></p>
                            <p class="text-gray-600">Producto: <span class="font-bold text-black">{{$this->nombreProducto($this->producto_id)}}</span></p>

                            @if($this->segmento)
                                <p class="text-gray-600">Segmento: <span class="font-bold text-black">{{$this->segmento}}</span></p>
                            @endif

                            <p class="text-gray-600">Nro. de Operación: <span class="font-bold text-black">{{$this->operacion}}</span></p>

                            @if($this->sucursal)
                                <p class="text-gray-600">Sucursal: <span class="font-bold text-black">{{$this->sucursal}}</span></p>
                            @endif

                            @if($this->dias_atraso)
                                <p class="text-gray-600">Dias de Atraso: <span class="font-bold text-black">{{$this->dias_atraso}}</span></p>
                            @endif

                            @if($this->deuda_capital)
                                <p class="text-gray-600">Monto de la Deuda: <span class="font-bold text-black">{{$this->deuda_capital}}</span></p>
                            @endif

                            @if($this->deuda_total)
                                <p class="text-gray-600">Monto Total: <span class="font-bold text-black">{{$this->deuda_total}}</span></p>
                            @endif

                            @if($this->estado)
                                <p class="text-gray-600">Estado: <span class="font-bold text-black">{{$this->estado}}</span></p>
                            @endif

                            @if($this->ciclo)
                                <p class="text-gray-600">Ciclo: <span class="font-bold text-black">{{$this->ciclo}}</span></p>
                            @endif

                            @if($this->fecha_asignacion)
                                <p class="text-gray-600">Fecha de Asignación: <span class="font-bold text-black">{{$this->fecha_asignacion}}</span></p>
                            @endif

                            @if($this->sub_producto)
                                <p class="text-gray-600">Subproducto: <span class="font-bold text-black">{{$this->sub_producto}}</span></p>
                            @endif

                            @if($this->compensatorio)
                                <p class="text-gray-600">Compensatorios: <span class="font-bold text-black">{{$this->compensatorio}}</span></p>
                            @endif

                            @if($this->punitivos)
                                <p class="text-gray-600">Punitivos: <span class="font-bold text-black">{{$this->punitivos}}</span></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex justify-between">
                    <button class="text-white bg-red-600 hover:bg-red-700 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="anterior"
                    >
                        Volver
                    </button>
                    <button class="text-white bg-green-700 hover:bg-green-900 px-5 py-2.5 mt-5 rounded"
                            wire:click.prevent="guardarNuevaOperacion"
                    >
                        Guardar
                    </button>
                </div>
            </div>
        @endif
    </form>
</div>
