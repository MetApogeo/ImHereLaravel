<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Faker\Factory as Faker;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Usuario::create([
                'nombre' => $faker->name,
                'contraseña' => bcrypt('password'),
                'correo' => $faker->unique()->safeEmail,
                'id_perfil' => $faker->numberBetween(1, 2), // Ejemplo para asignar un perfil aleatorio
                'fecha' => $faker->date(),
                'sexo' => $faker->randomElement(['masculino', 'femenino']),
                'coin' => $faker->randomNumber(),
                'imagen' => $faker->imageUrl()
            ]);
        }
    }
}
