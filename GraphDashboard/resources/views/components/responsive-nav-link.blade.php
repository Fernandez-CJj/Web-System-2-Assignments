@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full border-l-4 border-[#31b889] bg-[#eef6f2] py-2 pe-4 ps-3 text-start text-base font-semibold text-[#12343b] transition duration-150 ease-in-out focus:outline-none focus:border-[#ff6b4a] focus:bg-[#e7f8ee]'
            : 'block w-full border-l-4 border-transparent py-2 pe-4 ps-3 text-start text-base font-semibold text-[#55706b] transition duration-150 ease-in-out hover:border-[#b9d1c7] hover:bg-[#f6faf8] hover:text-[#12343b] focus:outline-none focus:border-[#b9d1c7] focus:bg-[#f6faf8] focus:text-[#12343b]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
