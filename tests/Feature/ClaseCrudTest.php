<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Clase;
use PHPUnit\Framework\Attributes\Test;

class ClaseCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['rol' => 'Admin']);
    }

    #[Test]
    public function un_administrador_puede_ver_la_pagina_de_creacion_de_clases()
    {
        $response = $this->actingAs($this->admin)->get(route('clases.nueva'));
        $response->assertStatus(200);
        $response->assertSee('Nueva Clase');
    }

    #[Test]
    public function un_administrador_puede_crear_una_nueva_clase()
    {
        $profesor = User::factory()->create(['rol' => 'Empleado']);

        $claseData = [
            'fecha' => '2025-01-01T10:00',
            'id_profesor' => $profesor->id,
            'tipo' => 'Yoga Avanzado',
            'lugares' => 15,
            'duracion' => '60 min',
            'nivel' => 'Avanzado',
            'publico_dirigido' => 'Mixto',
        ];

        $response = $this->actingAs($this->admin)->post(route('clases.guardar'), $claseData);

        $response->assertRedirect(route('clases'));
        $this->assertDatabaseHas('clases', ['tipo' => 'Yoga Avanzado']);
    }

    #[Test]
    public function un_administrador_puede_ver_la_pagina_de_edicion_de_una_clase()
    {
        $clase = Clase::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('clases.editar', $clase->id));

        $response->assertStatus(200);
        $response->assertSee('Editar Clase');
        $response->assertSee($clase->nombre);
    }

    #[Test]
    public function un_administrador_puede_actualizar_una_clase()
    {
        $clase = Clase::factory()->create();

        $profesor = User::factory()->create(['rol' => 'Empleado']);

        $updatedData = [
            'fecha' => '2025-01-02T11:00',
            'id_profesor' => $profesor->id,
            'tipo' => 'Yoga para Principiantes',
            'lugares' => 20,
            'duracion' => '45 min',
            'nivel' => 'Principiante',
            'publico_dirigido' => 'Mujeres',
        ];

        $response = $this->actingAs($this->admin)->post(route('clases.guardar'), array_merge(['id' => $clase->id], $updatedData));

        $response->assertRedirect(route('clases'));
        $this->assertDatabaseHas('clases', ['id' => $clase->id, 'tipo' => 'Yoga para Principiantes']);
    }

    #[Test]
    public function un_administrador_puede_eliminar_una_clase()
    {
        $clase = Clase::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('clases.eliminar', $clase->id));

        $response->assertRedirect(route('clases'));
        $this->assertDatabaseMissing('clases', ['id' => $clase->id]);
    }
}
