<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiSeeder extends Seeder
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

        $kompetensi = $data->kompetensi;

        foreach($kompetensi as $komp){
            DB::table('competences')->insert([
                'id' => $komp->id,
                'aspek_kompetensi' => $komp->aspek_kompetensi
            ]);
        }
    }
}
