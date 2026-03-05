@props(['active'])

<div x-data="{ tab: '{{ $active }}' }">
    @if(isset($header))
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 border-b border-gray-200">
            {{ $header }}
        </ul>
    @endif

    <div class="mt-4">
        {{ $slot }}
    </div>
</div>