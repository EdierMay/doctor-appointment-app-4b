<x-admin-layout
    title="Nueva Cita Médica | Healthify"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Citas',
            'href' => route('admin.appointments.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ]"
>
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-800">
            Nuevo
        </h2>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center mb-2 text-red-700">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                <span class="font-bold">Por favor, corrige los siguientes errores:</span>
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf

        {{-- Contenedor superior: Buscar disponibilidad --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-sm font-bold text-gray-800 mb-1">Buscar disponibilidad</h3>
            <p class="text-xs text-gray-500 mb-4">Encuentra el horario perfecto para tu cita.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Fecha</label>
                    <div class="relative">
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                            class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 pl-3 pr-10 py-2 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Hora</label>
                    <div class="flex items-center rounded-lg border border-gray-300 bg-white px-2 py-1">
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', '08:00') }}" required
                            class="border-none bg-transparent text-gray-900 text-sm focus:ring-0 p-1 w-full text-center">
                        <span class="text-gray-400 mx-1">-</span>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', '09:00') }}" required
                            class="border-none bg-transparent text-gray-900 text-sm focus:ring-0 p-1 w-full text-center">
                        <i class="fa-regular fa-clock text-gray-400 ml-1 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Especialidad (opcional)</label>
                    <input type="text" placeholder="Ej: Endocrinología"
                        class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 transition-colors">
                </div>

                <div>
                    <button type="button" class="w-full px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                        Buscar disponibilidad
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">
                
                @foreach($doctors as $index => $doctor)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 relative overflow-hidden transition-all cursor-pointer doctor-card hover:border-indigo-300 hover:shadow-md h-full" 
                     data-doctor-id="{{ $doctor->id }}" data-doctor-name="{{ $doctor->user->name }}">
                    {{-- Indicador de selección lateral --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 doctor-indicator {{ $index === 0 ? '' : 'hidden' }}"></div>

                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full {{ $index % 2 === 0 ? 'bg-indigo-100 text-indigo-600' : 'bg-blue-50 text-blue-500' }} flex items-center justify-center font-bold text-lg flex-shrink-0">
                            {{ substr($doctor->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-base font-bold text-gray-900">{{ $doctor->user->name }}</h4>
                            <p class="text-xs text-indigo-500 font-medium">{{ $doctor->medicalSpecialty->name ?? 'Medicina General' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-600 mb-2 font-medium">Horarios disponibles (Ejemplo):</p>
                        <div class="flex flex-wrap gap-2">
                            <label class="cursor-pointer">
                                <span class="inline-block px-4 py-1.5 text-xs font-medium bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-md transition-colors hover:bg-indigo-100">
                                    08:00
                                </span>
                            </label>
                            <label class="cursor-pointer">
                                <span class="inline-block px-4 py-1.5 text-xs font-medium bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-md transition-colors hover:bg-indigo-100">
                                    09:00
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
                
                {{-- Input Oculto real para enviar form, actualizado por JS --}}
                <input type="hidden" name="doctor_id" id="doctor_id_input" value="{{ old('doctor_id', $doctors->first()->id ?? '') }}" required>

            </div>

            {{-- Columna Derecha: Resumen de la cita y Confirmación --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Resumen de la cita</h3>
                    
                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Doctor:</span>
                            <span class="font-medium text-gray-900" id="resumen_doctor">{{ $doctors->first()->user->name ?? 'No seleccionado' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Fecha:</span>
                            <span class="font-medium text-gray-900" id="resumen_fecha">{{ date('Y-m-d') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Horario:</span>
                            <span class="font-medium text-gray-900" id="resumen_horario">08:00 - 08:15</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Duración:</span>
                            <span class="font-medium text-gray-900">15 minutos</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="patient_id" class="block text-xs font-medium text-gray-700 mb-1">Paciente</label>
                        <select name="patient_id" id="patient_id" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 transition-colors">
                            <option value="" disabled selected>Seleccione...</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="reason" class="block text-xs font-medium text-gray-700 mb-1">Motivo de la cita</label>
                        <textarea name="reason" id="reason" rows="3" required placeholder="Chequeo de medicamentos"
                            class="w-full rounded-lg border border-indigo-500 bg-white text-gray-900 text-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 transition-colors">{{ old('reason') }}</textarea>
                    </div>

                    <button type="submit" 
                            class="w-full px-4 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors text-center cursor-pointer">
                        Confirmar cita
                    </button>
                    
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Referencias a los inputs del formulario
            const dateInput = document.getElementById('date');
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            
            // Referencias a los elementos del resumen
            const resumenFecha = document.getElementById('resumen_fecha');
            const resumenHorario = document.getElementById('resumen_horario');
            const resumenDoctor = document.getElementById('resumen_doctor');

            // Lógica de selección de doctores
            const doctorCards = document.querySelectorAll('.doctor-card');
            const doctorInputHidden = document.getElementById('doctor_id_input');

            // Inicializar selección visual
            function updateDoctorSelection(selectedId) {
                doctorCards.forEach(card => {
                    const id = card.getAttribute('data-doctor-id');
                    const indicator = card.querySelector('.doctor-indicator');
                    
                    if (id === selectedId) {
                        card.classList.remove('opacity-70');
                        indicator.classList.remove('hidden');
                        resumenDoctor.textContent = card.getAttribute('data-doctor-name');
                    } else {
                        card.classList.add('opacity-70');
                        indicator.classList.add('hidden');
                    }
                });
            }

            // Click listener en las tarjetas
            doctorCards.forEach(card => {
                card.addEventListener('click', function() {
                    const id = this.getAttribute('data-doctor-id');
                    doctorInputHidden.value = id;
                    updateDoctorSelection(id);
                });
            });

            // Llamada inicial para fijar el activo si hay un old() value
            if(doctorInputHidden.value) {
                updateDoctorSelection(doctorInputHidden.value);
            }

            // Sincronizar fechas en resumen
            function updateResumen() {
                resumenFecha.textContent = dateInput.value;
                resumenHorario.textContent = `${startTimeInput.value} - ${endTimeInput.value}`;
            }

            dateInput.addEventListener('change', updateResumen);
            startTimeInput.addEventListener('change', updateResumen);
            endTimeInput.addEventListener('change', updateResumen);
            
            updateResumen();
        });
    </script>
</x-admin-layout>
