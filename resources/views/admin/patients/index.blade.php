<x-admin-layout
    title="Pacientes | Healthify"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Pacientes',
        ],
    ]"
>

    {{-- 
        Nota: No incluimos el botón "Nuevo" aquí porque, según el video, 
        la creación se realiza desde el módulo de Usuarios para 
        garantizar la integridad de la base de datos. 
    --}}

    <p class="text-sm text-gray-500 mb-4">
        <i class="fa-solid fa-info-circle mr-1"></i>
        Los pacientes se crean automáticamente al asignar el rol "Paciente" a un usuario.
    </p>

    {{-- Tabla de pacientes --}}
    @livewire('admin.data-tables.patient-table')

    @push('js')
        @if (session('swal'))
            <script>
                Swal.fire({
                    icon: "{{ session('swal.icon') }}",
                    title: "{{ session('swal.title') }}",
                    text: "{{ session('swal.text') }}",
                    confirmButtonColor: '#3085d6',
                });
            </script>
        @endif
    @endpush

</x-admin-layout>
