@php
    // Roles protegidos por ID (1..4)
    $isProtected = (int) $role->id <= 4;
@endphp

<div class="flex items-center gap-2">
    {{-- Editar --}}
    @if($isProtected)
        <button type="button"
            onclick="Swal.fire({
                icon:'error',
                title:'Acción no permitida',
                text:'Este rol no puede modificarse.'
            })"
            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200"
            title="Rol protegido">
            <i class="fa-solid fa-pen-to-square text-lg"></i>
        </button>
    @else
        <a href="{{ route('admin.roles.edit', $role) }}"
           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
           title="Editar">
            <i class="fa-solid fa-pen-to-square text-lg"></i>
        </a>
    @endif

    {{-- Eliminar --}}
    @if($isProtected)
        <button type="button"
            onclick="Swal.fire({
                icon:'error',
                title:'Acción no permitida',
                text:'Este rol no se puede eliminar.'
            })"
            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-200"
            title="Rol protegido">
            <i class="fa-solid fa-trash text-lg"></i>
        </button>
    @else
        <form action="{{ route('admin.roles.destroy', $role) }}"
              method="POST"
              class="inline role-delete-form">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-600 text-white hover:bg-red-700"
                    title="Eliminar">
                <i class="fa-solid fa-trash text-lg"></i>
            </button>
        </form>
    @endif
</div>

@once
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.role-delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Se eliminará este rol. Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endonce
