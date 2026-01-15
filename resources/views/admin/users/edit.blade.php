<x-admin-layout
    title="Editar usuario | Healthify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Usuarios', 'href' => route('admin.users.index')],
        ['name' => 'Editar'],
    ]"
>
    <div class="bg-white rounded-lg shadow p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nombre</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full border rounded-lg px-3 py-2"
                >
                @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full border rounded-lg px-3 py-2"
                >
                @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nueva contraseña (opcional) --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nueva contraseña (opcional)</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Déjala vacía si no deseas cambiarla"
                    class="w-full border rounded-lg px-3 py-2"
                >
                @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div>
                <label class="block text-sm font-medium mb-1">Confirmar nueva contraseña</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border rounded-lg px-3 py-2"
                >
            </div>

            {{-- Número de ID --}}
            <div>
                <label class="block text-sm font-medium mb-1">Número de ID</label>
                <input
                    type="text"
                    name="id_number"
                    value="{{ old('id_number', $user->id_number) }}"
                    required
                    class="w-full border rounded-lg px-3 py-2"
                >
                @error('id_number') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Teléfono --}}
            <div>
                <label class="block text-sm font-medium mb-1">Teléfono</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    required
                    class="w-full border rounded-lg px-3 py-2"
                >
                @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dirección --}}
            <div>
                <label class="block text-sm font-medium mb-1">Dirección</label>
                <input
                    type="text"
                    name="address"
                    value="{{ old('address', $user->address) }}"
                    required
                    class="w-full border rounded-lg px-3 py-2"
                >
                @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Rol --}}
            <div>
                <label class="block text-sm font-medium mb-1">Rol</label>
                @php
                    $currentRoleId = $user->roles->first()?->id;
                @endphp
                <select name="role" required class="w-full border rounded-lg px-3 py-2 bg-white">
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            @selected(old('role', $currentRoleId) == $role->id)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 border rounded-lg text-gray-700">
                    Volver
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
