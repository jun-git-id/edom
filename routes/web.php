<?php

use App\AcademicYear;
use App\Course;
use App\Custom\CustomFunction;
use App\Lecturer;
use App\Student;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    return redirect('/login');
});

Auth::routes();

Route::put('ganti-password', function (Request $request) {
    $request->validate([
        'password' => 'required'
    ]);

    User::where('id', Auth::id())->update([
        'password' => Hash::make($request->password)
    ]);

    $role_id = Auth::user()->role_id;

    switch ($role_id) {
        case '1':
            return redirect('/admin');
            break;
        case '2':
            return redirect('/mhs');
            break;
        case '3':
            return redirect('/dosen');
            break;
        case '4':
            return redirect('/kajur');
    }
});

Route::get('/home', 'HomeController@index')->name('home');



//TES
Route::get('/tes', 'TesController@ambilQuestion');

Route::get('tes-ui', 'TesController@ui');
Route::get('tes3', function () {
    /* $kode_prodi = 'pro1';

    dd(substr($kode_prodi, 3)); */
    //return Carbon\Carbon::now()->toDateTimeString();
    //return date('Y-m-d H:i:s');
});
Route::get('tes-isi', function () {
    return view('tes-isi');
});


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

// TES sned post
Route::get('/tes-post', 'TesController@tesPost');

//TES GRAFIK
Route::get('/grafik', 'TesController@grafik');
Route::get('/grafik-line', function () {
    return view('admin.grafik-tahunan.tes');
});
//grafik for pdf
Route::get('/grafik-pdf', 'TesController@grafikPdf');

Route::get('/grafik-pdf2', 'PdfController@pdfGrafik');



//ADMIN############################################################################################################
Route::group([
    'middleware' => ['auth', 'admin'],
    'prefix' => 'admin'
], function () {
    Route::get('tes-hal', function () {
        return 'ini hal admin';
    });
    Route::get('/', function () {
        $jml_matkul = Course::all()->count();
        $jml_dosen = Lecturer::all()->count();
        $jml_mhs = Student::all()->count();
        return view('admin.dashboard', compact('jml_dosen', 'jml_matkul', 'jml_mhs'));
    })->name('hal-admin');
    Route::group(['prefix' => 'kuisioner'], function () {
        Route::resource('kompetensi', 'KompetensiController');
        Route::resource('pertanyaan', 'PertanyaanController');
    });
    Route::get('bagikan', 'DashboardController@bagikan');

    Route::group([
        'prefix' => 'kelola-data',
        'namespace' => 'KelolaData'
    ], function () {
        Route::resource('jurusan', 'JurusanController');
        Route::resource('prodi', 'ProdiController');
        Route::resource('tahun-akademik', 'TahunAkademikController');
    });

    Route::group([
        'prefix' => 'kelola-akun',
        'namespace' => 'KelolaData'
    ], function () {
        Route::resource('admin', 'AdminController');
        Route::resource('kajur', 'KajurController');
    });

    Route::group(['prefix' => 'lihat-data'], function () {
        Route::get('mahasiswa', function (Request $request) {
            $search = $request->get('s');

            /* $mahasiswa = DB::table('students')
                ->join('classes', 'students.kelas_id', 'classes.id')
                ->join('study_programs', 'classes.prodi_id', 'study_programs.id')
                ->select('students.*', 'study_programs.nama_prodi', 'classes.huruf', 'classes.angkatan')-> */

            $mahasiswa = Student::where('nama', 'like', "%" . $search . "%")->orWhere('nim', 'like', "%" . $search . "%")->paginate(15);

            $mahasiswa->appends($request->only('s'));


            foreach ($mahasiswa as $mhs) {
                $mhs->kelas = CustomFunction::generateKelas($mhs->class->studyProgram->nama_prodi, $mhs->class->huruf, $mhs->class->angkatan);
            }

            return view('admin.lihat-data.mahasiswa', compact('mahasiswa'));
        });
        Route::get('dosen', function (Request $request) {
            $search = $request->get('s');

            $dosen = Lecturer::where('nama', 'like', "%" . $search . "%")->orWhere('nomor_induk', 'like', "%" . $search . "%")->paginate(15);

            $dosen->appends($request->only('s'));

            return view('admin.lihat-data.dosen', compact('dosen'));
        });
        Route::get('matkul', function (Request $request) {
            $search = $request->get('s');

            $matkul = DB::table('courses')
                ->join('study_programs', 'courses.prodi_id', 'study_programs.id')
                ->select('courses.*', 'study_programs.nama_prodi')
                ->where('nama_mk', 'like', "%" . $search . "%")->paginate(15);

            $matkul->appends($request->only('s'));

            return view('admin.lihat-data.matkul', compact('matkul'));
        });
        Route::get('ajaran', function (Request $request) {
            $search = $request->get('s');

            $tahun_akademik_id = $request->get('tahun_id', $tahun_akademik_id = CustomFunction::ambilLastTahunAc());
            $tahun_akademik = AcademicYear::find($tahun_akademik_id);

            $ajaran = DB::table('teaches')
                ->join('lecturers', 'teaches.dosen_id', 'lecturers.id')
                ->join('classes', 'teaches.kelas_id', 'classes.id')
                ->join('study_programs', 'classes.prodi_id', 'study_programs.id')
                ->join('courses', 'teaches.mata_kuliah_id', 'courses.id')
                ->select('teaches.id', 'lecturers.nama', 'study_programs.nama_prodi', 'classes.huruf', 'classes.angkatan', 'courses.nama_mk')
                ->where('teaches.tahun_akademik_id', $tahun_akademik_id)
                ->where('lecturers.nama', 'like', "%" . $search . "%")
                ->paginate(15);

            foreach ($ajaran as $ajr) {
                $ajr->kelas = CustomFunction::generateKelas($ajr->nama_prodi, $ajr->huruf, $ajr->angkatan);
            }

            $ajaran->appends($request->only(['s', 'tahun_id']));

            return view('admin.lihat-data.ajaran', compact('ajaran', 'tahun_akademik'));
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
            Route::get('prodi/{prodi_id}/grafik', function ($prodi_id) {
                return view('admin.hasil-evaluasi.dosen.prodi-grafik', compact('prodi_id'));
            });
            Route::get('prodi/{prodi_id}/pdf', 'PdfController@dosenProdi');

            Route::get('dosen/{dosen_id}', function ($dosen_id) {
                return view('admin.hasil-evaluasi.dosen.dosen', compact('dosen_id'));
            });
            Route::get('dosen/{dosen_id}/grafik', function ($dosen_id) {
                return view('admin.hasil-evaluasi.dosen.dosen-grafik', compact('dosen_id'));
            });
            Route::get('dosen/{dosen_id}/pdf', 'PdfController@dosenDosenKelas');

            Route::get('dosen-pert/{dosen_id}', function ($dosen_id) {
                return view('admin.hasil-evaluasi.dosen.dosen_pert', compact('dosen_id'));
            });
            Route::get('dosen-pert/{dosen_id}/grafik', function ($dosen_id) {
                return view('admin.hasil-evaluasi.dosen.dosen_pert-grafik', compact('dosen_id'));
            });
            Route::get('dosen-pert/{dosen_id}/pdf', 'PdfController@dosenDosenPert');

            Route::get('ajaran/{ajaran_id}', function ($ajaran_id) {
                return view('admin.hasil-evaluasi.dosen.ajaran', compact('ajaran_id'));
            });
            Route::get('ajaran/{ajaran_id}/grafik', function ($ajaran_id) {
                return view('admin.hasil-evaluasi.dosen.ajaran-grafik', compact('ajaran_id'));
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
    Route::group(['prefix' => 'grafik-tahunan'], function () {
        Route::get('keseluruhan', function () {
            $url = url("/api/admin/grafik-tahunan/keseluruhan");
            return view('grafik.tahunan-admin', compact('url'));
        });
        Route::get('keseluruhan/{pdf}', 'GrafikTahunanController@keseluruhan');
        Route::group(['prefix' => 'jurusan'], function () {
            Route::get('/', function () {
                return view('admin.grafik-tahunan.jurusan.index');
            });
            Route::get('jurusan/{jurusan_id}', function ($jurusan_id) {
                $url = url("/api/admin/grafik-tahunan/jurusan/$jurusan_id");
                return view('grafik.tahunan-admin', compact('url'));
            });
            Route::get('jurusan/{jurusan_id}/{pdf}', 'GrafikTahunanController@jurusan');
        });
        Route::group(['prefix' => 'prodi'], function () {
            Route::get('/', function () {
                return view('admin.grafik-tahunan.prodi.index');
            });
            Route::get('jurusan/{jurusan_id}', function ($jurusan_id) {
                return view('admin.grafik-tahunan.prodi.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                $url = url("/api/admin/grafik-tahunan/prodi/$prodi_id");
                return view('grafik.tahunan-admin', compact('url'));
            });
            Route::get('prodi/{prodi_id}/{pdf}', 'GrafikTahunanController@prodi');
        });
        Route::group(['prefix' => 'dosen'], function () {
            Route::get('/', function () {
                return view('admin.grafik-tahunan.dosen.index');
            });
            Route::get('jurusan/{jurusan_id}', function ($jurusan_id) {
                return view('admin.grafik-tahunan.dosen.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                return view('admin.grafik-tahunan.dosen.prodi', compact('prodi_id'));
            });
            Route::get('dosen/{dosen_id}', function ($dosen_id) {
                $url = url("/api/admin/grafik-tahunan/dosen/$dosen_id");
                return view('grafik.tahunan-admin', compact('url'));
            });
            Route::get('dosen/{dosen_id}/{pdf}', 'GrafikTahunanController@dosen');
        });
    });
    Route::group(['prefix' => 'import-data'], function () {
        Route::get('matkul', function () {
            return view('admin.import-data.matkul');
        });
        Route::post('matkul', 'ImportDataController@matkulStoreData');

        Route::get('dosen', function () {
            return view('admin.import-data.dosen');
        });
        Route::post('dosen', 'ImportDataController@dosenStoreData');

        Route::get('mhs', function () {
            return view('admin.import-data.mhs');
        });
        Route::post('mhs', 'ImportDataController@mhsStoreData');

        Route::get('mhs-nonaktif', function () {
            return view('admin.import-data.mhs-nonaktif');
        });
        Route::post('mhs-nonaktif', 'ImportDataController@mhsNonaktifStoreData');

        Route::get('pengajaran', function () {
            return view('admin.import-data.pengajaran');
        });
        Route::post('pengajaran', 'ImportDataController@pengajaranStoreData');
    });
});




//KAJUR############################################################################################################

Route::group([
    'middleware' => ['auth', 'kajur'],
    'prefix' => 'kajur'
], function () {
    Route::get('tes-hal', function () {
        return 'ini hal kajur';
    });
    Route::get('/', function () {
        return view('kajur.dashboard');
    })->name('hal-kajur');
    Route::group(['prefix' => 'hasil-evaluasi'], function () {
        Route::group(['prefix' => 'dosen'], function () {
            Route::get('/', function () {
                $jurusan_id = Auth::user()->major_chief->jurusan_id;
                return view('kajur.hasil-evaluasi.dosen.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                return view('kajur.hasil-evaluasi.dosen.prodi', compact('prodi_id'));
            });
            Route::get('prodi/{prodi_id}/grafik', function ($prodi_id) {
                return view('kajur.hasil-evaluasi.dosen.prodi-grafik', compact('prodi_id'));
            });
            Route::get('prodi/{prodi_id}/pdf', 'PdfController@dosenProdi');

            Route::get('dosen/{dosen_id}', function ($dosen_id) {
                return view('kajur.hasil-evaluasi.dosen.dosen', compact('dosen_id'));
            });
            Route::get('dosen/{dosen_id}/grafik', function ($dosen_id) {
                return view('kajur.hasil-evaluasi.dosen.dosen-grafik', compact('dosen_id'));
            });
            Route::get('dosen/{dosen_id}/pdf', 'PdfController@dosenDosenKelas');

            Route::get('dosen-pert/{dosen_id}', function ($dosen_id) {
                return view('kajur.hasil-evaluasi.dosen.dosen_pert', compact('dosen_id'));
            });
            Route::get('dosen-pert/{dosen_id}/grafik', function ($dosen_id) {
                return view('kajur.hasil-evaluasi.dosen.dosen_pert-grafik', compact('dosen_id'));
            });
            Route::get('dosen-pert/{dosen_id}/pdf', 'PdfController@dosenDosenPert');

            Route::get('ajaran/{ajaran_id}', function ($ajaran_id) {
                return view('kajur.hasil-evaluasi.dosen.ajaran', compact('ajaran_id'));
            });
            Route::get('ajaran/{ajaran_id}/grafik', function ($ajaran_id) {
                return view('kajur.hasil-evaluasi.dosen.ajaran-grafik', compact('ajaran_id'));
            });
            Route::get('ajaran/{ajaran_id}/pdf', 'PdfController@dosenAjaran');
        });
        Route::group(['prefix' => 'matkul'], function () {
            Route::get('/', function () {
                $jurusan_id = Auth::user()->major_chief->jurusan_id;
                return view('kajur.hasil-evaluasi.matkul.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                return view('kajur.hasil-evaluasi.matkul.prodi', compact('prodi_id'));
            });
            Route::get('matkul/{matkul_id}', function ($matkul_id) {
                return view('kajur.hasil-evaluasi.matkul.matkul', compact('matkul_id'));
            });
        });
        Route::get('jurusan', function () {
            $jurusan_id = Auth::user()->major_chief->jurusan_id;
            return view('kajur.hasil-evaluasi.jurusan.jurusan', compact('jurusan_id'));
        });
    });
    Route::group(['prefix' => 'grafik-tahunan'], function () {
        Route::group(['prefix' => 'jurusan'], function () {
            Route::get('/', function () {
                $jurusan_id = Auth::user()->major_chief->jurusan_id;
                $url = url("/api/kajur/grafik-tahunan/jurusan/$jurusan_id");
                return view('grafik.tahunan-kajur', compact('url'));
            });
            Route::get('/{pdf}', 'GrafikTahunanController@jurusan');
        });
        Route::group(['prefix' => 'prodi'], function () {
            Route::get('/', function () {
                $jurusan_id = Auth::user()->major_chief->jurusan_id;
                return view('kajur.grafik-tahunan.prodi.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                $url = url("/api/kajur/grafik-tahunan/prodi/$prodi_id");
                return view('grafik.tahunan-kajur', compact('url'));
            });
            Route::get('prodi/{prodi_id}/{pdf}', 'GrafikTahunanController@prodi');
        });
        Route::group(['prefix' => 'dosen'], function () {
            Route::get('/', function () {
                $jurusan_id = Auth::user()->major_chief->jurusan_id;
                return view('kajur.grafik-tahunan.dosen.jurusan', compact('jurusan_id'));
            });
            Route::get('prodi/{prodi_id}', function ($prodi_id) {
                return view('kajur.grafik-tahunan.dosen.prodi', compact('prodi_id'));
            });
            Route::get('dosen/{dosen_id}', function ($dosen_id) {
                $url = url("/api/kajur/grafik-tahunan/dosen/$dosen_id");
                return view('grafik.tahunan-kajur', compact('url'));
            });
            Route::get('dosen/{dosen_id}/{pdf}', 'GrafikTahunanController@dosen');
        });
    });
});


//MHS############################################################################################################

Route::group([
    'middleware' => ['auth', 'mhs'],
    'prefix' => 'mhs'
], function () {
    Route::get('tes-hal', function () {
        return 'ini hal mhs';
    });
    Route::get('/', 'MahasiswaController@index')->name('hal-mhs');
    Route::get('/isi/{ajaran_id}', 'MahasiswaController@kuisioner');
    Route::post('/store', 'MahasiswaController@insertKuisioner');
});


//DOSEN############################################################################################################
Route::group([
    'middleware' => ['auth', 'dosen'],
    'prefix' => 'dosen'
], function () {
    Route::get('tes-hal', function () {
        return 'ini hal dosen';
    });
    Route::get('/', function () {
        return view('dosen.dashboard');
    })->name('hal-dosen');
    Route::group(['prefix' => 'hasil-evaluasi'], function () {
        Route::get('/', function () {
            $dosen_id = Auth::user()->lecturer->id;
            return view('dosen.hasil-evaluasi.dosen.dosen', compact('dosen_id'));
        });
        Route::get('/grafik', function () {
            $dosen_id = Auth::user()->lecturer->id;
            return view('dosen.hasil-evaluasi.dosen.dosen-grafik', compact('dosen_id'));
        });
        Route::get('/pdf', 'PdfController@dosenDosenKelas2');

        Route::get('/pert', function () {
            $dosen_id = Auth::user()->lecturer->id;
            return view('dosen.hasil-evaluasi.dosen.dosen_pert', compact('dosen_id'));
        });
        Route::get('/pert/grafik', function () {
            $dosen_id = Auth::user()->lecturer->id;
            return view('dosen.hasil-evaluasi.dosen.dosen_pert-grafik', compact('dosen_id'));
        });
        Route::get('/pert/pdf', 'PdfController@dosenDosenPert2');

        Route::get('/ajaran/{ajaran_id}', function ($ajaran_id) {
            return view('dosen.hasil-evaluasi.dosen.ajaran', compact('ajaran_id'));
        });
        Route::get('/ajaran/{ajaran_id}/grafik', function ($ajaran_id) {
            return view('dosen.hasil-evaluasi.dosen.ajaran-grafik', compact('ajaran_id'));
        });
        Route::get('/ajaran/{ajaran_id}/pdf', 'PdfController@dosenAjaran');
    });
    Route::group(['prefix' => 'grafik-tahunan'], function () {
        Route::get('/', function () {
            $dosen_id = Auth::user()->lecturer->id;
            $url = url("/api/dosen/grafik-tahunan/$dosen_id");
            return view('grafik.tahunan-dosen', compact('url'));
        });
        Route::get('/{pdf}', 'GrafikTahunanController@dosen2');
    });
});


/* 'middleware' => ['auth', 'mhs'],
'middleware' => ['auth', 'dosen'], */



//TES TES
Route::get('/tes-2', 'TesController@tesDua');
Route::get('/tes-ui2', 'TesController@ui2');
Route::get('/tes-chartio', function () {
    return view('tes.chartio');
});

Route::get('tes4', function () {
    return rand();
});



///fakfja j
Route::get('/tes-seed', 'TesController@seeding4');

Route::get('/tes-seed1', 'TesController@seedingPengisianSeeder1');
Route::get('/tes-seed2', 'TesController@seedingPengisianSeeder2');
Route::get('/tes-seed3', 'TesController@seedingPengisianSeeder3');
Route::get('/tes-seed4', 'TesController@seedingPengisianSeeder4');
Route::get('/tes-seed5', 'TesController@seedingPengisianSeeder5');
Route::get('/tes-seed6', 'TesController@seedingPengisianSeeder6');
