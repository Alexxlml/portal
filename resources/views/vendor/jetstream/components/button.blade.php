<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-verde-silconio-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-verde-silconio-700 active:bg-verde-silconio-900 focus:outline-none focus:border-verde-silconio-900 focus:ring focus:ring-verde-silconio-300 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
