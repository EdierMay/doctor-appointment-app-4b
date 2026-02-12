<x-admin-layout 
    title="Editar Paciente | Healthify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
        ['name' => 'Editar'],
    ]">

    @if(session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire(@json(session('swal')));
            });
        </script>
    @endif

    <div class="max-w-4xl mx-auto mt-8 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="mb-6 border-b pb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                <i class="fa-solid fa-user-medical mr-2 text-indigo-500"></i>
                Expediente de: {{ $patient->user->name }}
            </h3>
        </div>

        <form action="{{ route('admin.patients.update', $patient) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tipo de Sangre (Catálogo) --}}
                <div>
                    <label for="blood_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        Tipo de Sangre
                    </label>
                    <select id="blood_type_id" name="blood_type_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Seleccione una opción</option>
                        @foreach($blood_types as $type)
                            <option value="{{ $type->id }}" {{ old('blood_type_id', $patient->blood_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Alergias --}}
                <div>
                    <label for="allergies" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                        Alergias
                    </label>
                    <input type="text" id="allergies" name="allergies" value="{{ old('allergies', $patient->allergies) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            {{-- Historial Quirúrgico --}}
            <div>
                <label for="surgical_history" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Historial Quirúrgico
                </label>
                <textarea id="surgical_history" name="surgical_history" rows="2"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('surgical_history', $patient->surgical_history) }}</textarea>
            </div>

            {{-- Contacto de Emergencia --}}
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-3">
                    <h4 class="text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Contacto de Emergencia</h4>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Nombre</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                        class="mt-1 block w-full text-sm rounded-md border-gray-300 dark:bg-gray-800">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Teléfono</label>
                    <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                        class="mt-1 block w-full text-sm rounded-md border-gray-300 dark:bg-gray-800">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400">Parentesco</label>
                    <input type="text" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                        class="mt-1 block w-full text-sm rounded-md border-gray-300 dark:bg-gray-800">
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.patients.index') }}" 
                   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-200 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>