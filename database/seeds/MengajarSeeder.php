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



        $tahun_akademik = DB::table('academic_years')->get();
        $l = 1;
        foreach ($tahun_akademik as $tak) {
            if ($tak->ganjil_genap == 'ganjil') {
                $m = 1;
                foreach ($prodi as $pr) {

                    $dosen = DB::table('lecturers')->where('prodi_id', $pr->id)->get();
                    $matkul = DB::table('courses')->where('prodi_id', $pr->id)->whereIn('semester', [1, 3, 5])->get();

                    $k = 1;
                    $i = 0;
                    $j = 1;

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
                                'tahun_akademik_id' => $tak->id
                            ]);
                            //$this->command->line("$l $m");
                            $m++;
                            $l++;
                            $k++;
                        }

                        if ($i == 8 || $i == 18 || $i == 23) {
                            $i++;
                            foreach ($kelas as $kl) {

                                DB::table('teaches')->insert([
                                    'dosen_id' => $dsn->id,
                                    'kelas_id' => $kl->id,
                                    'mata_kuliah_id' => $matkul[$i]->id,
                                    'tahun_akademik_id' => $tak->id
                                ]);

                                //$this->command->line("$l $m");
                                $m++;
                                $l++;
                                $k++;
                            }
                        }

                        $i++;
                        $j++;
                    }
                }
            } else {
                foreach ($prodi as $pr) {

                    $dosen = DB::table('lecturers')->where('prodi_id', $pr->id)->get();
                    $matkul = DB::table('courses')->where('prodi_id', $pr->id)->whereIn('semester', [2, 4, 6])->get();

                    $k = 1;
                    $i = 0;
                    $j = 1;
                    foreach ($dosen as $dsn) {
                        $kelas_id = 0;
                        switch ($matkul[$i]->semester) {
                            case 2:
                                $ang = 2019;
                                break;
                            case 4:
                                $ang = 2018;
                                break;
                            case 6:
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
                                'tahun_akademik_id' => $tak->id
                            ]);

//                            $this->command->line("$l");
                            $l++;
                            $k++;
                        }

                        if ($i == 8 || $i == 18) {
                            $i++;
                            foreach ($kelas as $kl) {

                                DB::table('teaches')->insert([
                                    'dosen_id' => $dsn->id,
                                    'kelas_id' => $kl->id,
                                    'mata_kuliah_id' => $matkul[$i]->id,
                                    'tahun_akademik_id' => $tak->id
                                ]);

                                //$this->command->line("$l");
                                $l++;
                                $k++;
                            }
                        }

                        if ($i == 23) {
                            for ($m = 1; $m <= 3; $m++) {
                                $i++;
                                foreach ($kelas as $kl) {

                                    DB::table('teaches')->insert([
                                        'dosen_id' => $dsn->id,
                                        'kelas_id' => $kl->id,
                                        'mata_kuliah_id' => $matkul[$i]->id,
                                        'tahun_akademik_id' => $tak->id
                                    ]);

                                    //$this->command->line("$l");
                                    $l++;
                                    $k++;
                                }
                            }
                        }

                        $i++;
                        $j++;
                    }
                }
            }
        }
    }
}
