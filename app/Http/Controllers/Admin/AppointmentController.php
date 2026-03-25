<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
// 1. Añadimos las clases para el PDF y el Correo
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReceipt;

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

        // 2. Guardamos la cita en una variable ($appointment) en lugar de solo crearla
        $appointment = Appointment::create($data);

        // Opcional: Cargamos las relaciones para que el PDF sepa el nombre del doctor y paciente
        $appointment->load('patient.user', 'doctor.user');

        // 3. Generamos el PDF usando la vista que creaste hace un momento
        $pdf = Pdf::loadView('pdf.receipt', ['appointment' => $appointment]);

        // 4. Enviamos el correo. 
        // Para la tarea, puedes poner tu correo personal aquí o el de Mailtrap para la demostración del video.
        $correoDestino = 'edierjairmaypech@gmail.com'; 
        
        Mail::to($correoDestino)->send(new AppointmentReceipt($appointment, $pdf->output()));

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Cita Creada',
                'text'  => 'La cita ha sido programada y el comprobante enviado exitosamente.'
            ]);
    }
}