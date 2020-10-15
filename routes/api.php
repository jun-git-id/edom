<?php

//api/admin/hasil-evaluasi/
/* Route::group([
    'prefix' => 'admin/hasil-evaluasi'
], function ($router) {
    Route::get('/per-mahasiswa', 'HasilEvaluasiController@perMahasiswa');
    Route::get('/dosen-per-kelas', 'HasilEvaluasiController@dosenPerKelas');
    Route::get('/dosen-kelas/{dosen_id}/{kelas_id}/{matkul_id}', 'HasilEvaluasiController@dosenSatuKelas');
    Route::get('/per-dosen', 'HasilEvaluasiController@perDosen');
}); */

use Illuminate\Support\Facades\DB;

Route::group(['prefix' => 'mhs'], function ($router) {
    Route::get('/daftar-dosen', 'MahasiswaController@daftarDosen');
    Route::get('/isi-kuisioner/{mengajar_id}', 'MahasiswaController@kuisioner');
    Route::post('/insert-kuisioner', 'MahasiswaController@insertKuisioner');
});

Route::get('/cek-mhs/{nim}/{thn_akd}', 'MahasiswaController@statusMhs');


//TES
Route::get('/per-dosen', 'HasilEvaluasiController@perDosen');
Route::get('/dosen-per-kelas', 'HasilEvaluasiController@dosenPerKelas');
Route::get('/dosen-kelas/{dosen_id}/{kelas_id}/{matkul_id}', 'HasilEvaluasiController@dosenSatuKelas');



//TAHUN AKADEMIK
Route::get('get-thn_ak', function () {
    return response()->json(DB::table('academic_years')->get());

});

//NAVIGASI
Route::get('ambil-jurusan', 'NavController@getJurusan');
Route::get('ambil-prodi/{jurusan_id}', 'NavController@getProdi');
Route::get('ambil-angkatan/{prodi_id}', 'NavController@getAngkatan');
Route::get('ambil-kelas/{prodi_id}/{angkatan}', 'NavController@getKelas');

//##HASIL EVALUASI
Route::group(['prefix' => 'admin/hasil-evaluasi'], function () {
    //Mahasiswa
    Route::group(['prefix' => 'mhs'], function () {
        //Route::get('jurusan', 'HasilEvaluasiMahasiswa@jurusan');
        //Route::get('jurusan/{jurusan_id}', 'HasilEvaluasiMahasiswa@jurusanShow'); //prodi rata2
        //Route::get('prodi/{prodi_id}', 'HasilEvaluasiMahasiswa@prodiShow'); //kelas rata2
        Route::get('kelas/{kelas_id}', 'HasilEvaluasiMahasiswa@kelasShow'); //mhs rata2
        Route::get('mhs/{mhs_id}', 'HasilEvaluasiMahasiswa@mhsShow'); //mhs kuisioner rata2
        Route::get('kuisioner/{pengisian_id}', 'HasilEvaluasiMahasiswa@kuisionerShow'); //mhs kusioner pertanyaan
    });
    //Dosen
    Route::group(['prefix' => 'dosen'], function () {
        //Route::get('jurusan', 'HasilEvaluasiDosen@jurusan'); //jurusan rata2
        //Route::get('jurusan/{jurusan_id}', 'HasilEvaluasiDosen@jurusanShow'); //prodi rata2
        Route::get('prodi/{prodi_id}', 'HasilEvaluasiDosen@prodiShow'); //prodi dosen - dosen rata2
        Route::get('dosen/{dosen_id}', 'HasilEvaluasiDosen@dosenShow'); //dosen kelas
        Route::get('dosen_pert/{dosen_id}', 'HasilEvaluasiDosen@dosenPertShow'); //dosen per pert
        Route::get('ajaran/{ajaran_id}', 'HasilEvaluasiDosen@ajaranShow'); //dosen salah satu kelas
        Route::get('ajaran-komentar/{ajaran_id}', 'HasilEvaluasiDosen@ajaranKomentar');
    });
    //Matkul
    Route::group(['prefix' => 'matkul'], function () {
        //Route::get('jurusan', 'HasilEvaluasiMatkul@jurusan'); //jurusan
        //Route::get('jurusan/{jurusan_id]', 'HasilEvaluasiMatkul@jurusanShow'); //prodi
        Route::get('prodi/{prodi_id}', 'HasilEvaluasiMatkul@prodiShow'); //matkul rata2
        Route::get('matkul/{matkul_id}', 'HasilEvaluasiMatkul@matkulShow'); //matkul semua dosen sort by nilai tertinggi

    });

    //Jurusan
    Route::group(['prefix' => 'jurusan'], function () {
        Route::get('jurusan', 'HasilEvaluasiJurusan@jurusan'); //jurusan
        Route::get('jurusan/{jurusan_id}', 'HasilEvaluasiJurusan@jurusanShow'); //prodi
    });


});


//Grafik Tahunan
Route::group(['prefix' => 'admin/grafik-tahunan'], function () {
    Route::get('keseluruhan', 'HasilEvaluasiGrafikTahunan@keseluruhan'); //keseluruhan
    Route::get('jurusan/{jurusan_id}', 'HasilEvaluasiGrafikTahunan@jurusan'); //jurusan
    Route::get('prodi/{prodi_id}', 'HasilEvaluasiGrafikTahunan@prodi'); //prodi
    Route::get('dosen/{dosen_id}', 'HasilEvaluasiGrafikTahunan@dosen'); //dosen

});



/*
select * from majors;


select * from study_programs where jurusan_id=1;

select angkatan from classes group by angkatan;

select * from classes where jurusan_id=1;
*/
