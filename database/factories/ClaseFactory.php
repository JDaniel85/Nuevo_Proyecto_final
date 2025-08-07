<?php

namespace Database\Factories;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaseFactory extends Factory
{
    protected $model = Clase::class;

    public function definition()
    {
        $lugares = $this->faker->numberBetween(10, 25);
        $ocupados = $this->faker->numberBetween(0, $lugares);

        return [
            'fecha' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            'id_profesor' => User::factory()->create(['rol' => 'Empleado'])->id,
            'tipo' => $this->faker->randomElement(['Yoga', 'Spinning', 'Funcional']),
            'lugares' => $lugares,
            'lugares_ocupados' => $ocupados,
            'lugares_disponibles' => $lugares - $ocupados,
        ];
    }
}
