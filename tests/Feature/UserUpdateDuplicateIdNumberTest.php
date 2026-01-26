STDIN
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('No permite actualizar usuario con id_number duplicado', function () {

    $role = Role::first() ?? Role::create(['name' => 'admin']);

    $admin = User::factory()->create();
    $this->actingAs($admin, 'web');

    // Usuario A con un id_number
    $userA = User::factory()->create([
        'id_number' => 'ID-11111',
        'phone' => '9999999999',
        'address' => 'Calle A',
    ]);

    // Usuario B con otro id_number
    $userB = User::factory()->create([
        'id_number' => 'ID-22222',
        'phone' => '8888888888',
        'address' => 'Calle B',
    ]);

    // Intentar actualizar a B para que tenga el mismo id_number de A
    $response = $this->put(route('admin.users.update', $userB), [
        'name' => $userB->name,
        'email' => $userB->email,
        'role' => $role->id,

        'id_number' => 'ID-11111', // duplicado
        'phone' => $userB->phone,
        'address' => $userB->address,
    ]);

    $response->assertSessionHasErrors(['id_number']);

    // Confirmar que B NO cambió su id_number
    expect(User::find($userB->id)->id_number)->toBe('ID-22222');
});
