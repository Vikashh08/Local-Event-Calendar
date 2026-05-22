<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none disabled:opacity-25 transition-all duration-200']) }}>
    {{ $slot }}
</button>
