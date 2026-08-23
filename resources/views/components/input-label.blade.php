@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#008037]']) }}>
    {{ $value ?? $slot }}
</label>
