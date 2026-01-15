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
        // VALIDACIÓN
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,id',

            // CAMPOS OBLIGATORIOS EN LA BD
            'id_number' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        // CREAR USUARIO
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // ASIGNAR ROL
        $role = Role::find($request->role);
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
        // VALIDACIÓN
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|exists:roles,id',

            // CAMPOS OBLIGATORIOS EN LA BD
            'id_number' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        // ACTUALIZAR DATOS
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // CAMBIAR CONTRASEÑA SI SE ENVIÓ
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // ACTUALIZAR ROL
        $role = Role::find($request->role);
        $user->syncRoles([$role->name]);

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

        $user->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario eliminado correctamente',
            'text' => 'El usuario ha sido eliminado exitosamente',
        ]);

        return redirect()->route('admin.users.index');
    }
}
