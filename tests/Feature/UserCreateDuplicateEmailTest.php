STDIN
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('No permite crear usuario con email duplicado', function () {

    // 1) Asegurar que exista al menos un rol
    $role = Role::first() ?? Role::create(['name' => 'admin']);

    // 2) Usuario autenticado
    $admin = User::factory()->create();
    $this->actingAs($admin, 'web');

    // 3) Usuario existente con email repetido
    User::factory()->create([
        'email' => 'duplicado@demo.com',
        'id_number' => 'ID-00001',
        'phone' => '9999999999',
        'address' => 'Calle 1',
    ]);

    // 4) Intentar crear otro usuario con el mismo email
    $response = $this->post(route('admin.users.store'), [
        'name' => 'Usuario Nuevo',
        'email' => 'duplicado@demo.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',

        // ⚠️ Si tu controller usa role_id, cambia esta línea
        'role' => $role->id,

        'id_number' => 'ID-00002',
        'phone' => '9999999999',
        'address' => 'Calle 2',
    ]);

    // 5) Esperar error de validación
    $response->assertSessionHasErrors(['email']);

    // 6) Verificar que solo exista UN usuario con ese email
    expect(User::where('email', 'duplicado@demo.com')->count())->toBe(1);
});
