<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Membresia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class MembresiaTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function una_membresia_puede_ser_creada()
    {
        $membresia = Membresia::factory()->create();

        $this->assertDatabaseHas('membresias', ['id' => $membresia->id]);
        $this->assertInstanceOf(Membresia::class, $membresia);
    }

    #[Test]
    public function una_membresia_pertenece_a_un_usuario()
    {
        $usuario = User::factory()->create();
        $membresia = Membresia::factory()->create(['id_usuario' => $usuario->id]);

        $this->assertInstanceOf(User::class, $membresia->usuario);
        $this->assertEquals($usuario->id, $membresia->usuario->id);
    }

    #[Test]
    public function el_metodo_puede_usar_clase_funciona_correctamente()
    {
        $membresiaConClases = Membresia::factory()->create(['clases_disponibles' => 5]);
        $membresiaSinClases = Membresia::factory()->create(['clases_disponibles' => 0]);

        $this->assertTrue($membresiaConClases->puedeUsarClase());
        $this->assertFalse($membresiaSinClases->puedeUsarClase());
    }

    #[Test]
    public function el_porcentaje_de_uso_se_calcula_correctamente()
    {
        $membresia = Membresia::factory()->create([
            'clases_adquiridas' => 20,
            'clases_ocupadas' => 5,
        ]);

        // 5 / 20 = 0.25 * 100 = 25%
        $this->assertEquals(25.0, $membresia->porcentajeUso());

        $membresiaCero = Membresia::factory()->create(['clases_adquiridas' => 0]);
        $this->assertEquals(0, $membresiaCero->porcentajeUso());
    }
}
