<?php

namespace App\Http\Controllers;

use App\Custom\CustomFunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class GrafikTahunanController extends Controller
{
    public function keseluruhan($pdf = null)
    {
        $nilai = DB::select(DB::raw("SELECT
            thn.id as tahun_id, thn.tahun, thn.ganjil_genap, avg(filld.nilai) as nilai
        FROM
            academic_years thn, teaches te, fillings fill, filling_details filld
        WHERE
            filld.pengisian_id = fill.id
            and fill.mengajar_id = te.id
            and te.tahun_akademik_id = thn.id
        GROUP BY thn.id
        "));


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [],
            'pdf_link' => url("/admin/grafik-tahunan/keseluruhan/pdf"),
            'title' => 'Grafik Kinerja Dosen Politeknik Negeri Cilacap',
            'info1' => [
                [
                    'name' => 'Kampus',
                    'value' => 'Politeknik Negeri Cilacap',
                ]
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Politeknik Negeri Cilacap");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Grafik Evaluasi Dosen.pdf");
        }

        return response()->json($data);
    }

    public function jurusan(Request $request, $jurusan_id, $pdf = null)
    {
        $jurusan = DB::table('majors')->where('id', $jurusan_id)->first()->nama_jurusan;
        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [
                'Jurusan'
            ],
            'pdf_link' => url("/admin/grafik-tahunan/jurusan/jurusan/$jurusan_id/pdf"),
            'title' => 'Grafik Tahunan Jurusan',
            'info1' => [
                [
                    'name' => 'Jurusan',
                    'value' => $jurusan,
                ]
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Jurusan $jurusan");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Grafik Tahunan Jurusan $jurusan .pdf");
        }

        return response()->json($data);
    }

    public function prodi(Request $request, $prodi_id, $pdf = null)
    {
        $prodi = DB::table('study_programs')->where('id', $prodi_id)->first()->nama_prodi;


        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [
                'Jurusan',
                'Prodi'
            ],
            'pdf_link' => url("/admin/grafik-tahunan/prodi/prodi/$prodi_id/pdf"),
            'title' => 'Grafik Tahunan Prodi',
            'info1' => [
                [
                    'name' => 'Nama Prodi',
                    'value' => $prodi,
                ]
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Prodi $prodi");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Grafik Tahunan Prodi $prodi .pdf");
        }

        return response()->json($data);
    }
    public function dosen(Request $request, $dosen_id, $pdf = null)
    {
        $dosen = DB::table('lecturers')->where('id', $dosen_id)->first();

        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [
                'Jurusan',
                'Prodi',
                'Dosen',
            ],
            'pdf_link' => url("/admin/grafik-tahunan/dosen/dosen/$dosen_id/pdf"),
            'title' => 'Grafik Tahunan Dosen',
            'info1' => [
                [
                    'name' => 'Nomor Induk',
                    'value' => $dosen->nomor_induk,
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $dosen->nama,
                ],
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Dosen $dosen->nama");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Dosen $dosen->nama .pdf");
        }

        return response()->json($data);
    }

    ///########KAJUR
    public function jurusanKajur(Request $request, $jurusan_id, $pdf = null)
    {
        $jurusan = DB::table('majors')->where('id', $jurusan_id)->first()->nama_jurusan;
        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [
                'Jurusan'
            ],
            'pdf_link' => url("/kajur/grafik-tahunan/jurusan/pdf"),
            'title' => 'Grafik Tahunan Jurusan',
            'info1' => [
                [
                    'name' => 'Jurusan',
                    'value' => $jurusan,
                ]
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Jurusan $jurusan");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Grafik Tahunan Jurusan $jurusan .pdf");
        }

        return response()->json($data);
    }

    public function prodiKajur(Request $request, $prodi_id, $pdf = null)
    {
        $prodi = DB::table('study_programs')->where('id', $prodi_id)->first()->nama_prodi;


        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [
                'Jurusan',
                'Prodi'
            ],
            'pdf_link' => url("/admin/grafik-tahunan/prodi/prodi/$prodi_id/pdf"),
            'title' => 'Grafik Tahunan Prodi',
            'info1' => [
                [
                    'name' => 'Nama Prodi',
                    'value' => $prodi,
                ]
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Prodi $prodi");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Grafik Tahunan Prodi $prodi .pdf");
        }

        return response()->json($data);
    }
    public function dosenKajur(Request $request, $dosen_id, $pdf = null)
    {
        $dosen = DB::table('lecturers')->where('id', $dosen_id)->first();

        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [
                'Jurusan',
                'Prodi',
                'Dosen',
            ],
            'pdf_link' => url("/kajur/grafik-tahunan/dosen/dosen/$dosen_id/pdf"),
            'title' => 'Grafik Tahunan Dosen',
            'info1' => [
                [
                    'name' => 'Nomor Induk',
                    'value' => $dosen->nomor_induk,
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $dosen->nama,
                ],
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Dosen $dosen->nama");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Dosen $dosen->nama .pdf");
        }

        return response()->json($data);
    }

    ///DOSEN
    public function dosenDosen(Request $request, $dosen_id, $pdf = null)
    {
        $dosen = DB::table('lecturers')->where('id', $dosen_id)->first();

        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'pdf_link' => url("/dosen/grafik-tahunan/pdf"),
            'title' => 'Grafik Tahunan Dosen',
            'info1' => [
                [
                    'name' => 'Nomor Induk',
                    'value' => $dosen->nomor_induk,
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $dosen->nama,
                ],
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Dosen $dosen->nama");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Dosen $dosen->nama .pdf");
        }

        return response()->json($data);
    }
    public function dosen2(Request $request, $pdf = null)
    {
        $dosen_id = Auth::user()->lecturer->id;
        $dosen = DB::table('lecturers')->where('id', $dosen_id)->first();

        $nilai = DB::select(DB::raw("SELECT
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


        foreach ($nilai as $dt) {
            $dt->tahunFinal = CustomFunction::generateTahun($dt->tahun, $dt->ganjil_genap);
        }

        $data = [
            'nav' => [
                'Jurusan',
                'Prodi',
                'Dosen',
            ],
            'pdf_link' => url("/admin/grafik-tahunan/dosen/dosen/$dosen_id/pdf"),
            'title' => 'Grafik Tahunan Dosen',
            'info1' => [
                [
                    'name' => 'Nomor Induk',
                    'value' => $dosen->nomor_induk,
                ],
                [
                    'name' => 'Nama Dosen',
                    'value' => $dosen->nama,
                ],
            ],
            'nilai' => $nilai
        ];


        if($pdf == 'pdf'){

            $data['url'] = CustomFunction::pdfGrafikLine($nilai, "Dosen $dosen->nama");

            $pdf = PDF::loadView('grafik.pdf2', $data);
            return $pdf->stream("Dosen $dosen->nama .pdf");
        }

        return response()->json($data);
    }


}
