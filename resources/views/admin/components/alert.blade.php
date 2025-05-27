@props(['type' => 'info'])

@php
    $base = 'rounded-md px-4 py-3 mb-4 text-sm font-medium';
    $types = [
        'success' => 'bg-green-100 text-green-800 border border-green-200',
        'error'   => 'bg-red-100 text-red-800 border border-red-200',
        'info'    => 'bg-blue-100 text-blue-800 border border-blue-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    ];
@endphp

@php
    $classes = $base . ' ' . ($types[$type] ?? $types['info']);
@endphp
<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
