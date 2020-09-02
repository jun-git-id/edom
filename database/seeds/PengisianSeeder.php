<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengisianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = DB::table('classes')->where([
            ['prodi_id',3],
            ['angkatan',2018]
        ])->get();

        foreach($kelas as $kls){
            $mahasiswa = DB::table('students')->where('kelas_id',$kls->id)->get();

            foreach($mahasiswa as $mhs){
                $mengajar = DB::table('teaches')->where('kelas_id', $kls->id)->get();

                foreach($mengajar as $mgr){
                    DB::table('fillings')->insert([
                        'tgl_pengisian' => '2019-12-12 12:00:00',
                        'mahasiswa_id' => $mhs->id,
                        'mengajar_id' => $mgr->id
                    ]);
                }
            }
        }
    }
}
