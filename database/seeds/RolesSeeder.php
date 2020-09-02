<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
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

        $roles = $data->roles;

        foreach($roles as $rl){
            DB::table('roles')->insert([
                'id' => $rl->id,
                'role' => $rl->role
            ]);
        }
    }
}
