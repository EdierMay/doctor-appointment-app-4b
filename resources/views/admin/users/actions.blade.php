@php
    // Evita eliminar al usuario autenticado
    $isCurrentUser = $user->id === auth()->id();
@endphp

<div class="flex items-center gap-2">
    {{-- Editar --}}
    <x-wire-button href="{{ route('admin.users.edit', $user) }}" blue xs title="Editar">
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- Eliminar --}}
    @if($isCurrentUser)
        <button type="button"
            onclick="Swal.fire({
                icon:'error',
                title:'Acción no permitida',
                text:'No puedes eliminar tu propio usuario.'
            })"
            class="inline-flex items-center px-2.5 py-1.5 bg-red-400 text-white rounded cursor-not-allowed"
            title="Usuario protegido">
            <i class="fa-solid fa-trash"></i>
        </button>
    @else
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form inline">
            @csrf
            @method('DELETE')
            <x-wire-button type="submit" red xs title="Eliminar">
                <i class="fa-solid fa-trash"></i>
            </x-wire-button>
        </form>
    @endif
</div>

{{-- Script para confirmación de eliminación --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.delete-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const userName = "{{ $user->name }}"; // nombre del usuario
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Se eliminará al usuario "${userName}". Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
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
