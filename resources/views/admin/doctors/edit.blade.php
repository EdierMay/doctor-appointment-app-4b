<x-admin-layout
    title="Editar Doctor | {{ $doctor->user->name }}"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Doctores', 'href' => route('admin.doctors.index')],
        ['name' => $doctor->user->name]
    ]"
>

    <div class="mb-2 text-sm text-gray-500">
        Dashboard / Doctores / <span class="text-gray-700">Editar</span>
    </div>

    <h2 class="text-2xl font-bold text-gray-900 mb-6">Editar Perfil Médico</h2>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg shadow-sm">
            <h3 class="text-sm font-bold text-red-800">
                Se encontraron {{ $errors->count() }} errores.
            </h3>
        </div>
    @endif

    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- HEADER --}}
        <div class="bg-white rounded-lg shadow-sm border p-6 flex justify-between items-center mb-6">

            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-xl font-bold text-gray-600">
                    {{ strtoupper(substr($doctor->user->name,0,1)) }}
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $doctor->user->name }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        Licencia: {{ $doctor->cedula ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="flex gap-3">

                <a href="{{ route('admin.doctors.index') }}"
                   class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Volver
                </a>

                {{-- BOTÓN EXACTO COMO EL DEL MAESTRO --}}
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-sm font-medium flex items-center gap-2">
                    <i class="fa-solid fa-check text-sm"></i>
                    Guardar cambios
                </button>

            </div>
        </div>

        {{-- FORMULARIO --}}
        <div class="bg-white rounded-lg shadow-sm border p-6 space-y-6">

            {{-- Especialidad --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Especialidad
                </label>
                <select name="medical_specialty_id"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach($specialties as $specialty)
                        <option value="{{ $specialty->id }}"
                            {{ old('medical_specialty_id',$doctor->medical_specialty_id)==$specialty->id?'selected':'' }}>
                            {{ $specialty->name }}
                        </option>
                    @endforeach
                </select>
                @error('medical_specialty_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cédula --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Número de licencia médica
                </label>
                <input type="text"
                       name="cedula"
                       value="{{ old('cedula',$doctor->cedula) }}"
                       class="w-full border {{ $errors->has('cedula')?'border-red-500':'border-gray-300' }} rounded-md px-3 py-2 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">

                @error('cedula')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Biografía --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Biografía
                </label>
                <textarea name="bio"
                          rows="4"
                          class="w-full border {{ $errors->has('bio')?'border-red-500':'border-gray-300' }} rounded-md px-3 py-2 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio',$doctor->bio) }}</textarea>

                @error('bio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

    </form>

</x-admin-layout>