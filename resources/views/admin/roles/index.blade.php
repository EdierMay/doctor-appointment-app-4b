<x-admin-layout
    title="Roles | HouseMD"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Roles',
        ],
    ]"
>

    {{-- Botón para crear un nuevo rol --}}
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.roles.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- Tabla de roles --}}
    @livewire('admin.data-tables.role-table')

</x-admin-layout>
