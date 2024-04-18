<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
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
            'descripcion' => $this->text(),
            'precio' => 100,
            'inventario' => 1,
        ];
    }
}
