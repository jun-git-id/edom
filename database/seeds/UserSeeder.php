<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('id_ID');
        for($i=1; $i<=3; $i++){
            $name = strtolower($faker->firstNameMale);

            DB::table('users')->insert([
                'username' => $name,
                'email' => $name. strtolower(Str::random(3)) .'@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
