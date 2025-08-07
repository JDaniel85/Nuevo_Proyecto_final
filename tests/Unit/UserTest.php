<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Membresia;
use App\Models\Clase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function un_usuario_puede_ser_creado()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('Test User', $user->name);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function el_rol_del_usuario_se_formatea_correctamente()
    {
        $user = User::factory()->create(['rol' => 'admin']);

        $this->assertEquals('Admin', $user->rol);

        $user->rol = 'cliente';
        $user->save();

        $this->assertEquals('Cliente', $user->rol);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function un_usuario_tiene_relacion_con_membresias()
    {
        $user = User::factory()->create();
        Membresia::factory()->create(['id_usuario' => $user->id]);

        $this->assertInstanceOf(Membresia::class, $user->membresias->first());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function un_usuario_puede_inscribirse_a_clases()
    {
        $user = User::factory()->create();
        $clase = Clase::factory()->create();

        $user->clases()->attach($clase->id);

        $this->assertTrue($user->clases->contains($clase));
    }
}
