<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // VALIDACIÓN (mejorada)
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

            // tu form usa "role" (id del role)
            'role' => 'required|exists:roles,id',

            // CAMPOS
            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9\-]+$/|unique:users,id_number',
            'phone' => 'nullable|digits_between:7,15',
            'address' => 'nullable|string|min:3|max:255',
        ]);

        // CREAR USUARIO
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_number' => $data['id_number'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        // ASIGNAR ROL (seguro)
        $role = Role::findOrFail($data['role']);
        $user->assignRole($role);

        // MENSAJE
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado correctamente',
            'text' => 'El usuario se ha creado exitosamente',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Reglas base
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,

            // tu form usa "role" (id del role)
            'role' => 'required|exists:roles,id',

            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9\-]+$/|unique:users,id_number,' . $user->id,
            'phone' => 'nullable|digits_between:7,15',
            'address' => 'nullable|string|min:3|max:255',
        ];

        // Validar contraseña solo si se manda
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $data = $request->validate($rules);

        // ACTUALIZAR DATOS
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'id_number' => $data['id_number'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        // CAMBIAR CONTRASEÑA SI SE ENVIÓ
        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
            $user->save();
        }

        // ACTUALIZAR ROL (mejor que syncRoles por name)
        $role = Role::findOrFail($data['role']);
        $user->syncRoles([$role]);

        // MENSAJE
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado correctamente',
            'text' => 'El usuario ha sido actualizado exitosamente',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        // EVITAR ELIMINAR AL USUARIO AUTENTICADO
        if ($user->id === auth()->id()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Acción no permitida',
                'text' => 'No puedes eliminar tu propio usuario',
            ]);
            return redirect()->route('admin.users.index');
        }

        try {
            // Quitar roles (buena práctica)
            $user->roles()->detach();

            // Eliminar usuario
            $user->delete();

            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Usuario eliminado correctamente',
                'text' => 'El usuario ha sido eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo eliminar el usuario. Por favor, intenta nuevamente.',
            ]);
        }

        return redirect()->route('admin.users.index');
    }
}
