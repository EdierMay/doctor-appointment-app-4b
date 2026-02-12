<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Guardar usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'id_number' => 'required|string|max:20|regex:/^[A-Za-z0-9\-]+$/|unique:users,id_number',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string|max:255',
            'role_id'   => 'required|exists:roles,id',
        ]);

        // Crear usuario
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password, // Hasheado automáticamente por cast
            'id_number' => $request->id_number,
            'phone'     => $request->phone,
            'address'   => $request->address,
        ]);

        // Asignar rol
        $user->roles()->sync($request->role_id);

        // Crear expediente si es Paciente
        $role = Role::find($request->role_id);

        if ($role && strtolower($role->name) === 'paciente') {
            Patient::create([
                'user_id' => $user->id,
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Usuario creado correctamente',
                'text'  => 'El usuario ha sido creado y el rol asignado exitosamente',
            ]);
    }

    /**
     * Mostrar usuario
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Editar usuario
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'id_number' => 'required|string|max:20',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string|max:255',
            'role_id'   => 'required|exists:roles,id',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'id_number' => $request->id_number,
            'phone'     => $request->phone,
            'address'   => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        // Roles
        $oldRole = $user->roles->first();
        $newRole = Role::find($request->role_id);

        $user->roles()->sync($request->role_id);

        // Crear expediente si ahora es Paciente (comparación insensible)
        if ($newRole && strtolower($newRole->name) === 'paciente' && !$user->patient) {
            Patient::create([
                'user_id' => $user->id,
            ]);
        }

        // Eliminar expediente si deja de ser Paciente
        if (
            $oldRole &&
            $oldRole->name === 'Paciente' &&
            $newRole &&
            $newRole->name !== 'Paciente'
        ) {
            $user->patient?->delete();
        }

        return redirect()
            ->route('admin.users.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Usuario actualizado correctamente',
                'text'  => 'El usuario ha sido actualizado exitosamente.',
            ]);
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            abort(403, 'No puedes eliminar tu propia cuenta.');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Usuario eliminado',
                'text'  => 'El usuario ha sido eliminado correctamente.',
            ]);
    }
}
