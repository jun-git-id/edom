<?php

namespace App\Http\Controllers;

use App\Filling;
use App\Http\Resources\DosenPerKelasResource;
use App\Http\Resources\DosenSatuKelasResource;
use App\Http\Resources\PerDosenResource;
use App\Http\Resources\PerMahasiswa;
use App\Http\Resources\PerMahasiswaResource;
use App\Lecturer;
use App\Teach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilEvaluasiController extends Controller
{
    public function perMahasiswa()
    {
        $data = Filling::all();

        return PerMahasiswaResource::collection($data);
    }

    public function dosenPerKelas()
    {
        /* $data = Lecturer::find(60);


        return new DosenPerKelasResource($data); */

        $id = 60;

        $data = DB::select(DB::raw("select te.id, concat(cls.prodi_id, cls.huruf, cls.angkatan) as kelas, mk.nama_mk, count(distinct fill.mahasiswa_id) as jml_responden, avg(filld.nilai) as nilai
        from teaches te, classes cls, courses mk, fillings fill, filling_details filld
        where te.kelas_id = cls.id
        and te.mata_kuliah_id = mk.id
        and fill.mengajar_id = te.id
        and filld.pengisian_id = fill.id
        and dosen_id=$id
        group by id"));

        return response()->json($data);
    }

    public function dosenSatuKelas($dosen_id, $kelas_id, $matkul_id)
    {
        //60/29/22
        $data = Teach::where([
            'dosen_id' => $dosen_id,
            'kelas_id' => $kelas_id,
            'mata_kuliah_id' => $matkul_id
        ])->first();

        return new DosenSatuKelasResource($data);
    }

    public function perDosen()
    {
        /* $data = DB::table('lecturers')
        ->join('teaches','lecturers.id','teaches.dosen_id')
        ->join('classes','teaches.kelas_id','classes.id')
        ->select('lecturers.*','teaches.*','classes.*')
        ->where('lecturers.prodi_id',3)
        ->get(); */

        $data = Lecturer::whereIn('id',[60,61,62,63,64])->get();



        return PerDosenResource::collection($data);
        //return response()->json($data);
    }
}
