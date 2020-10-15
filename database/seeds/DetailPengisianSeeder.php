<?php

use App\Filling;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPengisianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengisian = DB::table('fillings')->get();

        $pengisian = Filling::all();

        $data = file_get_contents(public_path('/data/data.json'));
        $data = json_decode($data);

        $pertanyaan = $data->pertanyaan;
        $kompetensi = $data->kompetensi;

        foreach($pengisian as $pngs){
            foreach($pertanyaan as $prt){
                DB::table('filling_details')->insert([
                    'pengisian_id' => $pngs->id,
                    'pertanyaan' => $prt->pertanyaan,
                    'kompetensi' => $kompetensi[$prt->kompetensi_id - 1]->aspek_kompetensi,
                    'nilai' => random_int(1,4)
                ]);
            }
        }
    }
}
