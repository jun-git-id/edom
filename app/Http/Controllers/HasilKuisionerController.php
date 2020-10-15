<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HasilKuisionerController extends Controller
{
    public function mhsUI()
    {
        return view('admin.hasil-evaluasi.mahasiswa');
    }


    public function dosenUI()
    {
        return view('admin.hasil-evaluasi.dosen');
    }


    public function matkulUI()
    {
        return view('admin.hasil-evaluasi.matkul');
    }


    public function jurusanUI()
    {
        return view('admin.hasil-evaluasi.jurusan');
    }


}
