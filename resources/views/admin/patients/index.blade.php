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

    <div class="flex justify-between items-center mb-4">
        <p class="text-sm text-gray-500">
            <i class="fa-solid fa-info-circle mr-1"></i>
            Los pacientes se crean automáticamente al asignar el rol "Paciente" a un usuario.
        </p>
        <a href="{{ route('admin.patients.import') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fa-solid fa-file-excel mr-2"></i> Importar Masivamente
        </a>
    </div>

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
