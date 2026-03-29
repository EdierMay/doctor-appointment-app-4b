<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PatientsImport;

class ImportPatientsJob implements ShouldQueue
{
    use Queueable;

    protected $filePath;
    protected $historyId;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $historyId = null)
    {
        $this->filePath = $filePath;
        $this->historyId = $historyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = Storage::path($this->filePath);
        $history = null;

        if ($this->historyId) {
            $history = \App\Models\ImportHistory::find($this->historyId);
            if ($history) {
                // Cuenta las líneas del CSV descontando el encabezado (aproximado)
                $lines = max(0, count(file($file)) - 1);
                $history->update([
                    'status' => 'Procesando',
                    'total_rows' => $lines
                ]);
            }
        }

        try {
            // Se delega a la clase de importación PatientsImport para procesar
            Excel::import(new \App\Imports\PatientsImport($this->historyId), $file);

            if ($history) {
                $history->update(['status' => 'Completado']);
            }
        } catch (\Exception $e) {
            if ($history) {
                $history->update(['status' => 'Fallido']);
            }
            throw $e;
        }
    }
}
