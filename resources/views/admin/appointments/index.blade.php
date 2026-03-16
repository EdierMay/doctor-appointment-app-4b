<x-admin-layout
    title="Citas Médicas | Dashboard"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Citas',
        ],
    ]"
>
    {{-- Top header con botón de registrar cita --}}
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">Citas</h2>
        
        <a href="{{ route('admin.appointments.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo
        </a>
    </div>

    {{-- Tabla de Citas en contenedor elegante --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @livewire(\App\Livewire\Admin\DataTables\AppointmentTable::class)
    </div>

    {{-- Componente de Consultas para el Modal (se abrirá al dar click en el estetoscopio) --}}
    @livewire('admin.consultation-manager')

    @push('js')
        @if (session('swal'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: "{{ session('swal.icon') }}",
                        title: "{{ session('swal.title') }}",
                        text: "{{ session('swal.text') }}",
                        confirmButtonColor: '#4f46e5',
                    });
                });
            </script>
        @endif
    @endpush
</x-admin-layout>
