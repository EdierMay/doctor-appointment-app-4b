<?php // Indica que este es un archivo PHP

// Importación de la clase Route desde el framework Laravel.
// Route se utiliza para definir y configurar las rutas de la aplicación.
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
