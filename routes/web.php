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
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user', 'UserController');
    Route::resource('disposition', 'DispositionRelationController');
    Route::get('disposisi/keluar', 'DispositionRelationController@out_disposition')->name('disposition.out');
    Route::get('disposisi/masuk', 'DispositionRelationController@in_disposition')->name('disposition.in');
    Route::get('disposisi/surat/{id}/{type}', 'DispositionRelationController@show')->name('disposition.showtype');
    Route::resource('tipe-surat', 'LetterTypeController');
    Route::get('pengaturan', 'UserController@edit')->name('setting');
    Route::redirect('/', '/dashboard/home', 301);
});