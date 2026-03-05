@php
    // No permitir eliminar/modificar al usuario autenticado
    $isCurrentUser = $user->id === auth()->id();

    // No permitir eliminar/modificar usuarios protegidos: proteger sólo a administradores
    // Hacemos la comprobación de forma robusta y case-insensitive
    $isProtected = $user->roles->pluck('name')
        ->map(fn($n) => trim(strtolower($n)))
        ->contains('administrador');

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
           onclick="event.stopPropagation();"
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
                    onclick="event.stopPropagation();"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-600 text-white hover:bg-red-700"
                    title="Eliminar">
                <i class="fa-solid fa-trash text-lg"></i>
            </button>
        </form>
    @endif
</div>

{{-- El manejo de confirmación de eliminación se realiza de forma global en el layout (delegación) --}}
