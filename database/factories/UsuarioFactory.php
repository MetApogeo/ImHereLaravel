<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->fake()->name(),
            'contraseña' => "81dc9bdb52d04dc20036dbd8313ed055",
            'correo' => $this->faker->unique()->safeEmail(),
            'id_perfil' => 3,
            'edad' => rand(5, 15),
            'sexo',
        ];
    }
}
