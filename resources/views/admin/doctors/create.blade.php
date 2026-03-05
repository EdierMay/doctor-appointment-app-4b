<x-admin-layout
    title="Crear Doctor"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Doctores', 'href' => route('admin.doctors.index')],
        ['name' => 'Crear']
    ]"
>

<x-wire-card>

    <form action="{{ route('admin.doctors.store') }}" method="POST">
        @csrf

        <div class="grid lg:grid-cols-2 gap-6">

            <div>
                <x-native-select label="Usuario (Doctor)" name="user_id" required>
                    <option value="">Selecciona un usuario</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->email }}</option>
                    @endforeach
                </x-native-select>
                <x-input-error for="user_id" />
            </div>

            <div>
                <x-native-select label="Especialidad" name="medical_specialty_id">
                    <option value="">Sin especialidad</option>
                    @foreach($specialties as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </x-native-select>
                <x-input-error for="medical_specialty_id" />
            </div>

            <div>
                <x-input label="Cédula / Licencia" name="cedula" class="{{ \Illuminate\Support\Arr::toCssClasses(['border-red-500' => \$errors->has('cedula')]) }}" />
                <x-input-error for="cedula" />
            </div>

            <div>
                <x-input label="Teléfono" name="phone" class="{{ \Illuminate\Support\Arr::toCssClasses(['border-red-500' => \$errors->has('phone')]) }}" />
                <x-input-error for="phone" />
            </div>

            <div class="lg:col-span-2">
                <x-input label="Dirección" name="address" />
                <x-input-error for="address" />
            </div>

            <div class="lg:col-span-2">
                <x-textarea label="Biografía" name="bio" rows="4" class="{{ \Illuminate\Support\Arr::toCssClasses(['border-red-500' => \$errors->has('bio')]) }}" />
                <x-input-error for="bio" />
            </div>

        </div>

        <div class="mt-6">
            <x-wire-button blue type="submit">Crear Doctor</x-wire-button>
            <x-wire-button white href="{{ route('admin.doctors.index') }}">Cancelar</x-wire-button>
        </div>
    </form>

</x-wire-card>

</x-admin-layout>
<x-admin-layout 
    title="Doctores | Crear" 
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Doctores', 'href' => route('admin.doctors.index')],
        ['name' => 'Nuevo'],
    ]"
>

<div class="max-w-2xl mx-auto mt-10">

    {{-- Card principal --}}
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">

        {{-- Encabezado --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                <i class="fa-solid fa-user-doctor text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                    Registro de Perfil Médico
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    La creación de doctores está centralizada en el módulo de usuarios.
                </p>
            </div>
        </div>


        {{-- Aviso profesional --}}
        <div class="flex gap-4 p-5 mb-8 rounded-xl bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800">

            <div class="flex items-start">
                <i class="fa-solid fa-circle-info text-blue-600 text-lg mt-1"></i>
            </div>

            <div>
                <h3 class="font-semibold text-blue-800 dark:text-blue-300">
                    Proceso de creación estructurado
                </h3>
                <p class="text-sm text-blue-700 dark:text-blue-200 mt-1 leading-relaxed">
                    Para registrar un nuevo doctor, primero debe existir una cuenta de usuario en el sistema.
                    Una vez creado el usuario y asignado el rol correspondiente, el perfil médico se generará automáticamente.
                </p>
            </div>
        </div>


        {{-- Botón principal --}}
        <div class="flex justify-center">
            <a href="{{ route('admin.users.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl 
                      bg-indigo-600 text-white font-medium
                      hover:bg-indigo-700 hover:scale-[1.02]
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                      transition-all duration-200 shadow-md">

                <i class="fa-solid fa-users"></i>
                Ir al módulo de Usuarios
            </a>
        </div>


        {{-- Separador --}}
        <div class="my-8 border-t border-gray-200 dark:border-gray-700"></div>


        {{-- Link secundario --}}
        <div class="text-center">
            <a href="{{ route('admin.doctors.index') }}" 
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition">
                <i class="fa-solid fa-arrow-left"></i>
                Volver al listado de doctores
            </a>
        </div>

    </div>

</div>

</x-admin-layout>