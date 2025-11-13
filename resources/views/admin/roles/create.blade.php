<x-admin-layout title="Roles | HouseMD" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Roles', 'href' => route('admin.roles.index')],
    ['name' => 'Nuevo'],
]">

    <div class="mt-8 max-w-xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6" id="create-role-form">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Nombre del rol
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Ej. Administrador"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                    autofocus
                />
                @error('name')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.roles.index') }}" 
                   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
