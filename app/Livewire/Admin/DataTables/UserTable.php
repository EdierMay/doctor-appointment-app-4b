<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends DataTableComponent
{
    /**
     * Usamos builder() como en tu compañero,
     * pero sin eliminar tu configuración ni tu estructura.
     */
    public function builder(): Builder
    {
        return User::query()->with('roles');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function($row) {
                return route('admin.users.edit', $row);
            })
            ->setTableAttributes([
                'class' => 'table table-striped table-black-borders table-hover-gray'
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),

            Column::make("Email", "email")
                ->sortable()
                ->searchable(),

            // NUEVO: Número de identificación
            Column::make("Número de ID", "id_number")
                ->sortable(),
            
            // NUEVO: Teléfono
            Column::make("Teléfono", "phone")
                ->sortable(),

            Column::make("Rol")
                ->label(function($row){
                    return $row->roles->first()?->name ?? 'Sin rol';
                }),

            Column::make("Fecha", "created_at")
                ->sortable()
                ->format(function($value) {
                    return $value->format('d/m/Y');
                }),

            Column::make("Acciones")
                ->label(function($row) {
                    return view('admin.users.actions', [
                        'user' => $row
                    ]);
                })
        ];
    }
}
