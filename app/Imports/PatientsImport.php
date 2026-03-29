<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Patient;
use App\Models\BloodType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PatientsImport implements ToModel, WithHeadingRow
{
    protected $historyId;

    public function __construct($historyId = null)
    {
        $this->historyId = $historyId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Headers: nombre_completo, correo, telefono, fecha_nacimiento, tipo_sangre, alergias

        // Evitar filas vacías
        if (empty($row['correo']) || empty($row['nombre_completo'])) {
            return null;
        }

        // Buscar o crear usuario
        $user = User::firstOrCreate(
            ['email' => $row['correo']],
            [
                'name' => $row['nombre_completo'],
                'password' => Hash::make('password123'), // Contraseña genérica temporal
                'phone' => $row['telefono'] ?? '',
                'address' => '', // Sin dirección en CSV
                'id_number' => Str::random(10), // Identificador único requerido
            ]
        );

        // Asignar rol de paciente si no lo tiene (requiere spatie/laravel-permission)
        if (!$user->hasRole('Paciente')) {
            $user->assignRole('Paciente');
        }

        // Buscar tipo de sangre
        $bloodTypeId = null;
        if (!empty($row['tipo_sangre'])) {
            $bloodType = BloodType::firstOrCreate(['name' => $row['tipo_sangre']]);
            $bloodTypeId = $bloodType->id;
        }

        // Crear perfil de paciente si no existe
        Patient::firstOrCreate(
            ['user_id' => $user->id],
            [
                'blood_type_id' => $bloodTypeId,
                'date_of_birth' => $row['fecha_nacimiento'] ?? null,
                'allergies' => $row['alergias'] ?? null,
            ]
        );

        // Actualizar el progreso en el historial
        if ($this->historyId) {
            \App\Models\ImportHistory::where('id', $this->historyId)->increment('processed_rows');
        }

        return null; // Return null because we manually handled the creations to manage relationships
    }
}
