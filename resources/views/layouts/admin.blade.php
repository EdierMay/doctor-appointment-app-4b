@props([
    'title' => config('app.name', 'Laravel'),
    'breadcrumbs' => []
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/0d20d99f15.js" crossorigin="anonymous"></script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">

    {{-- Navegación y barra lateral --}}
    @include('layouts.includes.admin.navigation')
    @include('layouts.includes.admin.sidebar')

    <div class="p-4 sm:ml-64">
        {{-- margen superior para evitar que la barra fija tape el contenido --}}
        <div class="pt-20 pb-4 flex items-start justify-between">
            {{-- breadcrumb seguro --}}
            @includeFirst(
                ['layouts.includes.admin.breadcrumb', 'layouts.includes.breadcrumb'],
                ['breadcrumbs' => $breadcrumbs ?? []]
            )

            @isset($action)
                <div class="flex-shrink-0">
                    {{ $action }}
                </div>
            @endisset
        </div>

        {{-- Slot principal --}}
        {{ $slot }}
    </div>

    @stack('modals')

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    {{-- Alertas SweetAlert basadas en sesión --}}
    @if(session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

    {{-- Confirmación al eliminar (delegada para funcionar con Livewire / tablas dinámicas) --}}
    <script>
        document.addEventListener('submit', function(e) {
            const form = e.target;

            // soporta tanto .delete-form como .user-delete-form
            if (!form.classList || (!form.classList.contains('delete-form') && !form.classList.contains('user-delete-form'))) {
                return;
            }

            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form programmatically to bypass the preventDefault above
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
