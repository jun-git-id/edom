<?php


Route::group([
    'prefix' => 'admin/hasil-evaluasi'
], function($router){
    Route::get('/per-mahasiswa','HasilEvaluasiController@perMahasiswa');
    Route::get('/dosen-per-kelas','HasilEvaluasiController@dosenPerKelas');
    Route::get('/dosen-kelas/{dosen_id}/{kelas_id}/{matkul_id}','HasilEvaluasiController@dosenSatuKelas');
    Route::get('/per-dosen','HasilEvaluasiController@perDosen');
});
