<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Detalle_Transaccion;
use App\Models\Carrito_Compras;
use Faker\Factory as Faker;

class DetalleTransaccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Obtenemos todos los IDs de los carritos de compra disponibles
        $carritosIds = Carrito_Compras::pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            Detalle_Transaccion::create([
                'id_producto' => $faker->randomNumber(5),
                'cantidad' => $faker->numberBetween(1, 10),
                'precio' => $faker->randomFloat(2, 10, 1000),
                'id_carrito' => $faker->randomElement($carritosIds),
            ]);
        }
    }
}
