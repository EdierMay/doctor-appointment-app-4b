<x-admin-layout 
    title="Detalle del Paciente | Healthify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
        ['name' => 'Detalle'],
    ]">

    <div class="max-w-4xl mx-auto mt-8">
        {{-- Tarjeta de Información General --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg">
                    <i class="fa-solid fa-file-medical mr-2"></i>
                    Expediente Clínico Digital
                </h3>
                <a href="{{ route('admin.patients.edit', $patient) }}" class="text-indigo-100 hover:text-white transition">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Editar
                </a>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Datos del Usuario --}}
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-indigo-500 uppercase tracking-wider border-b pb-1">Información Personal</h4>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Nombre Completo</p>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $patient->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Correo Electrónico</p>
                            <p class="text-gray-800 dark:text-gray-200">{{ $patient->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Tipo de Sangre</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fa-solid fa-droplet mr-1"></i>
                                {{ $patient->bloodType->name ?? 'No especificado' }}
                            </span>
                        </div>
                    </div>

                    {{-- Datos Clínicos --}}
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-indigo-500 uppercase tracking-wider border-b pb-1">Perfil Clínico</h4>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Alergias</p>
                            <p class="text-gray-800 dark:text-gray-200">{{ $patient->allergies ?? 'Ninguna registrada' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Historial Quirúrgico</p>
                            <p class="text-gray-800 dark:text-gray-200 text-sm italic">
                                {{ $patient->surgical_history ?? 'Sin registros previos' }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200 dark:border-gray-700">

                {{-- Contacto de Emergencia --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl border border-gray-100 dark:border-gray-600">
                    <h4 class="text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider mb-4 flex items-center">
                        <i class="fa-solid fa-phone-flip mr-2 text-red-500"></i>
                        Contacto de Emergencia
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Nombre</p>
                            <p class="font-bold text-gray-800 dark:text-gray-100">{{ $patient->emergency_contact_name ?? '---' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Teléfono</p>
                            <p class="font-bold text-gray-800 dark:text-gray-100">{{ $patient->emergency_contact_phone ?? '---' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Parentesco</p>
                            <p class="font-bold text-gray-800 dark:text-gray-100">{{ $patient->emergency_contact_relationship ?? '---' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-start">
                    <a href="{{ route('admin.patients.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition flex items-center">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Volver al listado de pacientes
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>