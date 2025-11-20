<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un usuario de prueba cada que se ejecuten migraciones
        // php artisan migrate:fresh --seed

        User::factory()->create([
            'name' => 'Edier',
            'email' => 'edier@example.com',
            'password' => bcrypt('12345678'),
            'id_number' => '1234567899',
            'phone' => '1234567898',
            'address' => 'calle 123, Colonia 456',
        ])->assignRole('Doctor');   
    }
}
