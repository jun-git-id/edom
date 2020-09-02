<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
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

        $jurusan = $data->jurusan;

        foreach($jurusan as $jrs){
            DB::table('majors')->insert([
                'id' => $jrs->id,
                'nama_jurusan' => $jrs->nama_jurusan
            ]);
        }
    }
}
