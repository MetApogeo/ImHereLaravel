<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrito_Compras;
use Faker\Factory as Faker;

class CarritoComprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generamos datos falsos para 20 carritos de compras
        foreach (range(1, 20) as $index) {
            $timestamp = $faker->dateTimeBetween('-1 year', 'now');

            Carrito_Compras::create([
                'id_usuario' => $faker->randomNumber(5),
                'estado' => $faker->randomElement(['pendiente', 'completado', 'cancelado']),
                'total' => $faker->randomFloat(2, 10, 1000),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }
    }
}
