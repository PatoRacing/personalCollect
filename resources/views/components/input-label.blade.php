@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold']) }}>
    {{ $value ?? $slot }}
</label>
