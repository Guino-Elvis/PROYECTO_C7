@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'relative px-4 py-2 flex items-center align-middle space-x-2 rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600'
            : 'px-4 py-2 flex items-center align-middle space-x-2 rounded-xl text-zinc-600 group hover:text-indigo-600 hover:bg-zinc-100 active:bg-zinc-200';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        <div class="h-6 w-6 flex justify-center items-center">
            @if (isset($logo))
                <i class="{{ $logo }}"></i>
            @else
                <i class="fa-regular fa-circle fa-xs"></i>
            @endif
        </div>
        <span class="font-medium text-sm w-40 whitespace-nowrap overflow-hidden text-ellipsis">{{ $slot }}</span>
    </a>
</li>
