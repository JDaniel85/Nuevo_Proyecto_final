<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Membresia;
use PHPUnit\Framework\Attributes\Test;

class MembresiaCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['rol' => 'Admin']);
    }

    #[Test]
    public function un_administrador_puede_ver_la_pagina_de_creacion_de_membresias()
    {
        $response = $this->actingAs($this->admin)->get(route('membresias.nueva'));
        $response->assertStatus(200);
        $response->assertSee('Nueva Membresía');
    }

    #[Test]
    public function un_administrador_puede_crear_una_nueva_membresia()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);
        $membresiaData = [
            'id_usuario' => $cliente->id,
            'clases_adquiridas' => 10,
        ];

        $response = $this->actingAs($this->admin)->post(route('membresias.guardar'), $membresiaData);

        $response->assertRedirect(route('membresias.lista'));
        $this->assertDatabaseHas('membresias', [
            'id_usuario' => $cliente->id,
            'clases_adquiridas' => 10,
        ]);
    }

    #[Test]
    public function un_administrador_puede_ver_la_pagina_de_edicion_de_una_membresia()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);
        $membresia = Membresia::factory()->create(['id_usuario' => $cliente->id]);

        $response = $this->actingAs($this->admin)->get(route('membresias.editar', $membresia->id));

        $response->assertStatus(200);
        $response->assertSee('Editar Membresía');
        $response->assertSee($membresia->usuario->name);
    }

    #[Test]
    public function un_administrador_puede_actualizar_una_membresia()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);
        $membresia = Membresia::factory()->create(['id_usuario' => $cliente->id]);

        $updatedData = [
            'id_usuario' => $membresia->id_usuario,
            'clases_adquiridas' => 20,
            'clases_ocupadas' => 5,
        ];

        $response = $this->actingAs($this->admin)->post(route('membresias.guardar'), array_merge(['id' => $membresia->id], $updatedData));

        $response->assertRedirect(route('membresias.lista'));
        $this->assertDatabaseHas('membresias', [
            'id' => $membresia->id,
            'clases_adquiridas' => 20,
            'clases_ocupadas' => 5,
        ]);
    }

    #[Test]
    public function un_administrador_puede_eliminar_una_membresia()
    {
        $membresia = Membresia::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('membresias.eliminar', $membresia->id));

        $response->assertRedirect(route('membresias.lista'));
        $this->assertDatabaseMissing('membresias', [
            'id' => $membresia->id,
        ]);
    }
}
