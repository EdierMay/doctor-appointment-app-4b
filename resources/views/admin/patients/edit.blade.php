<x-admin-layout 
    title="Editar Paciente | Healthify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Pacientes', 'href' => route('admin.patients.index')],
        ['name' => 'Editar'],
    ]">

    {{-- LÓGICA DE VALIDACIÓN UX (Nueva) --}}
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

        {{-- Sistema de 4 Pestañas (Inicializado con la variable PHP) --}}
        <div x-data="{ tab: '{{ $initialTab }}' }" class="space-y-6">
            
            {{-- Navegación con Iconos --}}
            <div class="flex border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900 rounded-t-lg overflow-hidden shadow-sm">
                
                {{-- Tab 1: Datos --}}
                <button type="button" @click="tab = 'datos'" 
                        :class="tab === 'datos' ? 'border-indigo-500 text-indigo-600 bg-white dark:bg-gray-800 font-bold' : 'border-transparent text-gray-500 hover:text-indigo-500 hover:bg-gray-100'" 
                        class="flex-1 py-4 px-2 text-center border-b-2 text-sm transition-all duration-300">
                    <i class="fa-solid fa-user-medical mr-2"></i> Datos Personales
                </button>

                {{-- Tab 2: Antecedentes --}}
                <button type="button" @click="tab = 'antecedentes'" 
                        :class="tab === 'antecedentes' ? 'border-indigo-500 text-indigo-600 bg-white dark:bg-gray-800 font-bold' : 'border-transparent text-gray-500 hover:text-indigo-500 hover:bg-gray-100'" 
                        class="flex-1 py-4 px-2 text-center border-b-2 text-sm transition-all duration-300 relative">
                    <i class="fa-solid fa-notes-medical mr-2"></i> Antecedentes
                    @if($errors->hasAny($tabErrores['antecedentes']))
                        {{-- MEJORA VISUAL: Icono más grande, rojo brillante y con fondo blanco para resaltar --}}
                        <span class="absolute top-2 right-2 flex h-4 w-4">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-white justify-center items-center text-[10px]">
                            <i class="fa-solid fa-exclamation"></i>
                          </span>
                        </span>
                    @endif
                </button>

                {{-- Tab 3: Información General --}}
                <button type="button" @click="tab = 'general'" 
                        :class="tab === 'general' ? 'border-indigo-500 text-indigo-600 bg-white dark:bg-gray-800 font-bold' : 'border-transparent text-gray-500 hover:text-indigo-500 hover:bg-gray-100'" 
                        class="flex-1 py-4 px-2 text-center border-b-2 text-sm transition-all duration-300 relative">
                    <i class="fa-solid fa-circle-info mr-2"></i> Información General
                    @if($errors->hasAny($tabErrores['general']))
                         {{-- MEJORA VISUAL --}}
                        <span class="absolute top-2 right-2 flex h-4 w-4">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-white justify-center items-center text-[10px]">
                            <i class="fa-solid fa-exclamation"></i>
                          </span>
                        </span>
                    @endif
                </button>

                {{-- Tab 4: Emergencia --}}
                <button type="button" @click="tab = 'emergencia'" 
                        :class="tab === 'emergencia' ? 'border-indigo-500 text-indigo-600 bg-white dark:bg-gray-800 font-bold' : 'border-transparent text-gray-500 hover:text-indigo-500 hover:bg-gray-100'" 
                        class="flex-1 py-4 px-2 text-center border-b-2 text-sm transition-all duration-300 relative">
                    <i class="fa-solid fa-briefcase-medical mr-2"></i> Emergencia
                    @if($errors->hasAny($tabErrores['emergencia']))
                         {{-- MEJORA VISUAL --}}
                        <span class="absolute top-2 right-2 flex h-4 w-4">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-white justify-center items-center text-[10px]">
                            <i class="fa-solid fa-exclamation"></i>
                          </span>
                        </span>
                    @endif
                </button>
            </div>

            <div class="p-8 bg-white dark:bg-gray-800 shadow rounded-b-lg border-t-0">

                {{-- 1. Pestaña: Datos Personales (Lectura de Usuario) --}}
                <div x-show="tab === 'datos'" x-cloak class="space-y-6 animate-fadeIn">
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

                {{-- 2. Pestaña: Antecedentes --}}
                <div x-show="tab === 'antecedentes'" x-cloak class="space-y-6 animate-fadeIn">
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

                {{-- 3. Pestaña: Información General --}}
                <div x-show="tab === 'general'" x-cloak class="space-y-6 animate-fadeIn">
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

                {{-- 4. Pestaña: Contacto de Emergencia --}}
                <div x-show="tab === 'emergencia'" x-cloak class="space-y-6 animate-fadeIn">
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

            </div>
        </div>
    </form>

    <style>
        [x-cloak] { display: none !important; }
        .animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</x-admin-layout>