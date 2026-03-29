<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ImportHistory extends Component
{
    public function deleteHistory($id)
    {
        $history = \App\Models\ImportHistory::find($id);
        if ($history) {
            // Eliminar archivo físico de la carpeta imports si existe, y hacer rollback de usuarios
            if ($history->file_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($history->file_path)) {
                
                // Rollback (Eliminar los usuarios creados por este lote)
                try {
                    $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(
                        new class implements \Maatwebsite\Excel\Concerns\WithHeadingRow {}, 
                        $history->file_path, 
                        'local'
                    );

                    $emails = [];
                    if (!empty($sheets) && isset($sheets[0])) {
                        foreach ($sheets[0] as $row) {
                            if (isset($row['correo'])) {
                                $emails[] = $row['correo'];
                            }
                        }
                    }

                    if (count($emails) > 0) {
                        $users = \App\Models\User::whereIn('email', $emails)->get();
                        foreach ($users as $user) {
                            \App\Models\Patient::where('user_id', $user->id)->delete();
                            $user->delete();
                        }
                    }
                } catch (\Exception $e) {
                    // Si el archivo está corrupto o no se puede leer, procedemos con la eliminación del historial
                }

                \Illuminate\Support\Facades\Storage::disk('local')->delete($history->file_path);
            }
            $history->delete();
        }
    }

    public function render()
    {
        $histories = \App\Models\ImportHistory::latest()->take(5)->get();
        return view('livewire.admin.import-history', compact('histories'));
    }
}
