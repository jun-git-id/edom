<?php

namespace App\Http\Controllers;

use App\Filling;
use App\FillingDetail;
use App\Http\Resources\DaftarDosenResource;
use App\Question;
use App\Student;
use App\Teach;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index()
    {
        # code...
    }
    public function daftarDosen()
    {
        $mhs = Student::find(673);

        //return DaftarDosenResource::collection($data, 'abc');
        return new DaftarDosenResource($mhs);
    }

    public function kuisioner($mengajar_id)
    {
        $mhs_id = 673;

        $mengajar = Teach::find($mengajar_id);

        $data = [
            'nik_dosen' => $mengajar->lecturer->nidk,
            'nama_dosen' => $mengajar->lecturer->nama,
            'tahun_akademik' => $mengajar->tahun,
            'matkul' => $mengajar->course->nama_mk,
            'kelas' => $mengajar->class->studyProgram->nama_prodi . $mengajar->class->huruf . $mengajar->class->angkatan,
            'prodi' => $mengajar->class->studyProgram->nama_prodi
        ];

        return response()->json($data);
    }

    public function insertKuisioner(Request $request)
    {
        $mhs_id = 673;

        $pengisian = Filling::create([
            'tgl_pengisian' => '2020-05-05 12:12:12',
            'mahasiswa_id' => $mhs_id,
            'mengajar_id' => $request->mengajar_id
        ]);

        $pertanyaan = Question::all();
        $nilai = $request->nilai;


        $i = 0;
        foreach ($pertanyaan as $prt) {
            FillingDetail::create([
                'pengisian_id' => $pengisian->id,
                'pertanyaan' => $prt->pertanyaan,
                'kompetensi' => $prt->competence->aspek_kompetensi,
                'nilai' => $nilai[$i]
            ]);

            $i++;
            if ($i == 2) {
                break;
            }
        }
    }

    public function statusMhs($nim, $thn_akd)
    {
        //18a31/2019
        $mhs_id = Student::where('nim',$nim)->first()->id;

        $data = DB::table('fillings')
        ->join('teaches','fillings.mengajar_id','=','teaches.id')
        ->select('fillings.*','teaches.tahun')
        ->where([
            ['fillings.mahasiswa_id','=',$mhs_id],
            ['teaches.tahun','=',$thn_akd]
        ])
        ->get();


        if($data->count() < 10){
            $data = [
                'statusPengisian' => 'belum selesai'
            ];
        }else{
            $data = [
                'statusPengisian' => 'selesai'
            ];
        }
        return response()->json($data);


    }
}
