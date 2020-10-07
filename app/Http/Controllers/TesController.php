<?php

namespace App\Http\Controllers;

use App\Competence;
use App\Events\TesEvent;
use App\Mail\TesMail;
use App\Question;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PDF;

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


    public function inputDosen()
    {
        $user_id = DB::table('users')->insertGetId([
            'username' =>  '1212a',
            'email' => 'kusnawansar1@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => '3'
        ]);
        DB::table('lecturers')->insert([
            'nidk' => '1212a',
            'nama' => 'kusnawansar',
            'pendidikan' => 'Sejarah',
            'bidang_ilmu' => 'Sejarah',
            'user_id' => $user_id,
            'prodi_id' => '3'
        ]);
    }

    public function epen()
    {

        $data = 'data';
        event(new TesEvent($data));
    }

    public function kirimEmail()
    {

        $data = 'data adfa faf adf';
        Mail::to('badruakfm@gmail.com')->send(new TesMail($data));
    }

    public function pdf()
    {
        $pdf = PDF::loadView('tes.pdf');
        return $pdf->stream('tadaf.pdf');
    }

    public function grafik()
    {
        return view('tes.grafik');
    }

    public function grafikPdf()
    {
        $pdf = PDF::loadView('tes.grafik-pdf');
        return $pdf->stream('grafik.pdf');

    }
}
