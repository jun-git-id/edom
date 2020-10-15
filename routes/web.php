<?php

use App\Custom\CustomFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



//TES
Route::get('/tes', 'TesController@ambilQuestion');

Route::get('tes-ui', 'TesController@ui');


Route::get('tes-admin/per-mhs', 'TesController@perMhs');
Route::get('tes-admin/ipk-dosen', 'TesController@ipkDosen');
Route::get('tes-admin/per-pertanyaan', 'TesController@perPert');
Route::get('tes-admin/rekap-ipk', 'TesController@rekapIpk');

// TES EVENT
Route::get('/epen', 'TesController@epen');
// TES EMAIL
Route::get('/tes-email', 'TesController@kirimEmail');

// TES PDF
Route::get('/tes-pdf', 'TesController@pdf');

//TES GRAFIK
Route::get('/grafik', 'TesController@grafik');
//grafik for pdf
Route::get('/grafik-pdf', 'TesController@grafikPdf');



//ADMIN
Route::group([
    'middleware' => [],
    'prefix' => 'admin'
], function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    Route::group(['prefix' => 'kuisioner'], function () {
        Route::resource('kompetensi', 'KompetensiController');
        Route::resource('pertanyaan', 'PertanyaanController');
    });

    /*
    SELECT
    mhs.*, pro.nama_prodi, kls.huruf, kls.angkatan
FROM
    study_programs pro, classes kls, students mhs
WHERE
    mhs.kelas_id = kls.id
    and kls.prodi_id = pro.id;
    */
    Route::group(['prefix' => 'lihat-data'], function () {
        Route::get('mahasiswa', function () {
            $mahasiswa = DB::table('students')
            ->join('classes','students.kelas_id','classes.id')
            ->join('study_programs','classes.prodi_id','study_programs.id')
            ->select('students.*', 'study_programs.nama_prodi','classes.huruf', 'classes.angkatan')->paginate(15);


            foreach($mahasiswa as $mhs){
                $mhs->kelas = CustomFunction::generateKelas($mhs->nama_prodi, $mhs->huruf, $mhs->angkatan);
            }

            return view('admin.lihat-data.mahasiswa', compact('mahasiswa'));
        });
        Route::get('dosen', function () {
            $dosen = DB::table('lecturers')
            ->join('study_programs','lecturers.prodi_id','study_programs.id')
            ->select('lecturers.*', 'study_programs.nama_prodi')
            ->paginate(15);

            return view('admin.lihat-data.dosen', compact('dosen'));
        });
        Route::get('matkul', function () {
            $matkul = DB::table('courses')
            ->join('study_programs','courses.prodi_id','study_programs.id')
            ->select('courses.*', 'study_programs.nama_prodi')->paginate(15);

            return view('admin.lihat-data.matkul', compact('matkul'));
        });
    });


    Route::group(['prefix' => 'hasil-evaluasi'], function () {

        Route::group(['prefix' => 'mhs'], function () {
            Route::get('/', function () {
                return view('admin.hasil-evaluasi.mahasiswa.index');
            });
            Route::get('jurusan/{jurusan_id}', function ($jurusan_id) {
                return view('admin.hasil-evaluasi.mahasiswa.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                return view('admin.hasil-evaluasi.mahasiswa.prodi', compact('prodi_id'));
            });
            Route::get('angkatan/{prodi_id}/{angkatan}', function ($prodi_id, $angkatan) {
                return view('admin.hasil-evaluasi.mahasiswa.angkatan', compact('prodi_id', 'angkatan'));
            });
            Route::get('kelas/{kelas_id}', function ($kelas_id) {
                return view('admin.hasil-evaluasi.mahasiswa.kelas', compact('kelas_id'));
            });
            Route::get('mhs/{mhs_id}', function ($mhs_id) {
                return view('admin.hasil-evaluasi.mahasiswa.mhs', compact('mhs_id'));
            });
            Route::get('kuisioner/{pengisian_id}', function ($pengisian_id) {
                return view('admin.hasil-evaluasi.mahasiswa.kuisioner', compact('pengisian_id'));
            });
        });
        Route::group(['prefix' => 'dosen'], function () {
            Route::get('/', function () {
                return view('admin.hasil-evaluasi.dosen.index');
            });
            Route::get('jurusan/{jurusan_id}', function ($jurusan_id) {
                return view('admin.hasil-evaluasi.dosen.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                return view('admin.hasil-evaluasi.dosen.prodi', compact('prodi_id'));
            });
            Route::get('prodi/{prodi_id}/pdf', 'PdfController@dosenProdi');

            Route::get('dosen/{dosen_id}', function ($dosen_id) {
                return view('admin.hasil-evaluasi.dosen.dosen', compact('dosen_id'));
            });
            Route::get('dosen/{dosen_id}/pdf', 'PdfController@dosenDosenKelas');

            Route::get('dosen-pert/{dosen_id}', function ($dosen_id) {
                return view('admin.hasil-evaluasi.dosen.dosen_pert', compact('dosen_id'));
            });
            Route::get('dosen-pert/{dosen_id}/pdf', 'PdfController@dosenDosenPert');

            Route::get('ajaran/{ajaran_id}', function ($ajaran_id) {
                return view('admin.hasil-evaluasi.dosen.ajaran', compact('ajaran_id'));
            });
            Route::get('ajaran/{ajaran_id}/pdf', 'PdfController@dosenAjaran');
        });
        Route::group(['prefix' => 'matkul'], function () {
            Route::get('/', function () {
                return view('admin.hasil-evaluasi.matkul.index');
            });
            Route::get('jurusan/{jurusan_id}', function ($jurusan_id) {
                return view('admin.hasil-evaluasi.matkul.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                return view('admin.hasil-evaluasi.matkul.prodi', compact('prodi_id'));
            });
            Route::get('matkul/{matkul_id}', function ($matkul_id) {
                return view('admin.hasil-evaluasi.matkul.matkul', compact('matkul_id'));
            });
        });
        Route::group(['prefix' => 'jurusan'], function () {
            Route::get('/', function () {
                return view('admin.hasil-evaluasi.jurusan.index');
            });
            Route::get('jurusan/{jurusan_id}', function ($jurusan_id) {
                return view('admin.hasil-evaluasi.jurusan.jurusan', compact('jurusan_id'));
            });
        });
    });
    Route::get('grafik-tahunan', 'GrafikTahunanController@GrafikTUI');
});



//MHS

Route::group([
    'middleware' => ['auth', 'mhs'],
    'prefix' => 'mhs'
], function () {
    Route::get('/', 'MahasiswaController@index');
});


Route::group([
    'middleware' => ['auth', 'dosen'],
    'prefix' => 'dosen'
], function () {
    Route::get('/', function () {
        return 'ini hal dosen';
    });
});




//TES TES
Route::get('/tes-2', 'TesController@tesDua');
Route::get('/tes-ui2', 'TesController@ui2');
Route::get('/tes-chartio', function () {
    return view('tes.chartio');
});



///fakfja j
Route::get('/tes-seed', 'TesController@seeding4');

Route::get('/tes-seed1', 'TesController@seedingPengisianSeeder1');
Route::get('/tes-seed2', 'TesController@seedingPengisianSeeder2');
Route::get('/tes-seed3', 'TesController@seedingPengisianSeeder3');
Route::get('/tes-seed4', 'TesController@seedingPengisianSeeder4');
Route::get('/tes-seed5', 'TesController@seedingPengisianSeeder5');
Route::get('/tes-seed6', 'TesController@seedingPengisianSeeder6');
