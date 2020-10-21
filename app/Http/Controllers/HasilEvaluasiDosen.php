<?php

namespace App\Http\Controllers;

use App\Custom\CustomFunction;
use App\Teach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilEvaluasiDosen extends Controller
{
    public function prodiShow(Request $request, $prodi_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['tahun_id'] = $tahun_akademik_id;

        $data['prodi'] = DB::table('study_programs')->where('id', $prodi_id)->first();
        $data['dosen'] = DB::select(DB::raw("
        SELECT
            dos.id, dos.nomor_induk, dos.nama, count(distinct te.kelas_id) as jml_kelas, AVG(filld.nilai) AS nilai
        FROM
            lecturers dos, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = dos.id
            and dos.prodi_id = $prodi_id
            and te.tahun_akademik_id = $tahun_akademik_id
        GROUP BY dos.id
        "));


        foreach ($data['dosen'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        return response()->json($data);
    }
    public function dosenShow(Request $request, $dosen_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['tahun_id'] = $tahun_akademik_id;


        $data['dosen'] = DB::table('lecturers')->where('id', $dosen_id)->first();
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
            and te.dosen_id = $dosen_id
            and te.tahun_akademik_id = $tahun_akademik_id
        group by te.id
        "));


        foreach ($data['ajaran'] as $dt) {
            $dt->kelas = CustomFunction::generateKelas($dt->nama_prodi, $dt->huruf, $dt->angkatan);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        return response()->json($data);
    }
    public function dosenPertShow(Request $request, $dosen_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['tahun_id'] = $tahun_akademik_id;

        $data['dosen'] = DB::table('lecturers')->where('id', $dosen_id)->first();

        $kompetensi = DB::select(DB::raw("
        SELECT
            filld.kompetensi
        FROM
            teaches te,
            fillings fill,
            filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            AND fill.mengajar_id = te.id
            and te.tahun_akademik_id = $tahun_akademik_id
            and te.dosen_id = $dosen_id
        GROUP BY filld.kompetensi
        "));

        $data['pertanyaan'] = [];
        foreach ($kompetensi as $kmp) {
            $pertanyaan = DB::select(DB::raw("
            SELECT
                filld.pertanyaan, filld.kompetensi, avg(filld.nilai) as nilai
            FROM
                teaches te, fillings fill, filling_details filld
            WHERE
                filld.pengisian_id = fill.id
                and fill.mengajar_id = te.id
                and te.tahun_akademik_id = $tahun_akademik_id
                and te.dosen_id = $dosen_id
                and filld.kompetensi = '$kmp->kompetensi'
            GROUP BY filld.pertanyaan
            "));

            foreach ($pertanyaan as $prt) {
                $data['pertanyaan'][] = $prt;
            }

        }

        foreach ($data['pertanyaan'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }

        return response()->json($data);
    }
    public function ajaranShow(Request $request, $ajaran_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());


        $teach = Teach::find($ajaran_id);

        $data['info'] = [
            'nomor_induk' => $teach->lecturer->nomor_induk,
            'nama_dosen' => $teach->lecturer->nama,

            'matkul' => $teach->course->nama_mk,
            'kelas' => CustomFunction::generateKelas($teach->class->studyProgram->nama_prodi, $teach->class->huruf, $teach->class->angkatan),
            'jml_responden' => DB::select(DB::raw("SELECT count(mahasiswa_id) as jml FROM fillings WHERE mengajar_id = $ajaran_id"))[0]->jml,

            'thn_ak' => CustomFunction::generateTahun($teach->academicYear->tahun, $teach->academicYear->ganjil_genap)
        ];

        $kompetensi = DB::select(DB::raw("
            select
                filld.kompetensi
            from
                fillings fill, filling_details filld
            where
                filld.pengisian_id = fill.id
                and fill.mengajar_id = $ajaran_id
            group by filld.kompetensi
        "));

        $data['pertanyaan'] = [];
        foreach ($kompetensi as $kmp) {
            $pertanyaan = DB::select(DB::raw("
            select
                filld.pertanyaan, filld.kompetensi, avg(filld.nilai) as nilai
            from
                fillings fill, filling_details filld
            where
                filld.pengisian_id = fill.id
                and fill.mengajar_id = $ajaran_id
                and filld.kompetensi='$kmp->kompetensi'
            group by filld.pertanyaan;
            "));

            foreach ($pertanyaan as $prt) {
                $data['pertanyaan'][] = $prt;
            }
        }

        foreach ($data['pertanyaan'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        return response()->json($data);
    }

    public function ajaranKomentar($ajaran_id)
    {
        $data = DB::table('fillings')->where('mengajar_id',$ajaran_id)->select('komentar')->get();

        return response()->json($data);

    }
}
