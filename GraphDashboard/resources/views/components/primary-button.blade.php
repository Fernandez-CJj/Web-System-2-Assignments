<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md border border-transparent bg-[#12343b] px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-[#1a4c45] focus:bg-[#1a4c45] focus:outline-none focus:ring-2 focus:ring-[#31b889] focus:ring-offset-2 active:bg-[#0f2b31]']) }}>
    {{ $slot }}
</button>
