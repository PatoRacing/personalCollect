@php
    $classesBtnPrincipal = "text-white text-sm bg-blue-800 hover:bg-blue-900 p-2.5 rounded"
@endphp

<a {{$attributes->merge(['class'=>$classesBtnPrincipal])}}>
    {{$slot}}
</a>