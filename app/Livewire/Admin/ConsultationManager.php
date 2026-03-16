<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Appointment;

class ConsultationManager extends Component
{
    public $isOpen = false;
    public $isHistoryModalOpen = false;
    public $activeTab = 'consulta';

    public $appointmentId;
    public $appointment;
    public $pastConsultations = [];

    public $diagnosis = '';
    public $treatment = '';
    public $notes = '';

    public $medications = [];

    #[On('openConsultationModal')]
    public function loadAppointment($appointmentId)
    {
        $this->appointmentId = $appointmentId;
        $this->appointment = Appointment::with(['patient.user', 'doctor.user'])->findOrFail($appointmentId);
        
        $this->diagnosis = '';
        $this->treatment = '';
        $this->notes = '';
        
        $this->medications = [
            ['name' => '', 'dose' => '', 'frequency' => '']
        ];
        
        $this->pastConsultations = Appointment::where('patient_id', $this->appointment->patient_id)
                                ->where('id', '!=', $this->appointment->id)
                                ->where('status', 2)
                                ->orderBy('date', 'desc')
                                ->get();
                                
        $this->isOpen = true;
        $this->isHistoryModalOpen = false;
        $this->activeTab = 'consulta';
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function openHistoryModal()
    {
        $this->isHistoryModalOpen = true;
    }

    public function closeHistoryModal()
    {
        $this->isHistoryModalOpen = false;
    }

    public function addMedication()
    {
        $this->medications[] = ['name' => '', 'dose' => '', 'frequency' => ''];
    }

    public function removeMedication($index)
    {
        unset($this->medications[$index]);
        $this->medications = array_values($this->medications);
    }

    public function save()
    {
        $this->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'medications.*.name' => 'required_with:medications.*.dose|string',
        ]);

        // Guardar la información de la cita
        $this->appointment->update([
            'status' => 2, // Completado
            'reason' => $this->diagnosis . "\n\nTratamiento: " . $this->treatment . "\n\nNotas: " . $this->notes,
        ]);

        // En un caso real guardaríamos las medicinas en una tabla `prescriptions`.
        
        $this->isOpen = false;
        
        $this->dispatch('swal', [
            'title' => 'Consulta Guardada',
            'text' => 'La consulta médica se registró exitosamente.',
            'icon' => 'success'
        ]);
        
        // Refrescar la tabla actual (suponiendo que haya un evento refreshDatatable)
        $this->dispatch('refreshDatatable');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
