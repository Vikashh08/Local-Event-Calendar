<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-xl font-black text-xs text-white uppercase tracking-widest hover:bg-red-700 hover:-translate-y-0.5 hover:shadow-lg focus:bg-red-700 active:bg-red-800 focus:outline-none transition-all duration-200']) }}>
    {{ $slot }}
</button>
