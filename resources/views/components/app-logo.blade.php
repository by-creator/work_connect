@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="WorkConnect" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-blue-600 text-white">
            <span class="text-xs font-bold text-white">WC</span>
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="WorkConnect" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-blue-600 text-white">
            <span class="text-xs font-bold text-white">WC</span>
        </x-slot>
    </flux:brand>
@endif
