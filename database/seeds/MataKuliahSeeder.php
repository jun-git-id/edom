<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
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

        $mata_kuliah =  $data->mata_kuliah;

        foreach ($mata_kuliah as $mk) {
            DB::table('courses')->insert([
                'id' => $mk->id,
                'nama_mk' => $mk->nama_mk,
                'sks' => $mk->sks,
                'semester' => $mk->semester,
                'prodi_id' => $mk->prodi_id
            ]);
        }

        $prodi = $data->prodi;
        foreach ($prodi as $pr) {
            if($pr->id == 3){
                continue;
            }
            for ($smt_i = 1; $smt_i <= 6; $smt_i++) {
                switch ($smt_i) {
                    case 5:
                        //teori
                        for ($i = 1; $i <= 4; $i++) {
                            DB::table('courses')->insert([
                                'nama_mk' => "MK $pr->nama_prodi Smt$smt_i Teo$i",
                                'sks' => '2',
                                'semester' => $smt_i,
                                'prodi_id' => $pr->id
                            ]);
                        }

                        //praktek
                        DB::table('courses')->insert([
                            'nama_mk' => "Magang Industri",
                            'sks' => '10',
                            'semester' => $smt_i,
                            'prodi_id' => $pr->id
                        ]);
                        break;
                    case 6:
                        //teori
                        for ($i = 1; $i <= 5; $i++) {
                            DB::table('courses')->insert([
                                'nama_mk' => "MK $pr->nama_prodi Smt$smt_i Teo$i",
                                'sks' => '2',
                                'semester' => $smt_i,
                                'prodi_id' => $pr->id
                            ]);
                        }

                        //praktek
                        DB::table('courses')->insert([
                            'nama_mk' => "Praktek Teknik Supervisi",
                            'sks' => '2',
                            'semester' => $smt_i,
                            'prodi_id' => $pr->id
                        ]);
                        DB::table('courses')->insert([
                            'nama_mk' => "Tugas Akhir",
                            'sks' => '6',
                            'semester' => $smt_i,
                            'prodi_id' => $pr->id
                        ]);
                        break;
                    default:
                        //teori
                        for ($i = 1; $i <= 5; $i++) {
                            DB::table('courses')->insert([
                                'nama_mk' => "MK $pr->nama_prodi Smt$smt_i Teo$i",
                                'sks' => '2',
                                'semester' => $smt_i,
                                'prodi_id' => $pr->id
                            ]);
                        }
                        //praktek
                        for ($i = 1; $i <= 5; $i++) {
                            DB::table('courses')->insert([
                                'nama_mk' => "MK $pr->nama_prodi Smt$smt_i Prak$i",
                                'sks' => '2',
                                'semester' => $smt_i,
                                'prodi_id' => $pr->id
                            ]);
                        }
                        break;
                }
            }
        }
    }
}
