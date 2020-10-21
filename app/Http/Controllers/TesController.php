<?php

namespace App\Http\Controllers;

use App\Competence;
use App\Custom\CustomFunction;
use App\Events\TesEvent;
use App\Mail\TesMail;
use App\Question;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PDF;

class TesController extends Controller
{
    public function index()
    {
        /* $kompentensi = Competence::all();

        return response()->json($kompentensi[0]); */

        echo Auth::user()->username;
    }

    public function ambilQuestion()
    {
        $data = Question::all();

        return response()->json($data);
    }

    public function ui()
    {
        return view('admin.tes');
    }

    public function perMhs()
    {
        return view('admin.hasil-kuisioner.per-mhs');
    }

    public function ipkDosen()
    {
        return view('admin.hasil-kuisioner.ipk-dosen');
    }

    public function perPert()
    {
        return view('admin.hasil-kuisioner.per-pertanyaan');
    }

    public function rekapIpk()
    {
        return view('admin.hasil-kuisioner.rekap-ipk');
    }


    public function inputDosen()
    {
        $user_id = DB::table('users')->insertGetId([
            'username' =>  '1212a',
            'email' => 'kusnawansar1@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => '3'
        ]);
        DB::table('lecturers')->insert([
            'nidk' => '1212a',
            'nama' => 'kusnawansar',
            'pendidikan' => 'Sejarah',
            'bidang_ilmu' => 'Sejarah',
            'user_id' => $user_id,
            'prodi_id' => '3'
        ]);
    }

    public function epen()
    {

        $data = 'data';
        event(new TesEvent($data));
    }

    public function kirimEmail()
    {

        $data = 'data adfa faf adf';
        Mail::to('badruakfm@gmail.com')->send(new TesMail($data));
    }

    public function pdf()
    {
        $pdf = PDF::loadView('tes.pdf');
        return $pdf->stream('tadaf.pdf');
    }

    public function grafik()
    {
        return view('tes.grafik');
    }

    public function grafikPdf()
    {
        $pdf = PDF::loadView('tes.grafik-pdf');
        return $pdf->stream('grafik.pdf');
    }

    public function tesDua()
    {
        $data = file_get_contents(public_path('/data/data.json'));
        $data = json_decode($data);
        $kompetensi = $data->kompetensi;
        $pertanyaan = $data->pertanyaan;


        foreach ($pertanyaan as $prt) {

            echo "$prt->pertanyaan ||" . $kompetensi[$prt->kompetensi_id - 1]->aspek_kompetensi . " <br>";
        }
    }

    public function seeding()
    {
        echo "<!DOCTYPE html>
        <head>
            <title>Document</title>
        </head>
        <body>
            <table border='1'>
                <tr>
                    <th>no</th>
                    <th>j</th>
                    <th>i</th>
                    <th>dosen_id</th>
                    <th>kelas_id</th>
                    <th>mata_kuliah_id</th>
                    <th>tahun_akademik_id</th>
                </tr>";

        $dosen = DB::table('lecturers')->where('prodi_id', 1)->get();
        $matkul = DB::table('courses')->where('prodi_id', 1)->whereIn('semester', [1, 3, 5])->get();

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
                ['prodi_id', 1],
                ['angkatan', $ang],
            ])->get();

            foreach ($kelas as $kl) {
                $mk_id = $matkul[$i]->id;
                echo "<tr>
                        <td>$k</td>
                        <td>$j</td>
                        <td>$i</td>
                        <td>$dsn->id</td>
                        <td>$kl->id</td>
                        <td>$mk_id</td>
                        <td>1</td>
                    </tr>";
                $k++;
            }

            if ($i == 8 || $i == 18 || $i == 23) {
                $i++;
                foreach ($kelas as $kl) {

                    $mk_id = $matkul[$i]->id;
                    echo "<tr>
                        <td>$k</td>
                        <td>$j</td>
                        <td>$i</td>
                        <td>$dsn->id</td>
                        <td>$kl->id</td>
                        <td>$mk_id</td>
                        <td>1</td>
                    </tr>";
                    $k++;
                }
            }

            $i++;
            $j++;
        }

        echo "
        </table>
    </body>
    </html>";
    }

    public function seeding2()
    {
        echo "<!DOCTYPE html>
        <head>
            <title>Document</title>
        </head>
        <body>
            <table border='1'>
                <tr>
                    <th>no</th>
                    <th>j</th>
                    <th>i</th>
                    <th>dosen_id</th>
                    <th>kelas_id</th>
                    <th>mata_kuliah_id</th>
                    <th>tahun_akademik_id</th>
                </tr>";

        $dosen = DB::table('lecturers')->where('prodi_id', 1)->get();
        $matkul = DB::table('courses')->where('prodi_id', 1)->whereIn('semester', [2, 4, 6])->get();

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
                ['prodi_id', 1],
                ['angkatan', $ang],
            ])->get();

            foreach ($kelas as $kl) {
                $mk_id = $matkul[$i]->id;
                echo "<tr>
                        <td>$k</td>
                        <td>$j</td>
                        <td>$i</td>
                        <td>$dsn->id</td>
                        <td>$kl->id</td>
                        <td>$mk_id</td>
                        <td>1</td>
                    </tr>";
                $k++;
            }

            if ($i == 8 || $i == 18) {
                $i++;
                foreach ($kelas as $kl) {

                    $mk_id = $matkul[$i]->id;
                    echo "<tr>
                        <td>$k</td>
                        <td>$j</td>
                        <td>$i</td>
                        <td>$dsn->id</td>
                        <td>$kl->id</td>
                        <td>$mk_id</td>
                        <td>1</td>
                    </tr>";
                    $k++;
                }
            }

            if ($i == 23) {
                for ($m = 1; $m <= 3; $m++) {
                    $i++;
                    foreach ($kelas as $kl) {

                        $mk_id = $matkul[$i]->id;
                        echo "<tr>
                        <td>$k</td>
                        <td>$j</td>
                        <td>$i</td>
                        <td>$dsn->id</td>
                        <td>$kl->id</td>
                        <td>$mk_id</td>
                        <td>1</td>
                    </tr>";
                        $k++;
                    }
                }
            }

            $i++;
            $j++;
        }

        echo "
        </table>
    </body>
    </html>";
    }

    public function seeding3()
    {
        $tahun_akademik = DB::table('academic_years')->get();
        foreach ($tahun_akademik as $tak) {
            if ($tak->ganjil_genap == 'ganjil') {
                echo "ganjil<br>";
            } else {
                echo "genap<br>";
            }
        }
    }


    public function takeMhs($skip, $take)
    {
        $mahasiswa = DB::table('students')->skip($skip)->take($take)->get();
        $data = [];

        foreach ($mahasiswa as $mhs) {
            $mhs_arr = [];

            $mengajar = DB::table('teaches')->where([
                'kelas_id' => $mhs->kelas_id,
                'tahun_akademik_id' => 1
            ])->get();


            foreach ($mengajar as $mgr) {
                $mhs_arr[] = [
                    'mhs_id' => $mhs->id,
                    'mengajar_id' => $mgr->id
                ];
            }


            $data[] = $mhs_arr;
        }

        return $data;
    }

    public function seeding4()
    {
        $data = $this->takeMhs(100, 100);
        return response()->json($data);
    }

    public function seedingPengisianSeeder1()
    {
        $data = $this->takeMhs(0, 336);
        return response()->json($data);
    }
    public function seedingPengisianSeeder2()
    {
        $data = $this->takeMhs(336, 336);
        return response()->json($data);
    }
    public function seedingPengisianSeeder3()
    {
        $data = $this->takeMhs(672, 336);
        return response()->json($data);
    }
    public function seedingPengisianSeeder4()
    {
        $data = $this->takeMhs(1008, 336);
        return response()->json($data);
    }
    public function seedingPengisianSeeder5()
    {
        $data = $this->takeMhs(1344, 336);
        return response()->json($data);
    }
    public function seedingPengisianSeeder6()
    {
        $data = $this->takeMhs(1680, 336);
        return response()->json($data);
    }

    public function seeding5()
    {
        # code...
    }


    public function ui2()
    {
        return view('tes.ui2');
    }

    public function tesPost()
    {
        $data['ajaran'] = DB::select(DB::raw("
        select
            te.id, pro.nama_prodi, kls.huruf, kls.angkatan, mk.nama_mk, count(distinct fill.mahasiswa_id) as jml_responden, avg(filld.nilai) as nilai
        from
            courses mk, study_programs pro, classes kls, teaches te, fillings fill, filling_details filld
        where
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.kelas_id = kls.id
            and kls.prodi_id = pro.id
            and te.mata_kuliah_id = mk.id
            and te.dosen_id = 45
            and te.tahun_akademik_id = 2
        group by te.id
        "));


        foreach ($data['ajaran'] as $dt) {
            $dt->kelas = CustomFunction::generateKelas($dt->nama_prodi, $dt->huruf, $dt->angkatan);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }



        /* $arr = [
            'A1',
            'A2',
            'A3',
            'A4'
        ];
        $arr2 = [
            40,
            50,
            60,
            80,
        ]; */

        $arr = [];
        $arr2 = [];
        foreach($data['ajaran'] as $dt){
            $arr[] = $dt->kelas;
            $arr2[] = $dt->nilai;
        }

        $arr_im =  implode("','",$arr);
        $arr2_im = implode(',',$arr2);

        //return $arr_im;

        $response = Http::post('https://quickchart.io/chart/create', [
            'chart' => "{
                type: 'bar',
                data: {
                  labels: ['".$arr_im."'],
                  datasets: [
                    {
                      label: 'Users',
                      data: [".$arr2_im."],
                      backgroundColor: 'rgba(54, 162, 235, 0.5)',
                      borderColor: 'rgb(54, 162, 235)',
                      borderWidth: 1,
                    },
                  ],
                },
                options: {
                  title: {
                    display: true,
                    text: 'Chart.js Line Chart',
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

        $url = $response->json()['url'];

        $pdf = PDF::loadView('grafik.pdf2', compact('url'));
        return $pdf->stream('pdf.pdf');


    }
}
