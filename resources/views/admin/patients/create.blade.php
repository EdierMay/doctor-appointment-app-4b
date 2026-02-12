<x-admin-layout 
    title="Nuevo Paciente | Healthify" 
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
        ['name' => 'Nuevo'],
    ]"
>
    <div class="mt-8 max-w-xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        {{-- Siguiendo el video: La creación se hace desde el módulo de Usuarios --}}
        <div class="p-4 mb-6 bg-blue-50 border-l-4 border-blue-400 text-blue-700">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-info mr-3 text-xl"></i>
                <p class="text-sm">
                    <strong>Nota:</strong> Para registrar un nuevo paciente, primero debe existir como usuario. 
                    Vaya al módulo de <strong>Usuarios</strong> para vincular un nuevo expediente médico.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-center py-6">
            <a href="{{ route('admin.users.index') }}" 
               class="inline-flex items-center px-6 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-md">
                <i class="fa-solid fa-users mr-2"></i>
                Ir a Usuarios para registrar
            </a>
        </div>

        <div class="mt-6 border-t pt-4 flex items-center justify-center">
            <a href="{{ route('admin.patients.index') }}" 
               class="text-sm text-gray-500 hover:text-gray-700 transition">
                Volver al listado de pacientes
            </a>
        </div>
    </div>
</x-admin-layout>