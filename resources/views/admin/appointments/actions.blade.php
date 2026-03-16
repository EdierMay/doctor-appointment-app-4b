@php
    // $appointment viene desde el Datatable
@endphp

<div class="flex items-center gap-2">
    {{-- Editar o reprogramar (opcional) --}}
    <a href="#" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500 text-white hover:bg-blue-600 shadow-sm transition-colors" title="Editar cita">
        <i class="fa-solid fa-pen-to-square text-sm"></i>
    </a>

    {{-- Botón de Gestor de Consultas (Estetoscopio) --}}
    <button type="button" 
            onclick="Livewire.dispatch('openConsultationModal', { appointmentId: {{ $appointment->id }} })"
            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-500 text-white hover:bg-green-600 shadow-sm transition-colors" 
            title="Iniciar Consulta">
        <i class="fa-solid fa-stethoscope text-sm"></i>
    </button>
</div>
