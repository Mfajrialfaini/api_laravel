<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Admin
        User::create([
            'nama' => 'Admin Utama',
            'NRP' => '100001',
            'password' => 'password',
            'role' => 'admin',
            'tingkat_kesatuan' => 'Polda',
            'foto' => null,
        ]);

        // User random
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'nama' => $faker->name(),
                'NRP' => $faker->unique()->numberBetween(100000, 999999),
                'password' => 'password',
                'role' => 'user',
                'tingkat_kesatuan' => $faker->randomElement([
                    'Polres',
                    'Polsek',
                    'Polda'
                ]),
                'foto' => null,
            ]);
        }
    }
}
