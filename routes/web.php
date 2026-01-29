<?php

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



Route::get('/', 'HomefrontController@index')->name('/');
Route::get('/visimisi', 'HomefrontController@visimisi');
Route::get('/data-wakaf', 'DataWakafController@index')->name('data-wakaf');
Route::get('/data-wakaf/get-data', 'DataWakafController@getData')->name('data-wakaf.getData');
Route::get('/article/{id}', 'ArticleController@index')->name('posts.show');

Route::get('/jumlah-wakaf', 'JumlahWakafController@index')->name('jumlah-wakaf');
Route::get('/profile-wakif/{wakif}', 'ProfileWakifController@index')->name('profile-wakif');
Route::get('/about', 'AboutController@index')->name('about');
Route::get('/organization/structure', 'OrganizationController@showStructure')->name('organization.structure');
Route::get('/vision-mission', 'VisionMissionController@index')->name('vision-mission');
Route::get('/literasi', 'LiterasiController@index')->name('literasi.index');

Route::get('/pdf-view/{type}', 'PdfController@show')->name('pdf.show');


Route::group(['middleware' => 'guest'], function () {

    Route::get('/admin', function () {
        return view('auth.login');
    })->name('admin');

    Route::get('login', 'loginController@authenticate')->name('login');
});


Route::group(['middleware' => 'auth'], function () {

Route::get('/home', 'HomeController@index')->name('index');
Route::get('logout', 'HomeController@logout')->name('logout');

Route::get('/users', 'UsersController@index');
Route::get('/userstable', 'UsersController@datatable');
Route::post('/simpanusers', 'UsersController@simpan');
Route::get('/editusers', 'UsersController@edit');
Route::get('/hapususers', 'UsersController@hapus');

Route::get('/postscontent', 'PostController@index');
Route::get('/tambahpostscontent', 'PostController@tambah');
Route::get('/postscontenttable', 'PostController@datatable');
Route::post('/simpanpostscontent', 'PostController@simpan');
Route::get('/editpostscontent/{id}', 'PostController@edit');
Route::get('/doeditpostscontent', 'PostController@doedit');
Route::get('/removeimagepostscontent', 'PostController@removeimage');
Route::get('/hapuspostscontent', 'PostController@hapus');
Route::get('/highlightpostscontent', 'PostController@highlight');
Route::get('/toptrandpostscontent', 'PostController@toptrand');


Route::get('/profil/visimisi', 'VisimisiController@index');
Route::post('/profil/visimisi/save', 'VisimisiController@save');

Route::get('/cities', 'CitiesController@index');
Route::get('/citiestable', 'CitiesController@datatable');
Route::post('/simpancities', 'CitiesController@simpan');
Route::get('/editcities', 'CitiesController@edit');
Route::get('/hapuscities', 'CitiesController@hapus');

Route::get('/subdistricts', 'SubdistrictsController@index');
Route::get('/subdistrictstable', 'SubdistrictsController@datatable');
Route::post('/simpansubdistricts', 'SubdistrictsController@simpan');
Route::get('/editsubdistricts', 'SubdistrictsController@edit');
Route::get('/hapussubdistricts', 'SubdistrictsController@hapus');

Route::get('/vilages', 'VilagesController@index');
Route::get('/vilagestable', 'VilagesController@datatable');
Route::post('/simpanvilages', 'VilagesController@simpan');
Route::get('/editvilages', 'VilagesController@edit');
Route::get('/hapusvilages', 'VilagesController@hapus');

Route::get('/wakafland', 'WakaflandController@index');
Route::get('/wakaflandtable', 'WakaflandController@datatable');
Route::post('/simpanwakafland', 'WakaflandController@simpan');
Route::get('/editwakafland', 'WakaflandController@edit');
Route::get('/hapuswakafland', 'WakaflandController@hapus');

Route::get('/wakifs', 'WakifsController@index');
Route::get('/wakifstable', 'WakifsController@datatable');
Route::post('/simpanwakifs', 'WakifsController@simpan');
Route::get('/editwakifs', 'WakifsController@edit');
Route::get('/hapuswakifs', 'WakifsController@hapus');

Route::get('/nadzirs', 'NadzirsController@index');
Route::get('/nadzirstable', 'NadzirsController@datatable');
Route::post('/simpannadzirs', 'NadzirsController@simpan');
Route::get('/editnadzirs', 'NadzirsController@edit');
Route::get('/hapusnadzirs', 'NadzirsController@hapus');

Route::get('/banner', 'BannerController@index');
Route::get('/tambahbanner', 'BannerController@tambah');
Route::get('/bannertable', 'BannerController@datatable');
Route::post('/simpanbanner', 'BannerController@simpan');
Route::get('/editbanner/{id}', 'BannerController@edit');
Route::get('/doeditbanner', 'BannerController@doedit');
Route::get('/removeimagebanner', 'BannerController@removeimage');
Route::get('/hapusbanner', 'BannerController@hapus');

Route::post('/import-data', 'ImportController@importExcel')->name('import.excel');
}); // End Route Groub middleware auth
Route::get('/download-template', 'DownloadTemplateController@index')->name('download.template');

Route::get('/get-subdistricts/{city_id}', 'WakaflandController@getSubdistricts')->name('get.subdistricts');

Route::get('/get-villages/{subdistrict_id}', 'WakaflandController@getVillages')->name('get.villages');


Route::get('/getSubdistricts', 'WakaflandController@getSubdistricts');

Route::get('/nadzirs-front', 'NadzirsController@front')->name('nadzirs.index');

Route::get('/get-subdistricts/{cityId}', 'DataWakafController@getSubDistrictData');

Route::post('/wakafland/delete-photo', 'WakaflandController@deletePhoto')->name('wakafland.delete-photo');


