<?php

namespace App\Http\Controllers;

use App\Custom\CustomFunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilEvaluasiMahasiswa extends Controller
{
    public function kelasShow(Request $request, $kelas_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());

        $kelas = DB::select(DB::raw("SELECT
            kls.*, pro.nama_prodi
        FROM
            study_programs pro, classes kls
        WHERE
            kls.prodi_id = pro.id
            and kls.id = $kelas_id"))[0];

        $data['kelas'] = CustomFunction::generateKelas($kelas->nama_prodi, $kelas->huruf, $kelas->angkatan);

        $data['mhs'] = DB::select(DB::raw("
        SELECT
            mhs.id, mhs.nim, mhs.nama, avg(filld.nilai) as nilai
        FROM
            students mhs, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mahasiswa_id = mhs.id
            and mhs.kelas_id = $kelas_id
            and te.tahun_akademik_id = $tahun_akademik_id
        group by mhs.id
        "));

        foreach ($data['mhs'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }

        return response()->json($data);
    }
    public function mhsShow(Request $request, $mhs_id)
    {
        $tahun_akademik_id = $request->get('tahun_id',$tahun_akademik_id = CustomFunction::ambilLastTahunAc());

        $data['mhs'] = DB::select(DB::raw("
        SELECT
            mhs.*, pro.nama_prodi, kls.huruf, kls.angkatan
        FROM
            study_programs pro, classes kls, students mhs
        WHERE
            mhs.kelas_id = kls.id
            and kls.prodi_id = pro.id
            and mhs.id = $mhs_id
        "))[0];
        $data['mhs']->kelas = CustomFunction::generateKelas($data['mhs']->nama_prodi, $data['mhs']->huruf, $data['mhs']->angkatan);


        $data['kuisioner'] = DB::select(DB::raw("
        SELECT
            fill.id,
            dos.nama AS nama_dosen,
            mk.nama_mk AS matkul,
            AVG(filld.nilai) AS nilai
        FROM
            lecturers dos,
            courses mk,
            teaches te,
            fillings fill,
            filling_details filld
        WHERE
            filld.pengisian_id = fill.id
                AND fill.mengajar_id = te.id
                AND te.dosen_id = dos.id
                AND te.mata_kuliah_id = mk.id
                AND fill.mahasiswa_id = $mhs_id
                AND te.tahun_akademik_id = $tahun_akademik_id
        group by fill.id
        "));

        foreach ($data['kuisioner'] as $dt) {
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }

        return response()->json($data);
    }
    public function kuisionerShow($pengisian_id)
    {





        $info = DB::select(DB::raw("
        SELECT
            ye.tahun,
            ye.ganjil_genap,
            mhs.nim,
            mhs.nama AS nama_mhs,
            pro.nama_prodi,
            kls.huruf,
            kls.angkatan,
            dos.nomor_induk,
            dos.nama AS nama_dosen,
            mk.nama_mk,
            fill.komentar
        FROM
            courses mk,
            lecturers dos,
            academic_years ye,
            teaches te,
            study_programs pro,
            classes kls,
            students mhs,
            fillings fill
        WHERE
            fill.mahasiswa_id = mhs.id
                AND mhs.kelas_id = kls.id
                AND kls.prodi_id = pro.id
                AND fill.mengajar_id = te.id
                AND te.dosen_id = dos.id
                AND te.mata_kuliah_id = mk.id
                AND te.tahun_akademik_id = ye.id
                AND fill.id = $pengisian_id
        "))[0];

        $info->kelas = CustomFunction::generateKelas($info->nama_prodi, $info->huruf, $info->angkatan);
        $info->thn_ak = CustomFunction::generateTahun($info->tahun, $info->ganjil_genap);

        $data['info'] = $info;

        $data['kuisioner'] = DB::table('filling_details')->where('pengisian_id', $pengisian_id)->get();


        return response()->json($data);
    }
}
