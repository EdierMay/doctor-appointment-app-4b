<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_specialty_id',
        'license_number',
        'cedula',
        'address',
        'phone',
        'bio',
        'consultation_price'
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con MedicalSpecialty
    public function specialty()
    {
        return $this->belongsTo(MedicalSpecialty::class, 'medical_specialty_id');
    }

    // Compatibilidad con vistas que usan $doctor->cedula
    public function getCedulaAttribute()
    {
        return $this->license_number ?? $this->attributes['cedula'] ?? null;
    }
}