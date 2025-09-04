@props([
    'type' => 'text',
    'variant' => 'default',
    'size' => 'md',
    'label' => null,
    'error' => null,
    'helper' => null,
    'required' => false,
    'disabled' => false,
    'placeholder' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'clearable' => false
])

@php
    $id = $attributes->get('id', 'input-' . Str::random(6));
    $baseClass = 'block w-full rounded-lg border transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50';
    
    $variants = [
        'default' => 'border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500/20',
        'error' => 'border-red-300 bg-white text-gray-900 placeholder-gray-500 focus:border-red-500 focus:ring-red-500/20',
        'success' => 'border-green-300 bg-white text-gray-900 placeholder-gray-500 focus:border-green-500 focus:ring-green-500/20',
        'warning' => 'border-amber-300 bg-white text-gray-900 placeholder-gray-500 focus:border-amber-500 focus:ring-amber-500/20',
    ];

    $sizes = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-4 py-3 text-base',
    ];

    $inputClass = collect([
        $baseClass,
        $variants[$variant] ?? $variants['default'],
        $sizes[$size] ?? $sizes['md'],
        $icon ? ($iconPosition === 'left' ? 'pl-10' : 'pr-10') : '',
        $clearable ? 'pr-10' : '',
    ])->filter()->implode(' ');

    $wrapperClass = $icon || $clearable ? 'relative' : '';
@endphp

<div class="space-y-1">
    {{-- Label --}}
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif

    {{-- Input Container --}}
    <div class="{{ $wrapperClass }}">
        {{-- Left Icon --}}
        @if ($icon && $iconPosition === 'left')
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif

        {{-- Input Field --}}
        <input 
            type="{{ $type }}" 
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' => $inputClass,
                'required' => $required,
                'disabled' => $disabled,
            ]) }}
        >

        {{-- Right Icon --}}
        @if ($icon && $iconPosition === 'right')
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif

        {{-- Clear Button --}}
        @if ($clearable)
            <button 
                type="button"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                onclick="document.getElementById('{{ $id }}').value = ''; document.getElementById('{{ $id }}').focus();"
            >
                <i class="ri-close-line"></i>
            </button>
        @endif
    </div>

    {{-- Helper Text --}}
    @if ($helper && !$error)
        <p class="text-sm text-gray-500">{{ $helper }}</p>
    @endif

    {{-- Error Message --}}
    @if ($error)
        <p class="text-sm text-red-600 flex items-center gap-1">
            <i class="ri-error-warning-line"></i>
            {{ $error }}
        </p>
    @endif
</div>