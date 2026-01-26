STDIN
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('No permite crear usuario con password demasiado corta', function () {

    $role = Role::first() ?? Role::create(['name' => 'admin']);

    $admin = User::factory()->create();
    $this->actingAs($admin, 'web');

    $response = $this->post(route('admin.users.store'), [
        'name' => 'Usuario Pass Corta',
        'email' => 'passcorta@demo.com',
        'password' => '123', // muy corta
        'password_confirmation' => '123',
        'role' => $role->id,

        'id_number' => 'ID-33333',
        'phone' => '7777777777',
        'address' => 'Calle Password',
    ]);

    $response->assertSessionHasErrors(['password']);

    $this->assertDatabaseMissing('users', [
        'email' => 'passcorta@demo.com',
    ]);
});
