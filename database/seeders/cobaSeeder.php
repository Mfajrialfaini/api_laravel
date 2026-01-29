<?php

namespace Database\Seeders;

use App\Models\coba;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class cobaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            coba::create([
                'nama' => $faker->name(),
                'NRP' => $faker->numberBetween(100000, 999999),
                'password' => bcrypt('password'),
            ]);
        }
    }
}
