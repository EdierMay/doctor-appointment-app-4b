<x-admin-layout
    title="Horarios del Doctor | Healthify"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Doctores',
            'href' => route('admin.doctors.index'),
        ],
        [
            'name' => 'Horarios',
        ],
    ]"
>
    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">
            Horarios del Médico: {{ $doctor->user->name }}
        </h2>
        <a href="{{ route('admin.doctors.index') }}" 
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a Doctores
        </a>
    </div>

    @if($appointments->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th scope="col" class="px-6 py-4">Fecha</th>
                            <th scope="col" class="px-6 py-4">Horario</th>
                            <th scope="col" class="px-6 py-4">Paciente</th>
                            <th scope="col" class="px-6 py-4">Motivo</th>
                            <th scope="col" class="px-6 py-4">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700">
                                        <i class="fa-regular fa-clock"></i> 
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                            {{ substr($appointment->patient->user->name ?? 'P', 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $appointment->patient->user->name ?? 'Desconocido' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 truncate max-w-xs text-gray-600" title="{{ $appointment->reason }}">
                                    {{ Str::limit($appointment->reason, 40) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($appointment->status == 1)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-blue-400">Programado</span>
                                    @elseif($appointment->status == 2)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-green-400">Completado</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-red-400">Cancelado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-12 shadow-sm text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-500 mb-4">
                <i class="fa-regular fa-calendar-xmark text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Sin horarios programados</h3>
            <p class="text-gray-500 max-w-sm mx-auto">
                Actualmente el doctor <strong>{{ $doctor->user->name }}</strong> no tiene ninguna cita asignada en su agenda.
            </p>
        </div>
    @endif
</x-admin-layout>
