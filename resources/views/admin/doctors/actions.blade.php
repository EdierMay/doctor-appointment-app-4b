@php
    // La variable $doctor viene desde el Datatable (DoctorTable.php)
@endphp

<div class="flex items-center gap-2">
    {{-- Ver Detalle (Show) --}}
    {{-- Botón oscuro para resaltar la vista del perfil --}}
    <a href="{{ route('admin.doctors.show', $doctor) }}" 
       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-700 text-white hover:bg-gray-900 shadow-md transition-all duration-200" 
       title="Ver perfil del médico">
        <i class="fa-solid fa-eye text-lg"></i>
    </a>

    {{-- Editar (Edit) --}}
    {{-- Permite modificar la especialidad, cédula y biografía --}}
    <a href="{{ route('admin.doctors.edit', $doctor) }}"
       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow-sm transition-colors"
       title="Editar perfil médico">
        <i class="fa-solid fa-pen-to-square text-lg"></i>
    </a>

    {{-- Información de borrado --}}
    {{-- Explica la regla de atomicidad (Borrar desde usuario) --}}
    <button type="button"
        onclick="Swal.fire({
            icon: 'info',
            title: 'Gestión de registros',
            text: 'Para eliminar un doctor, debe hacerlo desde el módulo de Usuarios. Esto garantiza que la cuenta de acceso y su perfil médico se borren correctamente.',
            confirmButtonColor: '#374151',
            confirmButtonText: 'Entendido'
        })"
        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 shadow-sm transition-colors"
        title="Info de eliminación">
        <i class="fa-solid fa-circle-info text-lg"></i>
    </button>
</div>