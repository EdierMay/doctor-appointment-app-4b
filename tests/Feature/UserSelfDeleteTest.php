<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Usar la función para refrescar la base de datos entre pruebas
uses(RefreshDatabase::class);

test('Un usuario no puede eliminarse asi mismo', function () {
    // 1) Crear un usuario de prueba
    $user = User::factory()->create();

    // 2) Simular que ese usuario ya inició sesión
    $this->actingAs($user, 'web');

    // 3) Simular una petición HTTP DELETE (borrar un usuario)
    $response = $this->delete(route('admin.users.destroy', $user));

    // 4) El controller devuelve 403 Forbidden
    $response->assertForbidden();

    // 5) Verificar que el usuario sigue existiendo en la base de datos
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});
