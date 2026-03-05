<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            // 1. RELACIÓN CON USUARIO
            // El doctor "pertenece" a un usuario.
            // onDelete('cascade'): Si borras al usuario del sistema, se borra su perfil de doctor automáticamente.
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // 2. RELACIÓN CON EL CATÁLOGO
            // onDelete('set null'): Si borramos la especialidad "Cardiología", no queremos borrar al doctor,
            // solo queremos que su campo de especialidad quede vacío (null).
            $table->foreignId('medical_specialty_id')
                  ->nullable()
                  ->constrained('medical_specialties')
                  ->onDelete('set null');

            // 3. CAMPOS ESPECÍFICOS DEL DOCTOR
            $table->string('cedula')->nullable(); // Cédula Profesional
            $table->text('bio')->nullable();      // Biografía o descripción del doctor
            
            // 4. CAMPO DE PRECIO (Faltaba en tu migración, pero lo usas en el Controlador/Modelo)
            $table->decimal('consultation_price', 8, 2)->nullable(); // Precio de la consulta con 2 decimales
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};