<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class RolesYAutenticacionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function los_invitados_son_redirigidos_al_login()
    {
        $response = $this->get('/home');
        $response->assertRedirect('/login');
    }

    #[Test]
    public function un_administrador_puede_acceder_al_panel_de_usuarios()
    {
        $admin = User::factory()->create(['rol' => 'Admin']);

        $response = $this->actingAs($admin)->get('/usuarios');

        $response->assertStatus(200);
        $response->assertSee('Listado de Usuarios'); // Asumiendo que la vista tiene este texto
    }

    #[Test]
    public function un_cliente_puede_acceder_a_la_pagina_de_clases_disponibles()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($cliente)->get(route('cliente.clases.disponibles'));

        $response->assertStatus(200);
        $response->assertSee('Clases Disponibles'); // Asumiendo que la vista tiene este texto
    }

    #[Test]
    public function un_cliente_no_puede_acceder_al_panel_de_usuarios_del_admin()
    {
        $cliente = User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($cliente)->get('/usuarios');

        $response->assertStatus(302); // Should redirect
    }

    #[Test]
    public function un_administrador_no_deberia_acceder_a_rutas_solo_de_clientes()
    {
        $admin = User::factory()->create(['rol' => 'Admin']);

        $response = $this->actingAs($admin)->get(route('cliente.clases.disponibles'));

        $response->assertStatus(302); // Should redirect
    }
}
