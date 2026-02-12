<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodType extends Model
{
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relación uno a muchos con el modelo Patient.
     * Un tipo de sangre (ej. O+) puede ser tenido por muchos pacientes.
     */
    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
}