<?php

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
Route::get('/epen','TesController@epen');
// TES EMAIL
Route::get('/tes-email','TesController@kirimEmail');

// TES PDF
Route::get('/tes-pdf','TesController@pdf');

//TES GRAFIK
Route::get('/grafik','TesController@grafik');
//grafik for pdf
Route::get('/grafik-pdf','TesController@grafikPdf');



//ADMIN
Route::group([
    'middleware' => ['auth','admin'],
    'prefix' => 'admin'
], function () {
    Route::get('/', function(){
        return 'ini hal admin';
    });
});



//MHS

Route::group([
    'middleware' => ['auth','mhs'],
    'prefix' => 'mhs'
], function () {
    Route::get('/', 'MahasiswaController@index');
});


Route::group([
    'middleware' => ['auth','dosen'],
    'prefix' => 'dosen'
], function () {
    Route::get('/', function(){
        return 'ini hal dosen';
    });
});
