<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use App\Models\MedicalSpecialty;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.doctors.index');
    }

    public function create()
    {
        // Usuarios con rol 'doctor' que no tengan perfil médico aún
        $users = User::role('doctor')->get()->filter(function($u){
            return !Doctor::where('user_id', $u->id)->exists();
        });

        $specialties = MedicalSpecialty::all();

        return view('admin.doctors.create', compact('users', 'specialties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:doctors,user_id',
            'medical_specialty_id' => 'nullable|exists:medical_specialties,id',
            // cédula: solo dígitos, entre 7 y 10
            'cedula' => ['nullable', 'digits_between:7,10'],
            'address' => 'nullable|string|max:255',
            // teléfono: exactamente 10 dígitos
            'phone' => ['nullable', 'digits:10'],
            // biografía: máximo 100 caracteres
            'bio' => 'nullable|string|max:100',
        ]);

        $doctor = Doctor::create($data);

        return redirect()->route('admin.doctors.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Doctor creado',
                'text' => 'El perfil médico se creó correctamente.'
            ]);
    }

    public function edit(Doctor $doctor)
    {
        $specialties = MedicalSpecialty::all();
        return view('admin.doctors.edit', compact('doctor', 'specialties'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'medical_specialty_id' => 'nullable|exists:medical_specialties,id',
            // cédula: solo dígitos, entre 7 y 10
            'cedula' => ['nullable', 'digits_between:7,10'],
            'address' => 'nullable|string|max:255',
            // teléfono: exactamente 10 dígitos
            'phone' => ['nullable', 'digits:10'],
            // biografía: máximo 100 caracteres
            'bio' => 'nullable|string|max:100',
        ]);

        $doctor->update($data);

        return redirect()->route('admin.doctors.show', $doctor)
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Actualizado',
                'text' => 'Perfil médico actualizado.'
            ]);
    }

    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('admin.doctors.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Eliminado',
                'text' => 'Perfil médico eliminado.'
            ]);
    }
}