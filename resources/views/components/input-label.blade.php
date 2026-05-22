@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs uppercase tracking-widest text-gray-400 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
