<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = DB::table('classes')->get();
        $faker = Faker\Factory::create('id_ID');

        foreach($kelas as $kls){
            for($i=1; $i<=24; $i++){
                $name = strtolower($faker->firstNameMale) . ' ' . Str::random(5);

                $nim = substr(strval($kls->angkatan), 2, 2) . strtolower($kls->huruf) . strval($kls->prodi_id) . strval($i);

                $user_id = DB::table('users')->insertGetId([
                    'username' => $nim,
                    'email' => strtolower($name) . Str::random(3) . '@gmail.com',
                    'password' => Hash::make('password'),
                    'role_id' => '2',
                ]);
                DB::table('students')->insert([
                    'nim' => $nim,
                    'nama' => $name,
                    'kelas_id' => $kls->id,
                    'user_id' => $user_id
                ]);
            }
        }
    }
}
