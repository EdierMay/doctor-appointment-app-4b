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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt,xlsx,xls|max:10240', // Max 10MB
        ], [
            'file.mimes' => 'El archivo debe ser de tipo: csv, xlsx, xls.',
            'file.max' => 'El archivo no debe pesar más de 10MB.',
        ]);

        if ($validator->fails()) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                \App\Models\ImportHistory::create([
                    'file_name' => $file->getClientOriginalName(),
                    'status' => 'Fallido',
                    'error_message' => $validator->errors()->first('file'),
                ]);
            }
            return back()->with('swal', [
                'icon' => 'error',
                'title' => 'Formato Inválido',
                'text' => $validator->errors()->first('file'),
            ])->withErrors($validator);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            
            // Check for previous successful imports to prevent duplicates
            $alreadyExists = \App\Models\ImportHistory::where('file_name', $originalName)
                                ->whereIn('status', ['Completado', 'Procesando', 'Pendiente'])
                                ->exists();
                                
            if ($alreadyExists) {
                // Log the duplicate attempt as failed
                \App\Models\ImportHistory::create([
                    'file_name' => $originalName . ' (Duplicado)',
                    'status' => 'Fallido',
                    'error_message' => 'Ya has subido un archivo con este nombre previamente.',
                ]);

                return redirect()->route('admin.patients.index')
                    ->with('swal', [
                        'icon' => 'error',
                        'title' => '¡Archivo duplicado!',
                        'text' => 'El archivo "' . $originalName . '" ya fue subido exitosamente o está en proceso.',
                    ]);
            }

            // Save the file temporarily in storage
            $filePath = $file->store('imports', 'local');

            // Save history log
            $history = \App\Models\ImportHistory::create([
                'file_name' => $originalName,
                'file_path' => $filePath,
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

    /**
     * Descarga la plantilla CSV de ejemplo.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="plantilla_pacientes.csv"',
        ];
        $columns = [
            'nombre_completo', 'correo', 'telefono', 'fecha_nacimiento', 'tipo_sangre', 'alergias'
        ];
        $example = [
            'Juan Pérez', 'juan.perez@ejemplo.com', '9998887766',
            '1990-05-15', 'O+', 'Polen, Polvo'
        ];

        $callback = function () use ($columns, $example) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8
            fputcsv($handle, $columns);
            fputcsv($handle, $example);
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }
}
