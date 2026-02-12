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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

        // 1. Añadimos campos
            $table->foreignId('user_id')
                ->constrained('users')
                //si borro un usuario,que se borre el paciente
                ->onDelete('cascade');

            // 2. Relación con Tipos de Sangre (Set Null si se borra el tipo)
            $table->foreignId('blood_type_id')
                ->nullable() 
                ->constrained('blood_types')
                ->onDelete('set null');

            // 3. Campos Médicos del video
            $table->text('allergies')->nullable();
            $table->text('chronic_conditions')->nullable();
            $table->text('surgical_history')->nullable();
            $table->text('family_history')->nullable();
            $table->text('observations')->nullable();

            // 4. Contacto de emergencia
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
