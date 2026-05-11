@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-[#31b889] px-1 pt-1 text-sm font-semibold leading-5 text-[#12343b] transition duration-150 ease-in-out focus:outline-none focus:border-[#ff6b4a]'
            : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-semibold leading-5 text-[#55706b] transition duration-150 ease-in-out hover:border-[#b9d1c7] hover:text-[#12343b] focus:outline-none focus:border-[#b9d1c7] focus:text-[#12343b]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
