<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientImportController extends Controller
{
    public function create()
    {
        return view('admin.patients.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx,xls|max:10240', // Max 10MB
        ]);

        if ($request->hasFile('file')) {
            // Save the file temporarily in storage
            $filePath = $request->file('file')->store('imports', 'local');

            // Dispatch the background job
            \App\Jobs\ImportPatientsJob::dispatch($filePath);

            return redirect()->route('admin.patients.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Importación en proceso!',
                    'text' => 'El archivo se ha subido correctamente. Los pacientes se importarán en segundo plano.',
                ]);
        }

        return back()->withErrors(['file' => 'Error al subir el archivo.']);
    }
}
