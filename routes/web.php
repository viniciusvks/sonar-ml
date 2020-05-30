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

//Auth::routes(['verify' => true]);

Route::get('/', function () { return redirect()->route('home'); })->name('root');
Route::get('/home', 'QueryController@index')->name('home');

Route::post('/query', 'QueryController@create')->name('query.create');
Route::get('/query/{query}', 'QueryController@show')->name('query.show');
