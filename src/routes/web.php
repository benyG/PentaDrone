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
 
Route::get('/language/{locale}', 'InternationalizeController@language')->name('language');

Route::get('/', 'Auth\LoginController@login');
Auth::routes();

Route::middleware('auth')->group(function(){

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/folder', 'HomeController@folder')->name('folder');
    Route::get('/users', 'HomeController@users')->name('users');
    Route::get('/get/operation/{id}/{min}', 'HomeController@getOperation')->name('get.operation');
    Route::get('/get/pc/result/{id}', 'HomeController@getPcResult')->name('get.pc.result');

    Route::post('/create/operation', 'HomeController@createOperation')->name('create.operation');
    Route::post('/edit/operation', 'HomeController@editOperation')->name('edit.operation');
    Route::delete('/delete/operation', 'HomeController@deleteOperation')->name('delete.operation');

});
