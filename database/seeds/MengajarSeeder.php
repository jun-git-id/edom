<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MengajarSeeder extends Seeder
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
            $dosen = DB::table('lecturers')->where('prodi_id', $pr->id)->get();
            $matkul = DB::table('courses')->where('prodi_id', $pr->id)->whereIn('semester', [1, 3, 5])->get();

            $i = 0;
            foreach ($dosen as $dsn) {
                $kelas_id = 0;
                switch ($matkul[$i]->semester) {
                    case 1:
                        $ang = 2019;
                        break;
                    case 3:
                        $ang = 2018;
                        break;
                    case 5:
                        $ang = 2017;
                        break;
                }
                $kelas = DB::table('classes')->where([
                    ['prodi_id', $pr->id],
                    ['angkatan', $ang],
                ])->get();

                foreach ($kelas as $kl) {
                    DB::table('teaches')->insert([
                        'dosen_id' => $dsn->id,
                        'kelas_id' => $kl->id,
                        'mata_kuliah_id' => $matkul[$i]->id,
                        'tahun' => 2019
                    ]);
                }
                $i++;
            }
        }
    }
}
