<?php

namespace App\Http\Controllers;

use App\Course;
use App\Custom\CustomFunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilEvaluasiMatkul extends Controller
{
    public function prodiShow(Request $request, $prodi_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());

        $data['prodi'] = DB::table('study_programs')->where('id',$prodi_id)->first();
        $data['matkul'] = DB::select(DB::raw("SELECT
            mk.id, mk.nama_mk, mk.semester, count(distinct te.dosen_id) as jml_dosen, avg(filld.nilai) as nilai
        FROM
            courses mk, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.mata_kuliah_id = mk.id
            and mk.prodi_id=$prodi_id
            and te.tahun_akademik_id=$tahun_akademik_id
        GROUP BY mk.id
        "));

        foreach ($data['matkul'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        return response()->json($data);
    }
    public function matkulShow(Request $request, $matkul_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());

        $course = Course::find($matkul_id);
        $data['matkul'] = $course->nama_mk;
        $data['prodi'] = $course->studyProgram->nama_prodi;
        $data['dosen'] = DB::select(DB::raw("SELECT
            dos.id, dos.nomor_induk, dos.nama, avg(filld.nilai) as nilai
        FROM
            courses mk, lecturers dos, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = dos.id
            and te.mata_kuliah_id = mk.id
            and mk.id = $matkul_id
            and te.tahun_akademik_id=$tahun_akademik_id
        GROUP BY dos.id
        order by nilai desc
        "));

        foreach ($data['dosen'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        return response()->json($data);
    }
}
