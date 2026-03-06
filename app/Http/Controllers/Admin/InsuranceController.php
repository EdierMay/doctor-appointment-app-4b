<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the insurances.
     */
    public function index()
    {
        $insurances = Insurance::all();
        return view('admin.insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new insurance.
     */
    public function create()
    {
        return view('admin.insurances.create');
    }

    /**
     * Store a newly created insurance in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:20',
            'notas_adicionales' => 'nullable|string',
        ]);

        Insurance::create($validated);

        return redirect()->route('admin.insurances.index')
            ->with('success', 'Aseguradora registrada exitosamente.');
    }
}
