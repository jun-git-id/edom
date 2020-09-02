<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
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

        $prodi = $data->prodi;

        foreach($prodi as $pr){
            for($ang=2017; $ang<=2019; $ang++){
                for($hrf='A'; $hrf<='D'; $hrf++){
                    DB::table('classes')->insert([
                        'huruf' => $hrf,
                        'angkatan' => $ang,
                        'prodi_id' => $pr->id
                    ]);
                }
            }
        }
    }
}
