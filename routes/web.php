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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes();
Route::resource('department', 'DepartmentController');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user', 'UserController');
    Route::resource('disposition', 'DispositionRelationController');
    Route::get('disposisi/keluar', 'DispositionRelationController@out_disposition')->name('disposition.out');
    Route::get('disposisi/masuk', 'DispositionRelationController@in_disposition')->name('disposition.in');
    Route::get('disposisi/surat/{id}/{type}', 'DispositionRelationController@show')->name('disposition.showtype');
    Route::post('disposisi/{type}/{id}', 'DispositionRelationController@forward')->name('disposition.forward');
    Route::put('disposisi/{type}/{id}', 'DispositionController@verification')->name('disposition.verification');
    Route::resource('tipe-surat', 'LetterTypeController');
    Route::get('/hak-akses', function () {
        return view('pages.privilleges');
    })->name('privilleges');
    Route::get('surat-keluar', 'DispositionRelationController@outletter')->name('outletter.index');
    Route::get('surat-keluar/create', 'DispositionRelationController@outletter_create')->name('outletter.create');
    Route::post('surat-keluar/store', 'DispositionRelationController@outletter_store')->name('outletter.store');
    Route::get('cari', 'DispositionController@search')->name('disposition.search');
    Route::post('');
    Route::get('pengaturan', 'UserController@edit')->name('setting');
    Route::redirect('/', '/dashboard/home', 301);
});
Route::redirect('/home', '/dashboard/home', 301);
