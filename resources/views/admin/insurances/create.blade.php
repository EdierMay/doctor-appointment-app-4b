<x-admin-layout
    title="Nueva Aseguradora | HouseMD"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Aseguradoras',
            'href' => route('admin.insurances.index'),
        ],
        [
            'name' => 'Nueva Aseguradora',
        ],
    ]">

    <!-- Card -->
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow dark:bg-gray-800">
        <!-- Card Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrar Aseguradora</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Completa el formulario para agregar una nueva aseguradora al directorio</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.insurances.store') }}" method="POST" class="px-8 py-6 space-y-6">
            @csrf

            <!-- Nombre de la Empresa -->
            <div>
                <label for="nombre_empresa" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Nombre de la Empresa *
                </label>
                <input 
                    type="text" 
                    id="nombre_empresa" 
                    name="nombre_empresa" 
                    value="{{ old('nombre_empresa') }}"
                    class="w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('nombre_empresa') border-red-500 @enderror"
                    placeholder="Ej: Seguros Médicos ABC"
                    required
                >
                @error('nombre_empresa')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        <span class="font-medium">Error:</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Teléfono de Contacto -->
            <div>
                <label for="telefono_contacto" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Teléfono de Contacto *
                </label>
                <input 
                    type="text" 
                    id="telefono_contacto" 
                    name="telefono_contacto" 
                    value="{{ old('telefono_contacto') }}"
                    class="w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('telefono_contacto') border-red-500 @enderror"
                    placeholder="Ej: +34 XXX XXX XXX"
                    required
                >
                @error('telefono_contacto')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        <span class="font-medium">Error:</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Notas Adicionales -->
            <div>
                <label for="notas_adicionales" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                    Descripción Detallada (Opcional)
                </label>
                <textarea 
                    id="notas_adicionales" 
                    name="notas_adicionales" 
                    rows="5"
                    class="w-full px-4 py-2 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('notas_adicionales') border-red-500 @enderror"
                    placeholder="Agrega notas adicionales sobre esta aseguradora (cobertura, requisitos, etc.)"
                >{{ old('notas_adicionales') }}</textarea>
                @error('notas_adicionales')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        <span class="font-medium">Error:</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a 
                    href="{{ route('admin.insurances.index') }}" 
                    class="px-6 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 font-semibold rounded-lg transition duration-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                >
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200"
                >
                    Guardar Aseguradora
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>
