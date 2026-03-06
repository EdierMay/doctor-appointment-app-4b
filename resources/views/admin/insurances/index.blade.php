<x-admin-layout
    title="Aseguradoras | HouseMD"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Aseguradoras',
        ],
    ]">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Aseguradoras</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Directorio de empresas aseguradoras asociadas</p>
        </div>
        <a href="{{ route('admin.insurances.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            Nueva Aseguradora
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900 dark:border-green-700">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-medium text-green-800 dark:text-green-400">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-hidden rounded-lg shadow">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">NOMBRE DE LA EMPRESA</th>
                    <th scope="col" class="px-6 py-3">TELÉFONO DE CONTACTO</th>
                    <th scope="col" class="px-6 py-3">FECHA DE REGISTRO</th>
                    <th scope="col" class="px-6 py-3">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($insurances as $insurance)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $insurance->id }}</td>
                        <td class="px-6 py-4">{{ $insurance->nombre_empresa }}</td>
                        <td class="px-6 py-4">{{ $insurance->telefono_contacto }}</td>
                        <td class="px-6 py-4">{{ $insurance->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                    Ver
                                </a>
                                <a href="#" class="text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300 text-sm font-medium">
                                    Editar
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                    Eliminar
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No hay aseguradoras registradas. <a href="{{ route('admin.insurances.create') }}" class="text-blue-600 hover:underline dark:text-blue-400">Crear una nueva</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>
