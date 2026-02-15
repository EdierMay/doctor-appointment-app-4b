<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\BloodType;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Mostrar listado de pacientes.
     */
    public function index()
    {
        $patients = Patient::with('bloodType', 'user')->get();
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Mostrar formulario para crear paciente.
     */
    public function create()
    {
        $blood_types = BloodType::all();
        return view('admin.patients.create', compact('blood_types'));
    }

    /**
     * Guardar nuevo paciente.
     */
    public function store(Request $request)
    {
        // Agregamos max:255 para que coincida con la validación de edición
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:patients,user_id',
            'blood_type_id' => 'nullable|exists:blood_types,id',
            'allergies' => 'nullable|string|max:255',
            'chronic_conditions' => 'nullable|string|max:255',
            'surgical_history' => 'nullable|string|max:255',
            'family_history' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:500', // Este lo dejamos un poco más amplio
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:10',
            'emergency_contact_relationship' => 'nullable|string|max:255',
        ]);

        Patient::create($validated);

        return redirect()->route('admin.patients.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Creado!',
            'text' => 'El paciente ha sido registrado correctamente.',
        ]);
    }

    /**
     * Mostrar información de un paciente.
     */
    public function show(Patient $patient)
    {
        $patient->load('bloodType', 'user');
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Mostrar formulario para editar paciente.
     */
    public function edit(Patient $patient)
    {
        $blood_types = BloodType::all();
        return view('admin.patients.edit', compact('patient', 'blood_types'));
    }

    /**
     * Actualizar paciente.
     */
    public function update(Request $request, Patient $patient)
    {
        // AQUI ESTABA EL DETALLE: Se agregó |max:255 para forzar el error
        $validated = $request->validate([
            'blood_type_id' => 'nullable|exists:blood_types,id',
            'allergies' => 'nullable|string|max:255',
            'chronic_conditions' => 'nullable|string|max:255',
            'surgical_history' => 'nullable|string|max:255',
            'family_history' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:10',
            'emergency_contact_relationship' => 'nullable|string|max:255',
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Actualizado!',
            'text' => 'El expediente médico ha sido actualizado correctamente.',
        ]);
    }

    /**
     * No se permite eliminar pacientes desde aquí.
     */
    public function destroy(Patient $patient)
    {
        return redirect()->route('admin.patients.index')->with('swal', [
            'icon' => 'error',
            'title' => 'Acción no permitida',
            'text' => 'Para eliminar un paciente, debe hacerlo desde el módulo de Usuarios.',
        ]);
    }
}