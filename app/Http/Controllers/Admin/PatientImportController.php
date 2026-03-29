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
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            
            // Save the file temporarily in storage
            $filePath = $file->store('imports', 'local');

            // Save history log
            $history = \App\Models\ImportHistory::create([
                'file_name' => $originalName,
                'status' => 'Pendiente',
            ]);

            // Dispatch the background job
            \App\Jobs\ImportPatientsJob::dispatch($filePath, $history->id);

            return redirect()->route('admin.patients.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Importación iniciada!',
                    'text' => 'El archivo se está procesando en segundo plano. Podrás ver el progreso en la tabla a continuación.',
                ]);
        }

        return back()->withErrors(['file' => 'Error al subir el archivo.']);
    }
}
