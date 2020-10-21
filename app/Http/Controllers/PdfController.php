<?php

namespace App\Http\Controllers;

use App\Custom\CustomFunction;
use App\Lecturer;
use App\MajorChief;
use App\Teach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDF;

class PdfController extends Controller
{
    ########DOSEN
    //prodi
    public function dosenProdi(Request $request, $prodi_id)
    {
        $tahun_akademik_id = $request->get('tahun_id', $tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['thn_ak'] = CustomFunction::getTak($tahun_akademik_id);


        $data['prodi'] = DB::table('study_programs')->where('id', $prodi_id)->first()->nama_prodi;
        $data['dosen'] = DB::select(DB::raw("
        SELECT
            dos.id, dos.nomor_induk, dos.nama, count(distinct te.kelas_id) as jml_kelas, AVG(filld.nilai) AS nilai
        FROM
            lecturers dos, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.dosen_id = dos.id
            and dos.prodi_id = $prodi_id
            and te.tahun_akademik_id = $tahun_akademik_id
        GROUP BY dos.id
        "));


        foreach ($data['dosen'] as $dt) {
            $dt->nilaiPersen = CustomFunction::toPersen($dt->nilai);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        $data['ket'] = CustomFunction::getNilaiAkhir($data['dosen']);

        //return view('admin.hasil-evaluasi.dosen.prodi-pdf', $data);

        if($request->get('grafik', 'no') == 'yes'){
            //dd($data['dosen']);
            $data['url'] = CustomFunction::pdfGrafik($data['dosen'], 'nama', 'Prodi ' . $data['prodi'] . ' ' . $data['thn_ak']);
            $data['title'] = 'Hasil Evaluasi Dosen';
            $data['info1'] = [
                [
                    'name' => 'Prodi',
                    'value' => $data['prodi']
                ],
                [
                    'name' => 'Tahun Akademik',
                    'value' => $data['thn_ak']
                ],
            ];
            $data['info2'] = [
                [
                    'name' => 'Rata - rata',
                    'value' => $data['ket']['rata2']
                ],
                [
                    'name' => 'Keterangan',
                    'value' => $data['ket']['kesimpulan']
                ],
            ];
            $pdf = PDF::loadView('grafik.pdf2', $data);
        }else{
            $pdf = PDF::loadView('admin.hasil-evaluasi.dosen.prodi-pdf', $data);
        }

        return $pdf->stream('Prodi ' . $data['prodi'] . '.pdf');

    }
    //dosen-kelas
    public function dosenDosenKelas(Request $request, $dosen_id)
    {
        $tahun_akademik_id = $request->get('tahun_id', $tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['thn_ak'] = CustomFunction::getTak($tahun_akademik_id);

        $data['dosen'] = Lecturer::find($dosen_id);
        $data['kajur'] = MajorChief::where('jurusan_id', $data['dosen']->study_program->jurusan_id)->first();
        $data['ajaran'] = DB::select(DB::raw("
        select
            te.id, pro.nama_prodi, kls.huruf, kls.angkatan, mk.nama_mk, count(distinct fill.mahasiswa_id) as jml_responden, avg(filld.nilai) as nilai
        from
            courses mk, study_programs pro, classes kls, teaches te, fillings fill, filling_details filld
        where
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.kelas_id = kls.id
            and kls.prodi_id = pro.id
            and te.mata_kuliah_id = mk.id
            and te.dosen_id = $dosen_id
            and te.tahun_akademik_id = $tahun_akademik_id
        group by te.id
        "));


        foreach ($data['ajaran'] as $dt) {
            $dt->nilaiPersen = CustomFunction::toPersen($dt->nilai);
            $dt->kelas = CustomFunction::generateKelas($dt->nama_prodi, $dt->huruf, $dt->angkatan);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }

        $data['ket'] = CustomFunction::getNilaiAkhir($data['ajaran']);



        //return view('admin.hasil-evaluasi.dosen.dosen-pdf', $data);
        //return response()->json($data);

        if($request->get('grafik', 'no') == 'yes'){
            $data['url'] = CustomFunction::pdfGrafik($data['ajaran'], 'kelas', 'Dosen ' . $data['dosen']->nama . ' ' . $data['thn_ak']);
            $data['title'] = 'Hasil Evaluasi Dosen';
            $data['info1'] = [
                [
                    'name' => 'Nomor Induk',
                    'value' => $data['dosen']->nomor_induk
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $data['dosen']->nama
                ],
                [
                    'name' => 'Tahun Akademik',
                    'value' => $data['thn_ak']
                ],
            ];
            $data['info2'] = [
                [
                    'name' => 'Rata - rata',
                    'value' => $data['ket']['rata2']
                ],
                [
                    'name' => 'Keterangan',
                    'value' => $data['ket']['kesimpulan']
                ],
            ];
            $pdf = PDF::loadView('grafik.pdf2', $data);
        }else{
            $pdf = PDF::loadView('admin.hasil-evaluasi.dosen.dosen-pdf', $data);
        }


        return $pdf->stream('Dosen ' . $data['dosen']->nama . '.pdf');



    }
    //dosen-pert
    public function dosenDosenPert(Request $request, $dosen_id)
    {
        $tahun_akademik_id = $request->get('tahun_id', $tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['thn_ak'] = CustomFunction::getTak($tahun_akademik_id);

        $data['dosen'] = DB::table('lecturers')->where('id', $dosen_id)->first();

        $kompetensi = DB::select(DB::raw("
        SELECT
            filld.kompetensi
        FROM
            teaches te,
            fillings fill,
            filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            AND fill.mengajar_id = te.id
            and te.tahun_akademik_id = $tahun_akademik_id
            and te.dosen_id = $dosen_id
        GROUP BY filld.kompetensi
        "));

        $data['pertanyaan'] = [];
        foreach ($kompetensi as $kmp) {
            $pertanyaan = DB::select(DB::raw("
            SELECT
                filld.pertanyaan, filld.kompetensi, avg(filld.nilai) as nilai
            FROM
                teaches te, fillings fill, filling_details filld
            WHERE
                filld.pengisian_id = fill.id
                and fill.mengajar_id = te.id
                and te.tahun_akademik_id = $tahun_akademik_id
                and te.dosen_id = $dosen_id
                and filld.kompetensi = '$kmp->kompetensi'
            GROUP BY filld.pertanyaan
            "));

            foreach ($pertanyaan as $prt) {
                $data['pertanyaan'][] = $prt;
            }
        }

        foreach ($data['pertanyaan'] as $dt) {
            $dt->nilaiPersen = CustomFunction::toPersen($dt->nilai);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }

        $data['ket'] = CustomFunction::getNilaiAkhir($data['pertanyaan']);
        //return response()->json($data);
        //return view('admin.hasil-evaluasi.dosen.dosen_pert-pdf', $data);


        if($request->get('grafik', 'no') == 'yes'){
            $data['url'] = CustomFunction::pdfGrafik($data['pertanyaan'], 'pertanyaan', 'Dosen ' . $data['dosen']->nama . ' ' . $data['thn_ak']);
            $data['title'] = 'Hasil Evaluasi Dosen';
            $data['info1'] = [
                [
                    'name' => 'Nomor Induk',
                    'value' => $data['dosen']->nomor_induk
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $data['dosen']->nama
                ],
                [
                    'name' => 'Tahun Akademik',
                    'value' => $data['thn_ak']
                ],
            ];
            $data['info2'] = [
                [
                    'name' => 'Rata - rata',
                    'value' => $data['ket']['rata2']
                ],
                [
                    'name' => 'Keterangan',
                    'value' => $data['ket']['kesimpulan']
                ],
            ];
            $pdf = PDF::loadView('grafik.pdf2', $data);
        }else{
            $pdf = PDF::loadView('admin.hasil-evaluasi.dosen.dosen_pert-pdf', $data);
        }

        return $pdf->stream('Dosen ' . $data['dosen']->nama . '.pdf');
    }
    //ajaran
    public function dosenAjaran(Request $request, $ajaran_id)
    {
        $teach = Teach::find($ajaran_id);

        $data['info'] = [
            'nomor_induk' => $teach->lecturer->nomor_induk,
            'nama_dosen' => $teach->lecturer->nama,

            'matkul' => $teach->course->nama_mk,
            'kelas' => CustomFunction::generateKelas($teach->class->studyProgram->nama_prodi, $teach->class->huruf, $teach->class->angkatan),
            'jml_responden' => DB::select(DB::raw("SELECT count(mahasiswa_id) as jml FROM fillings WHERE mengajar_id = $ajaran_id"))[0]->jml,

            'thn_ak' => CustomFunction::generateTahun($teach->academicYear->tahun, $teach->academicYear->ganjil_genap)
        ];

        $kompetensi = DB::select(DB::raw("
            select
                filld.kompetensi
            from
                fillings fill, filling_details filld
            where
                filld.pengisian_id = fill.id
                and fill.mengajar_id = $ajaran_id
            group by filld.kompetensi
        "));

        $data['pertanyaan'] = [];
        foreach ($kompetensi as $kmp) {
            $pertanyaan = DB::select(DB::raw("
            select
                filld.pertanyaan, filld.kompetensi, avg(filld.nilai) as nilai
            from
                fillings fill, filling_details filld
            where
                filld.pengisian_id = fill.id
                and fill.mengajar_id = $ajaran_id
                and filld.kompetensi='$kmp->kompetensi'
            group by filld.pertanyaan;
            "));

            foreach ($pertanyaan as $prt) {
                $data['pertanyaan'][] = $prt;
            }
        }

        foreach ($data['pertanyaan'] as $dt) {
            $dt->nilaiPersen = CustomFunction::toPersen($dt->nilai);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }


        $data['ket'] = CustomFunction::getNilaiAkhir($data['pertanyaan']);

        //return response()->json($data);
        //return view('admin.hasil-evaluasi.dosen.ajaran-pdf', $data);

        if($request->get('grafik', 'no') == 'yes'){
            $data['url'] = CustomFunction::pdfGrafik($data['pertanyaan'], 'pertanyaan', 'Dosen ' . $data['info']['nama_dosen'] . ' pada Kelas ' . $data['info']['kelas']. ' ' . $data['info']['thn_ak']);
            $data['title'] = 'Hasil Evaluasi Dosen';
            $data['info1'] = [
                [
                    'name' => 'Nomor Induk',
                    'value' => $data['info']['nomor_induk']
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $data['info']['nama_dosen']
                ],
                [
                    'name' => 'Mata Kuliah',
                    'value' => $data['info']['matkul']
                ],
                [
                    'name' => 'Kelas',
                    'value' => $data['info']['kelas']
                ],
                [
                    'name' => 'Jumlah Responden',
                    'value' => $data['info']['jml_responden']
                ],
                [
                    'name' => 'Tahun Ajaran',
                    'value' => $data['info']['thn_ak']
                ],
            ];
            $data['info2'] = [
                [
                    'name' => 'Rata - rata',
                    'value' => $data['ket']['rata2']
                ],
                [
                    'name' => 'Keterangan',
                    'value' => $data['ket']['kesimpulan']
                ],
            ];
            $pdf = PDF::loadView('grafik.pdf2', $data);
        }else{
            $pdf = PDF::loadView('admin.hasil-evaluasi.dosen.ajaran-pdf', $data);
        }

        return $pdf->stream('Dosen '.$data['info']['nama_dosen'].' ' . $data['info']['kelas'].'.pdf');

    }
    ########JURUSAN





    //dosen-kelas
    public function dosenDosenKelas2(Request $request)
    {
        $dosen_id = Auth::user()->lecturer->id;
        $tahun_akademik_id = $request->get('tahun_id', $tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['thn_ak'] = CustomFunction::getTak($tahun_akademik_id);

        $data['dosen'] = DB::table('lecturers')->where('id', $dosen_id)->first();
        $data['ajaran'] = DB::select(DB::raw("
        select
            te.id, pro.nama_prodi, kls.huruf, kls.angkatan, mk.nama_mk, count(distinct fill.mahasiswa_id) as jml_responden, avg(filld.nilai) as nilai
        from
            courses mk, study_programs pro, classes kls, teaches te, fillings fill, filling_details filld
        where
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.kelas_id = kls.id
            and kls.prodi_id = pro.id
            and te.mata_kuliah_id = mk.id
            and te.dosen_id = $dosen_id
            and te.tahun_akademik_id = $tahun_akademik_id
        group by te.id
        "));


        foreach ($data['ajaran'] as $dt) {
            $dt->nilaiPersen = CustomFunction::toPersen($dt->nilai);
            $dt->kelas = CustomFunction::generateKelas($dt->nama_prodi, $dt->huruf, $dt->angkatan);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }

        $data['ket'] = CustomFunction::getNilaiAkhir($data['ajaran']);


        //return view('admin.hasil-evaluasi.dosen.dosen-pdf', $data);
        //return response()->json($data);

        if($request->get('grafik', 'no') == 'yes'){
            $data['url'] = CustomFunction::pdfGrafik($data['ajaran'], 'kelas', 'Dosen ' . $data['dosen']->nama . ' ' . $data['thn_ak']);
            $data['title'] = 'Hasil Evaluasi Dosen';
            $data['info1'] = [
                [
                    'name' => 'Nomor Induk',
                    'value' => $data['dosen']->nomor_induk
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $data['dosen']->nama
                ],
                [
                    'name' => 'Tahun Akademik',
                    'value' => $data['thn_ak']
                ],
            ];
            $data['info2'] = [
                [
                    'name' => 'Rata - rata',
                    'value' => $data['ket']['rata2']
                ],
                [
                    'name' => 'Keterangan',
                    'value' => $data['ket']['kesimpulan']
                ],
            ];
            $pdf = PDF::loadView('grafik.pdf2', $data);
        }else{
            $pdf = PDF::loadView('admin.hasil-evaluasi.dosen.dosen-pdf', $data);
        }


        return $pdf->stream('Dosen ' . $data['dosen']->nama . '.pdf');



    }//dosen-pert
    public function dosenDosenPert2(Request $request)
    {
        $dosen_id = Auth::user()->lecturer->id;
        $tahun_akademik_id = $request->get('tahun_id', $tahun_akademik_id = CustomFunction::ambilLastTahunAc());
        $data['thn_ak'] = CustomFunction::getTak($tahun_akademik_id);

        $data['dosen'] = DB::table('lecturers')->where('id', $dosen_id)->first();

        $kompetensi = DB::select(DB::raw("
        SELECT
            filld.kompetensi
        FROM
            teaches te,
            fillings fill,
            filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            AND fill.mengajar_id = te.id
            and te.tahun_akademik_id = $tahun_akademik_id
            and te.dosen_id = $dosen_id
        GROUP BY filld.kompetensi
        "));

        $data['pertanyaan'] = [];
        foreach ($kompetensi as $kmp) {
            $pertanyaan = DB::select(DB::raw("
            SELECT
                filld.pertanyaan, filld.kompetensi, avg(filld.nilai) as nilai
            FROM
                teaches te, fillings fill, filling_details filld
            WHERE
                filld.pengisian_id = fill.id
                and fill.mengajar_id = te.id
                and te.tahun_akademik_id = $tahun_akademik_id
                and te.dosen_id = $dosen_id
                and filld.kompetensi = '$kmp->kompetensi'
            GROUP BY filld.pertanyaan
            "));

            foreach ($pertanyaan as $prt) {
                $data['pertanyaan'][] = $prt;
            }
        }

        foreach ($data['pertanyaan'] as $dt) {
            $dt->nilaiPersen = CustomFunction::toPersen($dt->nilai);
            $dt->keterangan = CustomFunction::ambilKesimpulan($dt->nilai);
        }

        $data['ket'] = CustomFunction::getNilaiAkhir($data['pertanyaan']);
        //return response()->json($data);
        //return view('admin.hasil-evaluasi.dosen.dosen_pert-pdf', $data);


        if($request->get('grafik', 'no') == 'yes'){
            $data['url'] = CustomFunction::pdfGrafik($data['pertanyaan'], 'pertanyaan', 'Dosen ' . $data['dosen']->nama . ' ' . $data['thn_ak']);
            $data['title'] = 'Hasil Evaluasi Dosen';
            $data['info1'] = [
                [
                    'name' => 'Nomor Induk',
                    'value' => $data['dosen']->nomor_induk
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $data['dosen']->nama
                ],
                [
                    'name' => 'Tahun Akademik',
                    'value' => $data['thn_ak']
                ],
            ];
            $data['info2'] = [
                [
                    'name' => 'Rata - rata',
                    'value' => $data['ket']['rata2']
                ],
                [
                    'name' => 'Keterangan',
                    'value' => $data['ket']['kesimpulan']
                ],
            ];
            $pdf = PDF::loadView('grafik.pdf2', $data);
        }else{
            $pdf = PDF::loadView('admin.hasil-evaluasi.dosen.dosen_pert-pdf', $data);
        }

        return $pdf->stream('Dosen ' . $data['dosen']->nama . '.pdf');
    }




}
