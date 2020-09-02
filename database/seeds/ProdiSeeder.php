<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
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


        foreach ($prodi as $pr) {
            DB::table('study_programs')->insert([
                'id' => $pr->id,
                'nama_prodi' => $pr->nama_prodi,
                'jurusan_id' => $pr->jurusan_id
            ]);
        }
    }
}
