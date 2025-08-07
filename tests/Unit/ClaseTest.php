<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ClaseTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function una_clase_puede_ser_creada()
    {
        $clase = Clase::factory()->create();

        $this->assertDatabaseHas('clases', ['id' => $clase->id]);
        $this->assertInstanceOf(Clase::class, $clase);
    }

    #[Test]
    public function una_clase_pertenece_a_un_profesor()
    {
        $profesor = User::factory()->create(['rol' => 'Empleado']);
        $clase = Clase::factory()->create(['id_profesor' => $profesor->id]);

        $this->assertInstanceOf(User::class, $clase->profesor);
        $this->assertEquals($profesor->id, $clase->profesor->id);
    }

    #[Test]
    public function se_puede_registrar_un_alumno_a_una_clase_con_cupo()
    {
        $clase = Clase::factory()->create([
            'lugares' => 10,
            'lugares_ocupados' => 5,
            'lugares_disponibles' => 5
        ]);
        $alumno = User::factory()->create(['rol' => 'Cliente']);

        $this->assertTrue($clase->tieneCupo());

        $resultado = $clase->registrarAlumno($alumno);

        $this->assertTrue($resultado);
        $clase->refresh();
        $this->assertEquals(6, $clase->lugares_ocupados);
        $this->assertEquals(4, $clase->lugares_disponibles);
        $this->assertDatabaseHas('clase_user', [
            'user_id' => $alumno->id,
            'clase_id' => $clase->id
        ]);
    }

    #[Test]
    public function no_se_puede_registrar_un_alumno_a_una_clase_sin_cupo()
    {
        $clase = Clase::factory()->create([
            'lugares' => 5,
            'lugares_ocupados' => 5,
            'lugares_disponibles' => 0
        ]);
        $alumno = User::factory()->create(['rol' => 'Cliente']);

        $this->assertFalse($clase->tieneCupo());
        $resultado = $clase->registrarAlumno($alumno);

        $this->assertFalse($resultado);
        $this->assertEquals(5, $clase->lugares_ocupados);
    }

    #[Test]
    public function se_puede_liberar_un_cupo_de_un_alumno_inscrito()
    {
        $clase = Clase::factory()->create([
            'lugares' => 10,
            'lugares_ocupados' => 5,
            'lugares_disponibles' => 5
        ]);
        $alumno = User::factory()->create(['rol' => 'Cliente']);
        $clase->alumnos()->attach($alumno->id);

        $resultado = $clase->liberarCupo($alumno);

        $this->assertTrue($resultado);
        $clase->refresh();
        $this->assertEquals(4, $clase->lugares_ocupados);
        $this->assertEquals(6, $clase->lugares_disponibles);
        $this->assertDatabaseMissing('clase_user', [
            'user_id' => $alumno->id,
            'clase_id' => $clase->id
        ]);
    }
}
