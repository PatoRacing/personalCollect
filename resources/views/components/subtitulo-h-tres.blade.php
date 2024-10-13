@props(['variable'])

@php
    if ($variable->estado == 1) {
        $classesSubtituloHTres = "bg-blue-400 text-white uppercase py-1 text-center";
    } else {
        $classesSubtituloHTres = "bg-red-600 text-white uppercase py-1 text-center";
    }
@endphp

<h3 class="{{$classesSubtituloHTres}}">
    {{$slot}}
</h3>