<x-admin-layout
    title="Doctores | Healthify"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Doctores',
        ],
    ]"
>

    {{-- Banner Informativo Profesional --}}
    <div class="mb-6 bg-indigo-50/50 border border-indigo-100 rounded-xl p-4 flex items-start sm:items-center gap-4 shadow-sm transition-all hover:shadow-md">
        
        <div class="bg-indigo-100 text-indigo-600 rounded-lg p-3 flex-shrink-0">
            <i class="fa-solid fa-user-doctor text-xl"></i>
        </div>

        <div>
            <h4 class="text-sm font-bold text-indigo-900 tracking-wide">
                Gestión estructurada de perfiles
            </h4>

            <p class="text-sm text-indigo-700 mt-1 leading-relaxed">
                Para mantener la integridad del sistema, los perfiles médicos se generan automáticamente 
                al asignar el rol de <strong>"Doctor"</strong> a un usuario. 
                Si necesitas registrar a un nuevo médico,
                <a href="{{ route('admin.users.index') }}" 
                   class="font-bold underline decoration-indigo-300 hover:decoration-indigo-600 hover:text-indigo-900 transition-all">
                    dirígete al módulo de Usuarios 
                    <i class="fa-solid fa-arrow-right-long text-xs ml-1"></i>
                </a>
            </p>
        </div>
    </div>


    {{-- Encabezado del módulo --}}
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">
            Listado de Doctores
        </h2>
    </div>


    {{-- Tabla en contenedor elegante --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @livewire(\App\Livewire\Admin\DataTables\DoctorTable::class)
    </div>


    {{-- SweetAlert mejorado --}}
    @push('js')
        @if (session('swal'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: "{{ session('swal.icon') }}",
                        title: "{{ session('swal.title') }}",
                        text: "{{ session('swal.text') }}",
                        confirmButtonColor: '#4f46e5',
                        customClass: {
                            confirmButton: 'rounded-lg px-5 py-2.5 font-medium'
                        }
                    });
                });
            </script>
        @endif
    @endpush

</x-admin-layout>