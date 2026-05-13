@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-gray-900 focus:ring-gray-900 rounded-xl shadow-sm px-4 py-3 transition-colors duration-200']) }}>
