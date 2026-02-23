<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController; // 1. AGREGAMOS EL CONTROLADOR AQUÍ

// Redirige la raíz al prefijo admin
Route::redirect('/', '/admin');

// Opcional pero útil: que /admin apunte al dashboard
Route::redirect('/admin', '/admin/dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard de administrador
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD de Roles
    Route::resource('roles', RoleController::class);

    // CRUD de Usuarios
    Route::resource('users', UserController::class);

    // CRUD de Pacientes
    Route::resource('patients', PatientController::class);

    // ✅ NUEVO: CRUD de Doctores (ESTO HACE APARECER EL BOTÓN)
    Route::resource('doctors', DoctorController::class);
});