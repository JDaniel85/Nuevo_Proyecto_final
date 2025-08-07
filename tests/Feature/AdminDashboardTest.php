<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['rol' => 'Admin']);
    }

    #[Test]
    public function un_administrador_puede_ver_su_panel_de_control_con_datos()
    {
        User::factory()->create(['rol' => 'Cliente']);

        $response = $this->actingAs($this->admin)->get(route('admin.home'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.home');
        $response->assertViewHasAll([
            'totalClientes',
            'totalEmpleados',
            'clasesHoy',
            'ingresosMes',
            'alertas',
        ]);
    }
}
