@props(['title', 'value', 'icon', 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'bg-blue-50 text-blue-600 border-blue-200',
        'green' => 'bg-green-50 text-green-600 border-green-200',
        'yellow' => 'bg-yellow-50 text-yellow-600 border-yellow-200',
        'red' => 'bg-red-50 text-red-600 border-red-200',
        'purple' => 'bg-purple-50 text-purple-600 border-purple-200',
        'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
    ];
    $cardColor = $colors[$color] ?? $colors['blue'];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $value }}</p>
        </div>
        <div class="w-12 h-12 rounded-lg {{ $cardColor }} flex items-center justify-center">
            {!! $icon !!}
        </div>
    </div>
</div>