<?php

namespace App\Http\Controllers;

use App\Custom\CustomFunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilEvaluasiJurusan extends Controller
{
    public function jurusan(Request $request)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data = DB::select(DB::raw("SELECT
            jur.id, jur.nama_jurusan, avg(filld.nilai) as nilai
        FROM
            majors jur, study_programs pro, lecturers dos, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = dos.id
            and dos.prodi_id = pro.id
            and pro.jurusan_id = jur.id
            and te.tahun_akademik_id = $tahun_akademik_id
        GROUP BY jur.id
        "));

        foreach ($data as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        return response()->json($data);
    }
    public function jurusanShow(Request $request, $jurusan_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());

        $data['jurusan'] = DB::table('majors')->where('id', $jurusan_id)->first()->nama_jurusan;
        $data['prodi'] = DB::select(DB::raw("SELECT
            pro.id, pro.nama_prodi, avg(filld.nilai) as nilai
        FROM
            study_programs pro, lecturers dos, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = dos.id
            and dos.prodi_id = pro.id
            and pro.jurusan_id = $jurusan_id
            and te.tahun_akademik_id = $tahun_akademik_id
        GROUP BY pro.id
        "));

        foreach ($data['prodi'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        return response()->json($data);
    }
}
