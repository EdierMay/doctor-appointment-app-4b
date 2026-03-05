@props(['tab', 'error' => false])

<li class="me-2">
    <a href="#" 
       @click.prevent="tab = '{{ $tab }}'"
       :class="{
           'text-blue-600 border-blue-600 border-b-2': tab === '{{ $tab }}' && !{{ $error ? 'true' : 'false' }},
           'text-red-600 border-red-600 border-b-2': {{ $error ? 'true' : 'false' }} && tab === '{{ $tab }}',
           'text-red-500 hover:text-red-700': {{ $error ? 'true' : 'false' }} && tab !== '{{ $tab }}',
           'hover:text-gray-600 hover:border-gray-300 border-transparent border-b-2': tab !== '{{ $tab }}' && !{{ $error ? 'true' : 'false' }}
       }"
       class="inline-block p-4 rounded-t-lg transition-colors">
        
        {{ $slot }}

        @if($error)
            <i class="fa-solid fa-circle-exclamation animate-pulse ml-1 text-red-500"></i>
        @endif
    </a>
</li>