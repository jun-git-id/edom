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

Route::get('tes-ui','TesController@ui');


Route::get('tes-admin/per-mhs', 'TesController@perMhs');
Route::get('tes-admin/ipk-dosen', 'TesController@ipkDosen');
Route::get('tes-admin/per-pertanyaan', 'TesController@perPert');
Route::get('tes-admin/rekap-ipk', 'TesController@rekapIpk');
