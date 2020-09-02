<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(public_path('/data/data.json'));
        $data = json_decode($data);

        $admin = $data->admin;

        foreach($admin as $adm){
            $user_id = DB::table('users')->insertGetId([
                'username' => strtolower($adm->nama),
                'email' => strtolower($adm->nama) . Str::random(3) . '@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => '1',
            ]);
            DB::table('admins')->insert([
                'id' => $adm->id,
                'nama' => $adm->nama,
                'user_id' => $user_id
            ]);
        }
    }
}
