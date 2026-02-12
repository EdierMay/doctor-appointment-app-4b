@php
    // La variable $patient viene desde el controlador o el Datatable
@endphp

<div class="flex items-center gap-2">
    {{-- Ver Detalle (Show) --}}
    {{-- Permite visualizar el expediente completo sin editarlo --}}
    <a href="{{ route('admin.patients.show', $patient) }}" 
       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-600 text-white hover:bg-green-700" 
       title="Ver detalle">
        <i class="fa-solid fa-eye text-lg"></i>
    </a>

    {{-- Editar (Edit) --}}
    {{-- Permite modificar campos médicos: alergias, tipo de sangre, etc. --}}
    <a href="{{ route('admin.patients.edit', $patient) }}"
       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
       title="Editar historial">
        <i class="fa-solid fa-pen-to-square text-lg"></i>
    </a>

    {{-- Información de borrado (Seguridad de datos) --}}
    {{-- No usamos DELETE aquí para evitar registros huérfanos --}}
    <button type="button"
        onclick="Swal.fire({
            icon: 'info',
            title: 'Gestión de registros',
            text: 'Para eliminar un paciente, debe hacerlo desde el módulo de Usuarios. Esto garantiza que el usuario y su expediente se borren correctamente.',
            confirmButtonColor: '#4b5563',
            confirmButtonText: 'Entendido'
        })"
        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200"
        title="Info de eliminación">
        <i class="fa-solid fa-circle-info text-lg"></i>
    </button>
</div>