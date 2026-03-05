<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insurances = Insurance::all();
        // Nota: Si usas la ruta 'resources/views/admin/insurances/index.blade.php', 
        // cambiaría el return view('admin.insurances.index', ...).
        // Dado que solicitaste usar 'resources/views/insurances/index.blade.php', usamos eso:
        return view('insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('insurances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:255',
            'notas_adicionales' => 'nullable|string',
        ]);

        Insurance::create($validated);

        return redirect()->route('admin.insurances.index')
            ->with('success', 'Aseguradora registrada exitosamente.');
    }
}
