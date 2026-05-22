<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gray-900 border border-transparent rounded-xl font-black text-xs text-white uppercase tracking-widest hover:bg-black hover:-translate-y-0.5 hover:shadow-lg focus:bg-black active:bg-gray-950 focus:outline-none transition-all duration-200']) }}>
    {{ $slot }}
</button>
