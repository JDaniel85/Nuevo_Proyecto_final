<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Un administrador para las pruebas.
     *
     * @var \App\Models\User
     */
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Crear un usuario administrador para todas las pruebas de esta clase
        $this->admin = User::factory()->create(['rol' => 'Admin']);
    }

    #[Test]
    public function un_administrador_puede_ver_la_pagina_de_creacion_de_usuarios()
    {
        $response = $this->actingAs($this->admin)->get(route('usuarios.nuevo'));

        $response->assertStatus(200);
        $response->assertSee('Nuevo Usuario');
    }

    #[Test]
    public function un_administrador_puede_crear_un_nuevo_usuario()
    {
        $userData = [
            'name' => 'Usuario de Prueba',
            'email' => 'prueba@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'rol' => 'Cliente',
        ];

        $response = $this->actingAs($this->admin)->post(route('usuarios.guardar'), $userData);

        $response->assertRedirect(route('usuarios'));
        $this->assertDatabaseHas('users', [
            'name' => 'Usuario de Prueba',
            'email' => 'prueba@example.com',
        ]);
    }

    #[Test]
    public function un_administrador_puede_ver_la_pagina_de_edicion_de_un_usuario()
    {
        $userToEdit = User::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('usuarios.editar', $userToEdit->id));

        $response->assertStatus(200);
        $response->assertSee('Editar Usuario');
        $response->assertSee($userToEdit->name);
    }

    #[Test]
    public function un_administrador_puede_actualizar_un_usuario()
    {
        $userToUpdate = User::factory()->create();

        $updatedData = [
            'name' => 'Nombre Actualizado',
            'email' => 'actualizado@example.com',
            'rol' => 'Empleado',
        ];

        $response = $this->actingAs($this->admin)->put(route('usuarios.actualizar', $userToUpdate->id), $updatedData);

        $response->assertRedirect(route('usuarios'));
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Nombre Actualizado',
            'email' => 'actualizado@example.com',
            'rol' => 'Empleado',
        ]);
    }

    #[Test]
    public function un_administrador_puede_eliminar_un_usuario()
    {
        $userToDelete = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('usuarios.eliminar', $userToDelete->id));

        $response->assertRedirect(route('usuarios'));
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    }
}
