<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-md border border-[#b9d1c7] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-[#12343b] shadow-sm transition duration-150 ease-in-out hover:bg-[#f6faf8] focus:outline-none focus:ring-2 focus:ring-[#31b889] focus:ring-offset-2 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
