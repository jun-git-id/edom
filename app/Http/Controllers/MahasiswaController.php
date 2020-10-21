<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Competence;
use App\Custom\CustomFunction;
use App\Filling;
use App\FillingDetail;
use App\Http\Resources\DaftarDosenResource;
use App\Question;
use App\Share;
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

        $mhs_id = Auth::user()->student->id;
        return view('mhs.home', compact('mhs_id'));
    }

    public function ambilLastBagikan()
    {
        return Share::all()->last()->tahun_akademik_id;
    }
    public function daftarDosen(Request $request, $mhs_id)
    {
        $mhs = Student::find($mhs_id);
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = $this->ambilLastBagikan());
        $tahunAk = AcademicYear::find($tahun_akademik_id);

        $data['info'] = [
            'kelas' => CustomFunction::generateKelas($mhs->class->studyProgram->nama_prodi, $mhs->class->huruf, $mhs->class->angkatan),
            'tahun_akademik' => CustomFunction::generateTahun($tahunAk->tahun, $tahunAk->ganjil_genap)
        ];

        $data['ajaran'] = DB::select(DB::raw("
        SELECT
            te.id, dos.nama, mk.nama_mk, mk.sks
        FROM
            courses mk, lecturers dos, teaches te
        WHERE
            te.dosen_id = dos.id
            and te.mata_kuliah_id = mk.id
            and te.kelas_id = $mhs->kelas_id
            and tahun_akademik_id = $tahun_akademik_id
        "));

        foreach ($data['ajaran'] as $dt) {
            $dt->status = $this->status($mhs->id,$dt->id);
        }

        return response()->json($data);

        //return DaftarDosenResource::collection($data, 'abc');
        //return new DaftarDosenResource($mhs);
    }

    public function status($mhs_id, $mengajar_id)
    {
        $data = Filling::where([
            'mahasiswa_id' => $mhs_id,
            'mengajar_id' => $mengajar_id
        ])->first();

        if($data){
            return 'Kuisioner Sudah Diisi';
        }else{
            return 'Kuisioner Belum Diisi';
        }
    }

    public function kuisioner(Request $request, $mengajar_id)
    {
        $mhs_id = Auth::user()->student->id;
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());

        $ajaran = DB::select(Db::raw("
                SELECT
            dos.nomor_induk, dos.nama, pro.nama_prodi, kls.huruf, kls.angkatan, mk.nama_mk, thn.tahun, thn.ganjil_genap
        FROM
            academic_years thn, courses mk, study_programs pro, classes kls, lecturers dos, teaches te
        WHERE
            te.dosen_id = dos.id
            and te.kelas_id = kls.id
            and kls.prodi_id = pro.id
            and te.mata_kuliah_id = mk.id
            and te.tahun_akademik_id = thn.id
            and te.id = $mengajar_id
            and thn.id = $tahun_akademik_id;
        "))[0];

        $ajaran->kelas = CustomFunction::generateKelas($ajaran->nama_prodi, $ajaran->huruf, $ajaran->angkatan);
        $ajaran->mengajar_id = $mengajar_id;


        $kompetensi = Competence::all();

        //return response()->json($ajaran);
        return view('mhs.isi', compact('ajaran', 'kompetensi'));
    }

    public function insertKuisioner(Request $request)
    {
        $mhs_id = Auth::user()->student->id;

        //return response()->json($request->nilai);


        $nilai = $request->nilai;

        $pengisian = Filling::create([
            'tgl_pengisian' => date('Y-m-d H:i:s'),
            'mahasiswa_id' => $mhs_id,
            'mengajar_id' => $request->mengajar_id,
            'komentar' => $request->komentar
        ]);

        $pertanyaan = Question::all();
        $nilai = $request->nilai;


        foreach ($pertanyaan as $prt) {
            FillingDetail::create([
                'pengisian_id' => $pengisian->id,
                'pertanyaan' => $prt->pertanyaan,
                'kompetensi' => $prt->competence->aspek_kompetensi,
                'nilai' => $nilai[$prt->id]
            ]);
        }

        return redirect('/mhs')->with('status','Terima kasih sudah mengisi.');
    }


    public function jmlMatkul($kls_id, $tak_id)
    {
        return (int)DB::select(DB::raw("select count(id) from teaches where kelas_id=$kls_id and tahun_akademik_id=$tak_id"));
    }

    public function statusMhs($nim, $thn, $ganjil_genap)
    {
        $thn = implode('/',explode('-', $thn));
        $thn_akd = AcademicYear::where([
            'tahun' => $thn,
            'ganjil_genap' => $ganjil_genap
        ])->first()->id;

        //18a31/2019
        $mhs = Student::where('nim',$nim)->first();

        $data = DB::table('fillings')
        ->join('teaches','fillings.mengajar_id','=','teaches.id')
        ->join('academic_years','teaches.tahun_akademik_id','academic_years.id')
        ->select('fillings.*','academic_years.tahun', 'academic_years.ganjil_genap')
        ->where([
            ['fillings.mahasiswa_id','=',$mhs->id],
            ['teaches.tahun_akademik_id','=',$thn_akd]
        ])
        ->get();


        if($data->count() < $this->jmlMatkul($mhs->kelas_id, $thn_akd)){
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
