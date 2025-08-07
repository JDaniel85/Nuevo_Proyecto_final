<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Clase;
use App\Models\Membresia;
use PHPUnit\Framework\Attributes\Test;

class ClienteFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $cliente;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cliente = User::factory()->create(['rol' => 'Cliente']);
    }

    #[Test]
    public function un_cliente_puede_ver_las_clases_disponibles()
    {
        Clase::factory()->create(['lugares_disponibles' => 5]);

        $response = $this->actingAs($this->cliente)->get(route('cliente.clases.disponibles'));

        $response->assertStatus(200);
        $response->assertSee('Clases Disponibles');
    }

    #[Test]
    public function un_cliente_puede_ver_sus_membresias()
    {
        Membresia::factory()->create(['id_usuario' => $this->cliente->id]);

        $response = $this->actingAs($this->cliente)->get(route('membresias.cliente'));

        $response->assertStatus(200);
        $response->assertSee('Mis Membresías');
    }

    #[Test]
    public function un_cliente_con_membresia_puede_inscribirse_a_una_clase()
    {
        Membresia::factory()->create([
            'id_usuario' => $this->cliente->id,
            'clases_disponibles' => 5,
        ]);
        $clase = Clase::factory()->create(['lugares_disponibles' => 10]);

        $response = $this->actingAs($this->cliente)->post(route('cliente.clases.inscribirse', $clase->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('clase_user', [
            'user_id' => $this->cliente->id,
            'clase_id' => $clase->id,
        ]);
    }

    #[Test]
    public function un_cliente_sin_clases_disponibles_no_puede_inscribirse()
    {
        Membresia::factory()->create([
            'id_usuario' => $this->cliente->id,
            'clases_disponibles' => 0,
        ]);
        $clase = Clase::factory()->create(['lugares_disponibles' => 10]);

        $response = $this->actingAs($this->cliente)->post(route('cliente.clases.inscribirse', $clase->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('clase_user', [
            'user_id' => $this->cliente->id,
            'clase_id' => $clase->id,
        ]);
    }

    #[Test]
    public function un_cliente_puede_ver_sus_clases_inscritas()
    {
        $clase = Clase::factory()->create();
        $this->cliente->clases()->attach($clase->id);

        $response = $this->actingAs($this->cliente)->get(route('cliente.clases.mis'));

        $response->assertStatus(200);
        $response->assertSee('Mis Clases');
        $response->assertSee($clase->tipo);
    }
}
