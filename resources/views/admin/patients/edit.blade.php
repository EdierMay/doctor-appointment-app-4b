<x-admin-layout 
        title="Editar Paciente | Healthify"
        :breadcrumbs="[
                ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
                ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
                ['name' => 'Editar'],
        ]">

        {{--
                VIEW: admin.patients.edit

                Propósito:
                - Presentar y editar el expediente médico de un paciente en un formulario de pestañas.

                Variables esperadas (pasadas desde `PatientController@edit`):
                - $patient       : App\Models\Patient (relación 'user' y 'bloodType' cargadas recomendadas)
                - $blood_types   : Collection de App\Models\BloodType para el selector de tipo de sangre
                - $errors        : Illuminate\Support\ViewErrorBag (disponible automáticamente al usar validación)
                - session('swal'): arreglo con keys ['icon','title','text'] para mostrar alertas (opcional)

                Estructura / comportamiento principal:
                - Cabecera: muestra nombre, email y foto del usuario asociado ($patient->user).
                - Form: <form method="POST" action="route('admin.patients.update', $patient)"> con @csrf y @method('PUT').
                - Sistema de pestañas: cuatro secciones (datos, antecedentes, general, emergencia). Se usa la variable
                    $initialTab para seleccionar la pestaña que contiene errores de validación.
                - UX de validación: la vista define un array local `$tabErrores` que agrupa campos por pestaña.
                    Si hay errores en alguno de esos campos, la pestaña inicial se ajusta para mostrarlos.

                Componentes reutilizados:
                - <x-tabs> / <x-tab-link> / <x-tab-content> : wrappers que controlan la navegación entre pestañas.
                - <x-input-error for="field"> : muestra $errors->first('field') con estilo.

                Reglas de validación (fuente):
                - Las reglas están en `App\Http\Controllers\Admin\PatientController` (store/update).
                    Cambiar reglas allí afectará los mensajes y el comportamiento de esta vista.

                Integración / rutas relevantes:
                - Ruta de envío: admin.patients.update (PUT)
                - Ruta de regreso: admin.patients.index
                - Enlace a edición de usuario: admin.users.edit (abre en pestaña nueva)

                Notas de seguridad y compatibilidad:
                - El formulario incluye @csrf y @method('PUT'). No tocar estos tokens.
                - Validación de servidor es la fuente de la verdad; la vista solo facilita UX (foco en pestañas y errores).

                Edge cases y recomendaciones:
                - Asegúrate de que $patient->user exista antes de renderizar (controlador lo debe cargar).
                - $blood_types debe ser Collection (aunque vacío, el select funciona mostrando 'Seleccione tipo de sangre').
                - No traducir automáticamente párrafos largos sin revisar tono/consistencia. Las etiquetas y botones son seguras.

                QA rapido:
                - Enviar formulario con campos inválidos y comprobar que la pestaña activa cambia al grupo con errores.
                - Verificar que los mensajes de validación usen `resources/lang/es/validation.php` (atributos incluidos).

                Historial de cambios: bloque de documentación añadido para facilitar mantenimiento.
        --}}

    {{-- LÓGICA DE VALIDACIÓN UX (Manejada desde el Controlador/Vista) --}}
    @php
        $tabErrores = [
            'antecedentes' => ['surgical_history', 'chronic_conditions', 'family_history'],
            'general'      => ['blood_type_id', 'allergies', 'observations'],
            'emergencia'   => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
        ];

        // Por defecto la pestaña es 'datos'
        $initialTab = 'datos';

        // Si hay errores de validación, detectamos en qué grupo están
        foreach ($tabErrores as $tab => $campos) {
            if ($errors->hasAny($campos)) {
                $initialTab = $tab;
                break;
            }
        }
    @endphp

    @if(session('swal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire(@json(session('swal')));
            });
        </script>
    @endif

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST" class="max-w-5xl mx-auto mt-8 space-y-6">
        @csrf
        @method('PUT')

        {{-- Cabecera Profesional con Foto --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col lg:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <img class="h-20 w-20 rounded-full object-cover border-2 border-indigo-500 shadow-sm" 
                     src="{{ $patient->user->profile_photo_url }}" 
                     alt="{{ $patient->user->name }}">
                
                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 uppercase tracking-tight">{{ $patient->user->name }}</h3>
                    <p class="text-sm text-gray-500 font-medium">{{ $patient->user->email }}</p>
                    <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mt-1">Expediente Médico</p>
                </div>
            </div>

            <div class="flex gap-3 mt-4 lg:mt-0">
                <a href="{{ route('admin.patients.index') }}" 
                   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-200 hover:bg-gray-50 transition duration-200">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 shadow-md transition duration-200">
                    <i class="fa-solid fa-check mr-2"></i> Guardar Cambios
                </button>
            </div>
        </div>

        {{-- SISTEMA DE PESTAÑAS REFACTORIZADO CON COMPONENTES --}}
        <x-tabs :active="$initialTab">
            
            {{-- Slot del Header (Los botones de navegación) --}}
            <x-slot name="header">
                <x-tab-link tab="datos">
                    <i class="fa-solid fa-user-medical mr-2"></i> Datos Personales
                </x-tab-link>

                <x-tab-link tab="antecedentes" :error="$errors->hasAny($tabErrores['antecedentes'])">
                    <i class="fa-solid fa-notes-medical mr-2"></i> Antecedentes
                </x-tab-link>

                <x-tab-link tab="general" :error="$errors->hasAny($tabErrores['general'])">
                    <i class="fa-solid fa-circle-info mr-2"></i> Información General
                </x-tab-link>

                <x-tab-link tab="emergencia" :error="$errors->hasAny($tabErrores['emergencia'])">
                    <i class="fa-solid fa-briefcase-medical mr-2"></i> Emergencia
                </x-tab-link>
            </x-slot>

            {{-- Contenido de las pestañas (El cuerpo principal) --}}
            <div class="p-8 bg-white dark:bg-gray-800 shadow rounded-b-lg border-t-0">
                
                {{-- 1. Pestaña: Datos Personales --}}
                <x-tab-content tab="datos">
                    <div class="space-y-6 animate-fadeIn">
                        <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-4 rounded-r-lg flex justify-between items-center mb-6">
                            <div class="flex items-center">
                                <i class="fa-solid fa-user-gear text-blue-500 text-2xl mr-4"></i>
                                <div>
                                    <h4 class="text-sm font-bold text-blue-800 dark:text-blue-400 uppercase tracking-tight">Información de la Cuenta</h4>
                                    <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">Los datos básicos de acceso se gestionan desde el módulo de usuarios.</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.edit', $patient->user) }}" target="_blank" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-blue-700 transition shadow-sm">
                                Editar Usuario <i class="fa-solid fa-external-link ml-1"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Nombre Completo</span>
                                <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $patient->user->name }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Correo Electrónico</span>
                                <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $patient->user->email }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Teléfono Principal</span>
                                <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $patient->user->phone ?? 'Sin registrar' }}</p>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Dirección de Domicilio</span>
                                <p class="text-gray-800 dark:text-gray-200 font-semibold text-sm">{{ $patient->user->address ?? 'No registrada' }}</p>
                            </div>
                        </div>
                    </div>
                </x-tab-content>

                {{-- 2. Pestaña: Antecedentes --}}
                <x-tab-content tab="antecedentes">
                    <div class="space-y-6 animate-fadeIn">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Historial Quirúrgico</label>
                                <textarea name="surgical_history" rows="3" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 shadow-sm focus:ring-indigo-500">{{ old('surgical_history', $patient->surgical_history) }}</textarea>
                                <x-input-error for="surgical_history" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Condiciones Crónicas</label>
                                <textarea name="chronic_conditions" rows="3" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 shadow-sm focus:ring-indigo-500">{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                                <x-input-error for="chronic_conditions" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">Antecedentes Familiares</label>
                                <textarea name="family_history" rows="3" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 shadow-sm focus:ring-indigo-500" placeholder="Enfermedades hereditarias de padres o abuelos...">{{ old('family_history', $patient->family_history) }}</textarea>
                                <x-input-error for="family_history" />
                            </div>
                        </div>
                    </div>
                </x-tab-content>

                {{-- 3. Pestaña: Información General --}}
                <x-tab-content tab="general">
                    <div class="space-y-6 animate-fadeIn">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tipo de Sangre</label>
                                <select name="blood_type_id" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 focus:ring-indigo-500">
                                    <option value="">Seleccione tipo de sangre</option>
                                    @foreach($blood_types as $type)
                                        <option value="{{ $type->id }}" {{ old('blood_type_id', $patient->blood_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="blood_type_id" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Alergias Conocidas</label>
                                <input type="text" name="allergies" value="{{ old('allergies', $patient->allergies) }}" placeholder="Ej: Penicilina, polen..." class="w-full rounded-lg border-gray-300 dark:bg-gray-700 focus:ring-indigo-500">
                                <x-input-error for="allergies" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Observaciones Médicas</label>
                                <textarea name="observations" rows="4" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 focus:ring-indigo-500" placeholder="Notas adicionales del facultativo...">{{ old('observations', $patient->observations) }}</textarea>
                                <x-input-error for="observations" />
                            </div>
                        </div>
                    </div>
                </x-tab-content>

                {{-- 4. Pestaña: Contacto de Emergencia --}}
                <x-tab-content tab="emergencia">
                    <div class="space-y-6 animate-fadeIn">
                        <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 p-6 rounded-xl grid grid-cols-1 md:grid-cols-2 gap-6 shadow-sm">
                            <div class="md:col-span-2 flex items-center text-red-700 dark:text-red-400 font-bold uppercase text-xs tracking-widest border-b border-red-100 dark:border-red-900/30 pb-2 mb-2">
                                <i class="fa-solid fa-phone-flip mr-2"></i> Persona de Contacto Rápido
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-red-600 dark:text-red-300 uppercase mb-1">Nombre Completo</label>
                                <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" class="w-full rounded-lg border-red-200 dark:bg-gray-800 dark:border-red-900 focus:ring-red-500">
                                <x-input-error for="emergency_contact_name" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-red-600 dark:text-red-300 uppercase mb-1">Teléfono de Contacto</label>
                                <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" class="w-full rounded-lg border-red-200 dark:bg-gray-800 dark:border-red-900 focus:ring-red-500">
                                <x-input-error for="emergency_contact_phone" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-red-600 dark:text-red-300 uppercase mb-1">Parentesco / Relación</label>
                                <input type="text" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" class="w-full rounded-lg border-red-200 dark:bg-gray-800 dark:border-red-900 focus:ring-red-500">
                                <x-input-error for="emergency_contact_relationship" />
                            </div>
                        </div>
                    </div>
                </x-tab-content>

            </div>
        </x-tabs>
    </form>

    <style>
        [x-cloak] { display: none !important; }
        .animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</x-admin-layout>