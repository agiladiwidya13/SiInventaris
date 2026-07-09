@props(['label', 'value'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ $label }}</p>
            <p class="text-3xl font-extrabold mt-2 text-gray-900">{{ $value }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl bg-accent-500/10 flex items-center justify-center text-accent-500">
            {{ $icon ?? '' }}
        </div>
    </div>
</div>
