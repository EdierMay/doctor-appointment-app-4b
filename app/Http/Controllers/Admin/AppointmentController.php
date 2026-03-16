<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments.index');
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user', 'medicalSpecialty')->get();
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'reason'     => 'required|string',
        ]);
        
        $data['duration'] = 15;
        $data['status'] = 1;

        Appointment::create($data);

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Cita Creada',
                'text'  => 'La cita ha sido programada exitosamente.'
            ]);
    }
}
