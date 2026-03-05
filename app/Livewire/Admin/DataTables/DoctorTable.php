<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;

class DoctorTable extends DataTableComponent
{
    /**
     * Define el modelo y carga las relaciones necesarias.
     */
    public function builder(): Builder
    {
        // Nota: Confirma que la relación en tu modelo Doctor se llame 'specialty' 
        // y no 'medicalSpecialty' como vimos en el controlador anterior.
        return Doctor::query()->with(['user', 'specialty']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
                
            Column::make("Nombre", "user.name")
                ->sortable()
                ->searchable(),
                
            Column::make("Email", "user.email")
                ->sortable()
                ->searchable(),
                
            Column::make("Especialidad", "specialty.name")
                ->sortable()
                ->searchable(),
                
            Column::make("Cédula", "cedula")
                ->sortable()
                ->searchable(),
                
            Column::make("Acciones")
                ->label(function($row) {
                    return view('admin.doctors.actions', [
                        'doctor' => $row
                    ]);
                }),
        ];
    }
}