<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalSpecialty;

class MedicalSpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            'Medicina General',
            'Cardiología',
            'Pediatría',
            'Dermatología',
            'Ginecología',
            'Ortopedia',
            'Neurología',
            'Oftalmología',
            'Psiquiatría',
            'Traumatología',
            'Endocrinología'
        ];

        foreach ($specialties as $name) {
            MedicalSpecialty::firstOrCreate(['name' => $name]);
        }
    }
}