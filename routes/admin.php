<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;

/*
|--------------------------------------------------------------------------
| Rutas del panel de administración
|--------------------------------------------------------------------------
*/

// Dashboard principal del administrador
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Gestión de roles
Route::resource('roles', RoleController::class);

// Gestión de usuarios
Route::resource('users', UserController::class);

// Gestión de pacientes
Route::resource('patients', PatientController::class);

// Gestión de doctores
Route::resource('doctors', DoctorController::class);
