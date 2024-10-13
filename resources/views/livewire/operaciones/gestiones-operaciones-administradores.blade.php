<div class="border border-gray-700 p-1 mt-2">
    <!--Seccion exclusiva de administradores sin politicas-->
    @if(auth()->user()->rol === 'Administrador')
        <x-subtitulo>
            Nueva gestión de Administrador
        </x-subtitulo>
        <!--Gestion para clientes con cuotas variables-->
        @if($operacion->productoId->acepta_cuotas_variables == 1)
            <!--ultima propuesta permite nuevas gestiones-->
            @if(!$ultimaPropuesta || $ultimaPropuesta->estado == 'Negociación'
                || $ultimaPropuesta->estado == 'Incobrable' || $ultimaPropuesta->estado == 'Rechazada')
                    <div class="grid gap-2 lg:grid-cols-3">
                        <livewire:propuesta-para-cancelacion-sin-politica :operacion="$operacion" />
                        <livewire:propuesta-para-cuotas-sin-politica :operacion="$operacion" />
                        <livewire:propuesta-para-cuotas-variables-sin-politicas :operacion="$operacion" />
                    </div>
            <!--ultima propuesta no permite nuevas gestiones-->
            @elseif($ultimaPropuesta->estado == 'Enviada' ||
                $ultimaPropuesta->estado == 'Propuesta de Pago' ||
                $ultimaPropuesta->estado == 'Acuerdo de Pago')
                    <p class="p-2 font-bold text-center">La operación tiene una acción en curso de una gestión anterior.</p>
            @endif
        <!--Gestion para clientes sin cuotas variables-->
        @else
            sin cuota variable
        @endif
    @else
        <p class="p-2 font-bold text-center">No tienes los permisos para esta sección.</p>
    @endif
</div>
