<?php

namespace App\Http\Controllers;

use App\Custom\CustomFunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilEvaluasiGrafikTahunan extends Controller
{




    public function keseluruhan()
    {

        $data = DB::select(DB::raw("SELECT
            thn.id as tahun_id, thn.tahun, thn.ganjil_genap, avg(filld.nilai) as nilai
        FROM
            academic_years thn, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.tahun_akademik_id = thn.id
        GROUP BY thn.id
        "));


        foreach ($data as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }


        return response()->json($data);
    }




    public function jurusan($jurusan_id)
    {
        $data = DB::select(DB::raw("SELECT
            thn.id as tahun_id, thn.tahun, thn.ganjil_genap, avg(filld.nilai) as nilai
        FROM
            majors jur, study_programs pro, lecturers dos, academic_years thn, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = dos.id
            and dos.prodi_id = pro.id
            and pro.jurusan_id = jur.id
            and jur.id = $jurusan_id
            and te.tahun_akademik_id = thn.id
        GROUP BY thn.id
        "));


        foreach ($data as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }


        return response()->json($data);
    }




    public function prodi($prodi_id)
    {
        $data = DB::select(DB::raw("SELECT
            thn.id as tahun_id, thn.tahun, thn.ganjil_genap, avg(filld.nilai) as nilai
        FROM
            study_programs pro, lecturers dos, academic_years thn, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = dos.id
            and dos.prodi_id = pro.id
            and pro.id = $prodi_id
            and te.tahun_akademik_id = thn.id
        GROUP BY thn.id
        "));


        foreach ($data as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }


        return response()->json($data);
    }




    public function dosen($dosen_id)
    {
        $data = DB::select(DB::raw("SELECT
            thn.id as tahun_id, thn.tahun, thn.ganjil_genap, avg(filld.nilai) as nilai
        from
            academic_years thn, teaches te, fillings fill, filling_details filld
        where
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = $dosen_id
            and te.tahun_akademik_id = thn.id
        GROUP BY thn.id
        "));


        foreach ($data as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }


        return response()->json($data);
    }
}
