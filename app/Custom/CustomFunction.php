<?php

namespace App\Custom;

use App\AcademicYear;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDF;

class CustomFunction
{
    public static function ambilKesimpulan($nilai)
    {
        $kesimpulan = '';

        if ($nilai == 4) {
            $kesimpulan = 'Baik Sekali';
        } else if ($nilai >= 3) {
            $kesimpulan = 'Baik';
        } else if ($nilai >= 2) {
            $kesimpulan = 'Cukup';
        } else if ($nilai >= 1) {
            $kesimpulan = 'Buruk';
        }

        return $kesimpulan;
    }

    public static function generateKelas($prodi, $huruf, $ang)
    {
        $prodi = substr($prodi, 3);

        $prodi = explode(' ',$prodi);


        return substr($prodi[0],0,1).substr($prodi[1],0,1) .' '. $huruf . ' '.$ang;
    }

    public static function generateTahun($tahun, $ganjil_genap)
    {
        return $tahun.' '.$ganjil_genap;
    }

    public static function ambilLastTahunAc()
    {
        $tahun = AcademicYear::all()->last();

        return $tahun->id;
    }

    public static function getTak($tahun_akademik_id)
    {
        $data = DB::table('academic_years')->where('id', $tahun_akademik_id)->first();

        return $data->tahun . ' ' . $data->ganjil_genap;
    }

    public static function getNilaiAkhir($data_arr)
    {
        $data = collect($data_arr);

        $rata2 = $data->avg('nilai');
        $kesimpulan = CustomFunction::ambilKesimpulan($rata2);

        return [
            'rata2' => CustomFunction::toPersen($rata2),
            'kesimpulan' => $kesimpulan
        ];
    }

    public static function seedMhs($skip, $take)
    {
        $mahasiswa = DB::table('students')->skip($skip)->take($take)->get();

        foreach ($mahasiswa as $mhs) {

            $mengajar = DB::table('teaches')->where([
                'kelas_id' => $mhs->kelas_id,
                'tahun_akademik_id' => 2
            ])->get();


            foreach ($mengajar as $mgr) {
                DB::table('fillings')->insert([
                    'tgl_pengisian' => '2019-12-12 12:00:00',
                    'komentar' => 'lorem ipsum dolor sit amet. Amerta buarta suarta bata. Gala gala gala. Tobangga tobannga. Ohaya',
                    'mahasiswa_id' => $mhs->id,
                    'mengajar_id' => $mgr->id
                ]);
            }
        }
    }
    public static function seedFill($skip, $take)
    {
        $pengisian = DB::table('fillings')->skip($skip)->take($take)->get();

        $data = file_get_contents(public_path('/data/data.json'));
        $data = json_decode($data);

        $pertanyaan = $data->pertanyaan;
        $kompetensi = $data->kompetensi;

        foreach ($pengisian as $pngs) {
            foreach ($pertanyaan as $prt) {
                DB::table('filling_details')->insert([
                    'pengisian_id' => $pngs->id,
                    'pertanyaan' => $prt->pertanyaan,
                    'kompetensi' => $kompetensi[$prt->kompetensi_id - 1]->aspek_kompetensi,
                    'nilai' => random_int(1, 4)
                ]);
            }
        }
    }

    public static function toPersen($nilai)
    {
        $nilai = (string)$nilai*25;
        $nilai = substr($nilai,0,5);
        $nilai = $nilai . '%';

        return $nilai;
    }

    public static function toPersenGrafik($nilai)
    {
        $nilai = (string)$nilai*25;
        $nilai = substr($nilai,0,5);
        $nilai = (float)$nilai;

        return $nilai;
    }

    public static function pdfGrafik($data, $label_name, $title)
    {
        $label_gr = [];
        $data_gr = [];

        foreach($data as $dt){
            $label_gr[] = $dt->$label_name;
            $data_gr[] = CustomFunction::toPersenGrafik($dt->nilai);
        }



        $label_gr =  implode("','",$label_gr);
        $data_gr = implode(',',$data_gr);



        //return $arr2_im;

        $response = Http::post('https://quickchart.io/chart/create', [

            'chart' => "{
                type: 'bar',
                data: {
                  labels: ['".$label_gr."'],
                  datasets: [
                    {
                      label: 'Nilai',
                      data: [".$data_gr."],
                      backgroundColor: 'rgba(54, 162, 235, 0.5)',
                      borderColor: 'rgb(54, 162, 235)',
                      borderWidth: 1,
                    },
                  ],
                },
                options: {
                  title: {
                    display: true,
                    text: '".$title."',
                  },
                  plugins: {
                    datalabels: {
                      anchor: 'center',
                      align: 'center',
                      color: '#fff',
                      font: {
                        weight: 'bold',
                      },
                    },
                  },
                },
              }"
        ]);


        return $response->json()['url'];


    }
    public static function pdfGrafikLine($data, $title)
    {
        $label_gr = [];
        $data_gr = [];

        foreach($data as $dt){
            $label_gr[] = $dt->tahunFinal;
            $data_gr[] = CustomFunction::toPersenGrafik($dt->nilai);
        }



        $label_gr =  implode("','",$label_gr);
        $data_gr = implode(',',$data_gr);



        //return $arr2_im;
        //labels: ['".$label_gr."'],
        //data: [".$data_gr."],
        //text: '".$title."',

        $response = Http::post('https://quickchart.io/chart/create', [

            'chart' => "{
                type: 'line',
                data: {
                    labels: ['".$label_gr."'],
                  datasets: [
                    {
                        label: 'Nilai',
                      fill: false,
                      backgroundColor: 'rgb(54, 162, 235)',
                      borderColor: 'rgb(54, 162, 235)',
                      data: [".$data_gr."],
                    },
                  ],
                },
                options: {
                  title: {
                    display: true,
                    text: '".$title."',
                  },
                    plugins: {
                    datalabels: {
                      anchor: 'center',
                      align: 'center',
                      color: '#000',
                      font: {
                        weight: 'bold',
                      },
                    },
                  },
                },
              }"
        ]);


        return $response->json()['url'];


    }



}
