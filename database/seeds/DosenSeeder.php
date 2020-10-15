<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('id_ID');

        $data = file_get_contents(public_path('/data/data.json'));
        $data = json_decode($data);

        $prodi = $data->prodi;



        foreach ($prodi as $pr) {

            for ($i = 1; $i <= 22; $i++) {
                $name = strtolower($faker->firstNameMale) . ' ' . Str::random(5);

                $ni =  '1990'.strval($pr->id) . strval($i);

                $user_id = DB::table('users')->insertGetId([
                    'username' => $ni,
                    'email' => strtolower($name) . Str::random(3) . '@gmail.com',
                    'password' => Hash::make('password'),
                    'role_id' => '3',
                ]);

                DB::table('lecturers')->insert([
                    'nomor_induk' => $ni,
                    'nama' => $name,
                    'user_id' => $user_id,
                    'prodi_id' => $pr->id
                ]);
            }
        }
    }
}
