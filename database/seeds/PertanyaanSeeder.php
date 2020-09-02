<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSeeder extends Seeder
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

        $pertanyaan = $data->pertanyaan;

        foreach($pertanyaan as $prt){
            DB::table('questions')->insert([
                'id' => $prt->id,
                'pertanyaan' => $prt->pertanyaan,
                'kompetensi_id' => $prt->kompetensi_id
            ]);
        }
    }
}
