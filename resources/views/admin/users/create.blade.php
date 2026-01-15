<x-admin-layout
    title="Crear usuario | Healthify"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Usuarios', 'href' => route('admin.users.index')],
        ['name' => 'Nuevo'],
    ]"
>
    <div class="bg-white rounded-lg shadow p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nombre</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                >
                @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                >
                @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Contraseña --}}
            <div>
                <label class="block text-sm font-medium mb-1">Contraseña</label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Mínimo 6 caracteres"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                >
                @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div>
                <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                >
            </div>

            {{-- Número de ID --}}
            <div>
                <label class="block text-sm font-medium mb-1">Número de ID</label>
                <input
                    type="text"
                    name="id_number"
                    value="{{ old('id_number') }}"
                    placeholder="Ej. 123456789"
                    class="w-full border rounded-lg px-3 py-2"
                >
            </div>

            {{-- Teléfono --}}
            <div>
                <label class="block text-sm font-medium mb-1">Teléfono</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Ej. 123456789"
                    class="w-full border rounded-lg px-3 py-2"
                >
            </div>

            {{-- Dirección --}}
            <div>
                <label class="block text-sm font-medium mb-1">Dirección</label>
                <input
                    type="text"
                    name="address"
                    value="{{ old('address') }}"
                    placeholder="Ej. Calle 123"
                    class="w-full border rounded-lg px-3 py-2"
                >
            </div>

            {{-- Rol --}}
            <div>
                <label class="block text-sm font-medium mb-1">Rol</label>
                <select
                    name="role"
                    required
                    class="w-full border rounded-lg px-3 py-2 bg-white"
                >
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @selected(old('role') == $role->id)>
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
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
