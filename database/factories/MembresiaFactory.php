<?php

namespace Database\Factories;

use App\Models\Membresia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembresiaFactory extends Factory
{
    protected $model = Membresia::class;

    public function definition()
    {
        $adquiridas = $this->faker->numberBetween(8, 20);
        $ocupadas = $this->faker->numberBetween(0, $adquiridas);

        return [
            'id_usuario' => User::factory(),
            'clases_adquiridas' => $adquiridas,
            'clases_ocupadas' => $ocupadas,
            'clases_disponibles' => $adquiridas - $ocupadas,
        ];
    }
}
