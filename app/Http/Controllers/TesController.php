<?php

namespace App\Http\Controllers;

use App\Competence;
use App\Question;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TesController extends Controller
{
    public function index()
    {
        /* $kompentensi = Competence::all();

        return response()->json($kompentensi[0]); */

        echo Auth::user()->username;
    }

    public function ambilQuestion()
    {
        $data = Question::all();

        return response()->json($data);
    }

    public function ui()
    {
        return view('admin.tes');
    }

    public function perMhs()
    {
        return view('admin.hasil-kuisioner.per-mhs');
    }

    public function ipkDosen()
    {
        return view('admin.hasil-kuisioner.ipk-dosen');
    }

    public function perPert()
    {
        return view('admin.hasil-kuisioner.per-pertanyaan');
    }

    public function rekapIpk()
    {
        return view('admin.hasil-kuisioner.rekap-ipk');
    }
}
