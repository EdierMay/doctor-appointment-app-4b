@php
    // No permitir eliminar/modificar al usuario autenticado
    $isCurrentUser = $user->id === auth()->id();

    // No permitir eliminar/modificar usuarios protegidos por ID (1..4)
    $isProtected = (int) $user->id <= 4;

    $blocked = $isCurrentUser || $isProtected;
@endphp

<div class="flex items-center gap-2">
    {{-- Editar --}}
    @if($blocked)
        <button type="button"
            onclick="Swal.fire({
                icon:'error',
                title:'Acción no permitida',
                text:'Este usuario no puede modificarse.'
            })"
            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 cursor-not-allowed"
            title="Usuario protegido">
            <i class="fa-solid fa-pen-to-square text-lg"></i>
        </button>
    @else
        <a href="{{ route('admin.users.edit', $user) }}"
           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
           title="Editar">
            <i class="fa-solid fa-pen-to-square text-lg"></i>
        </a>
    @endif

    {{-- Eliminar --}}
    @if($blocked)
        <button type="button"
            onclick="Swal.fire({
                icon:'error',
                title:'Acción no permitida',
                text:'Este usuario no puede eliminarse.'
            })"
            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 cursor-not-allowed"
            title="Usuario protegido">
            <i class="fa-solid fa-trash text-lg"></i>
        </button>
    @else
        <form action="{{ route('admin.users.destroy', $user) }}"
              method="POST"
              class="inline user-delete-form">
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
    document.querySelectorAll('.user-delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Busca el nombre del usuario del renglón (si existe) o muestra texto genérico
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Se eliminará este usuario. Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endonce
