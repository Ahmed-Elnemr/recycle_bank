<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $faker=Faker::create();
    foreach (range(1,100) as $index) {
        DB::table('users')->insert([
            'name' => $faker->unique()->name,
            'email' => $faker->email(),
            'role_id' => $faker->numberBetween(1, 3),
            'password' => $faker->sha1()
        ]);
    }
    }
}
