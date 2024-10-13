@php
    switch ($cuota->estado) {
        case "1":
            $estado = "Vigente";
            break;
        case "2":
            $estado = "Observada";
            break;
        case "3":
            $estado = "Aplicada";
            break;
        case "4":
            $estado = "Rendida Parcial";
            break;
        case "5":
            $estado = "Rendida Total";
            break;
        case "6":
            $estado = "Procesada";
            break;
        case "7":
            $estado = "Rendida a Cuenta";
            break;
        case "8":
            $estado = "Devuelta";
            break;
        default:
            $estado = "Desconocido";
            break;
    }
@endphp

<div class="{{ $bgColor }} text-white text-sm py-2 text-center mt-3">
    Deudor: {{ucwords(strtolower($cuota->acuerdo->propuesta->deudorId->nombre))}} /
    Tipo de Cuota: {{$cuota->concepto_cuota}} /
    Nro. Cuota: {{$cuota->nro_cuota}} /
    Estado: {{$estado}}
</div>