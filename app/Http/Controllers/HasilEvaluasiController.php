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
        $data = Lecturer::find(60);


        return new DosenPerKelasResource($data);
    }

    public function dosenSatuKelas($dosen_id, $kelas_id, $matkul_id)
    {
        //60,29,22
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
