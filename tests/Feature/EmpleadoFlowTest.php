<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Clase;
use PHPUnit\Framework\Attributes\Test;

class EmpleadoFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $empleado;

    protected function setUp(): void
    {
        parent::setUp();
        $this->empleado = User::factory()->create(['rol' => 'Empleado']);
    }

    #[Test]
    public function un_empleado_puede_ver_sus_clases_asignadas()
    {
        Clase::factory()->create(['id_profesor' => $this->empleado->id]);
        Clase::factory()->create(); // Otra clase con otro profesor

        $response = $this->actingAs($this->empleado)->get(route('clases'));

        $response->assertStatus(200);
        $response->assertSee('Clases a Impartir');
        $response->assertViewHas('clases', function ($clases) {
            return $clases->count() === 1 && $clases->first()->id_profesor === $this->empleado->id;
        });
    }

    #[Test]
    public function un_empleado_es_redirigido_a_su_dashboard()
    {
        $response = $this->actingAs($this->empleado)->get('/home');

        $response->assertRedirect(route('empleado.home'));
    }
}
