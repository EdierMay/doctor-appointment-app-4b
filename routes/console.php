<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Appointment;
use App\Mail\DailyAdminReport;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $citasHoy = Appointment::with('patient.user', 'doctor.user')
                ->whereDate('date', Carbon::today())
                ->get();
    
    // Aquí ya está configurado tu correo para recibir el reporte de las 8 AM
    Mail::to('edierjairmaypech@gmail.com')->send(new DailyAdminReport($citasHoy));
})->dailyAt('08:00');