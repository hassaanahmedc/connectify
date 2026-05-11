@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-gray-700 dark:text-gray-300 text-sm md:text-base']) }}>
    {{ $value ?? $slot }}
</label>
