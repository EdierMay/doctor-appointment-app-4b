<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

class AppointmentTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Appointment::query()->with(['patient.user', 'doctor.user']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),

            Column::make("Paciente", "patient.user.name")
                ->sortable()
                ->searchable(),

            Column::make("Doctor", "doctor.user.name")
                ->sortable()
                ->searchable(),

            Column::make("Fecha", "date")
                ->sortable()
                ->searchable()
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('d/m/Y')),

            Column::make("Hora", "start_time")
                ->sortable()
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('H:i')),

            Column::make("Hora Fin", "end_time")
                ->sortable()
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('H:i')),

            Column::make("Estado", "status")
                ->sortable()
                ->format(function($value) {
                    return $value == 1 ? 'Programado' : ($value == 2 ? 'Completado' : 'Cancelado');
                }),

            Column::make("Acciones")
                ->label(function($row) {
                    return view('admin.appointments.actions', [
                        'appointment' => $row
                    ]);
                }),
        ];
    }
}
