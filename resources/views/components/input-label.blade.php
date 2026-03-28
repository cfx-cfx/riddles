@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-accent-600']) }}>
    {{ $value ?? $slot }}
</label>