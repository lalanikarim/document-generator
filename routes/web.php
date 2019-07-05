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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/document', 'DocumentController@index')->name('get-documents');
Route::get('/document/create','DocumentController@create')->name('create-document');
Route::post('/document', 'DocumentController@store')->name('store-document');
Route::get('/document/{document}','DocumentController@show')->name('show-document');
Route::post('/document/{document}/processinline','DocumentController@processinline')->name('processinline-document');
Route::post('/document/{document}/processfile','DocumentController@processfile')->name('processfile-document');