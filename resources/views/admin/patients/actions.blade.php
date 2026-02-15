@php
    // La variable $patient viene desde el controlador o el Datatable
@endphp

<div class="flex items-center gap-2">
    {{-- CAMBIO AQUÍ: Ver Detalle (Show) --}}
    {{-- Le puse un color OSCURO (gray-700) fuerte para que resalte y se vea bien claro --}}
    <a href="{{ route('admin.patients.show', $patient) }}" 
       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-700 text-white hover:bg-gray-900 shadow-md transition-all duration-200" 
       title="Ver detalle del expediente">
        <i class="fa-solid fa-eye text-lg"></i>
    </a>

    {{-- Editar (Edit) --}}
    {{-- Permite modificar campos médicos --}}
    <a href="{{ route('admin.patients.edit', $patient) }}"
       class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow-sm transition-colors"
       title="Editar historial">
        <i class="fa-solid fa-pen-to-square text-lg"></i>
    </a>

    {{-- Información de borrado --}}
    {{-- Este lo dejamos como estaba, visible pero discreto --}}
    <button type="button"
        onclick="Swal.fire({
            icon: 'info',
            title: 'Gestión de registros',
            text: 'Para eliminar un paciente, debe hacerlo desde el módulo de Usuarios. Esto garantiza que el usuario y su expediente se borren correctamente.',
            confirmButtonColor: '#374151',
            confirmButtonText: 'Entendido'
        })"
        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 shadow-sm transition-colors"
        title="Info de eliminación">
        <i class="fa-solid fa-circle-info text-lg"></i>
    </button>
</div>