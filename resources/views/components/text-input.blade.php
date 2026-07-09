@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300    focus:border-telkomsel-500 focus:ring-telkomsel-500 rounded-xl shadow-sm transition duration-200 placeholder:text-gray-400 ']) }}>
