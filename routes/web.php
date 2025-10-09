<?php
use Illuminate\Support\Facades\Route;
// La ruta a la que deseas redirigir la pagina de inicio
// Route::redirect('/', 'admin');
Route::get('/', function () {
   return view('welcome');
});
Route::middleware([
   'auth:sanctum',
   config('jetstream.auth_session'),
   'verified',
])->group(function () {
   Route::get('/dashboard', function () {
       return view('dashboard');
   })->name('dashboard');
});