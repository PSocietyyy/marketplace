@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'fullWidth' => false
])

@php
    $baseClass = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-black hover:bg-gray-800 active:bg-gray-900 text-white focus:ring-gray-300 shadow-sm hover:shadow-md',
        'secondary' => 'bg-gray-100 hover:bg-gray-200 active:bg-gray-300 text-gray-900 focus:ring-gray-200 border border-gray-200',
        'outline' => 'border border-gray-300 hover:bg-gray-50 active:bg-gray-100 text-gray-700 focus:ring-gray-200 bg-white',
        'ghost' => 'hover:bg-gray-100 active:bg-gray-200 text-gray-700 focus:ring-gray-200',
        'danger' => 'bg-red-600 hover:bg-red-700 active:bg-red-800 text-white focus:ring-red-200 shadow-sm hover:shadow-md',
        'warning' => 'bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white focus:ring-amber-200 shadow-sm hover:shadow-md',
        'success' => 'bg-green-600 hover:bg-green-700 active:bg-green-800 text-white focus:ring-green-200 shadow-sm hover:shadow-md',
        'info' => 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white focus:ring-blue-200 shadow-sm hover:shadow-md',
    ];

    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs gap-1',
        'sm' => 'px-3 py-2 text-sm gap-1.5',
        'md' => 'px-4 py-2.5 text-sm gap-2',
        'lg' => 'px-6 py-3 text-base gap-2',
        'xl' => 'px-8 py-4 text-lg gap-2.5',
    ];

    $classes = collect([
        $baseClass,
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? $sizes['md'],
        $fullWidth ? 'w-full' : '',
        $loading ? 'cursor-wait' : '',
    ])->filter()->implode(' ');
@endphp

@if ($href && !$disabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif ($icon && $iconPosition === 'left')
            <i class="{{ $icon }}"></i>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <i class="{{ $icon }}"></i>
        @endif
    </a>
@else
    <button 
        {{ $attributes->merge([
            'class' => $classes,
            'disabled' => $disabled || $loading,
            'type' => $attributes->get('type', 'button')
        ]) }}
    >
        @if ($loading)
            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif ($icon && $iconPosition === 'left')
            <i class="{{ $icon }}"></i>
        @endif
        
        {{ $slot }}
        
        @if ($icon && $iconPosition === 'right')
            <i class="{{ $icon }}"></i>
        @endif
    </button>
@endif