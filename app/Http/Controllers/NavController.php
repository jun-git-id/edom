<?php

namespace App\Http\Controllers;

use App\Custom\CustomFunction;
use App\Major;
use App\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NavController extends Controller
{
    public static function getJurusan()
    {
        $data = DB::table('majors')->get();

        return response()->json($data);
    }

    public static function getProdi($jurusan_id)
    {
        $data['jurusan'] = DB::table('majors')->where('id',$jurusan_id)->first();
        $data['prodi'] = DB::table('study_programs')->where('jurusan_id', $jurusan_id)->get();

        return response()->json($data);
    }

    public static function getAngkatan($prodi_id)
    {
        $data['prodi'] = DB::table('study_programs')->where('id',$prodi_id)->first();
        $data['angkatan'] = DB::select(DB::raw("select angkatan from classes where prodi_id=$prodi_id group by angkatan"));

        return response()->json($data);
    }

    public static function getKelas($prodi_id, $angkatan)
    {
        $data['angkatan'] = $angkatan;
        $data['prodi'] = DB::table('study_programs')->where('id',$prodi_id)->first();
        $data['kelas'] = DB::select(DB::raw("
            SELECT
                kls.id, pro.nama_prodi as prodi, kls.huruf, kls.angkatan
            FROM
                study_programs pro, classes kls
            WHERE
                kls.prodi_id = pro.id
                and kls.prodi_id = $prodi_id
                and angkatan = $angkatan
        "));

        foreach($data['kelas'] as $dt){
            $dt->kelas = CustomFunction::generateKelas($dt->prodi, $dt->huruf, $dt->angkatan);
        }

        return response()->json($data);
    }
}
