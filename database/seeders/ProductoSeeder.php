<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use Faker\Factory as Faker;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 15) as $index) {
            Producto::create([
                'nombre' => $faker->name,
                'descripcion' => $faker->sentence(),
                'precio' => $faker->randomFloat(2, 0, 150),
                'inventario' => $faker->randomNumber(2, 1000),


            ]);
        }
    }
}
