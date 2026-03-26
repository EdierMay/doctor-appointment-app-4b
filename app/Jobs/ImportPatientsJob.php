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

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = Storage::path($this->filePath);

        // Se delega a la clase de importación PatientsImport para procesar
        Excel::import(new \App\Imports\PatientsImport, $file);
    }
}
