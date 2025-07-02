@props(['id' => null, 'maxWidth' => '2xl', 'title' => '', 'zIndex'])

@php
    $id = $id ?? md5($attributes->wire('model') ?? Str::random());

    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth] ?? 'sm:max-w-2xl';

    $zIndex = $zIndex ?? 999;
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    x-on:close.window="show = false"
    x-cloak
    class="fixed inset-0 z-{{ $zIndex }} flex items-center justify-center px-4 py-6 overflow-y-auto bg-black/90"
>
    <!-- Modal box -->
    <div
        class="w-full {{ $maxWidthClass }} bg-white rounded-lg shadow-xl transform transition-all"
        @click.away="show = false"
        x-show="show"
        x-trap.inert.noscroll="show"
        x-transition
    >
        <!-- Modal Header -->
        <div class="flex justify-between items-center px-4 py-3 bg-indigo-400 text-white rounded-t-lg">
            <h2 class="text-lg font-semibold">{{ $title }}</h2>
            <button class="text-xl hover:text-gray-200" @click="show = false">&times;</button>
        </div>

        <!-- Modal Content -->
        <div class="px-5 py-4 text-gray-800">
            {{ $slot }}
        </div>
    </div>
</div>
