@props(['disabled' => false])

<input
    @disabled($disabled) {{ $attributes->merge([
        'class' => 'w-full rounded-lg border-1 border-[#4CAF50] bg-green-50 px-4 py-3 text-gray-800 placeholder-gray-400 shadow-sm focus:border-green-600 focus:ring-2 focus:ring-green-500 focus:outline-none'
    ]) }}>