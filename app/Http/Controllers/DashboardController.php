<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Share;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function bagikan()
    {
        $tahun_akademik = AcademicYear::all()->last();

        $pembagian = Share::where('tahun_akademik_id', $tahun_akademik->id)->first();

        if($pembagian){
            return redirect('/admin')->with('kesalahan','Kuisioner sudah dibagikan sebelumnya');
        }

        Share::create([
            'tanggal' => date('Y-m-d H:i:s'),
            'tahun_akademik_id' => $tahun_akademik->id
        ]);

        return redirect('/admin')->with('status','Kuisioner berhasil dibagikan. Mahasiswa kini dapat mengisi kuisioner sesuai dengan tahun akademik terkini.');
    }
}
