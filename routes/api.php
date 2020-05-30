<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::patch('/query/{query}','QueryController@edit');
Route::delete('/query/{query}','QueryController@delete');
Route::patch('/query/{query}/sync','QueryController@sync');
//TODO: unificar
Route::patch('/query/{query}/listing/{listing}/mark-as-read','QueryController@markListingAsRead');
Route::patch('/query/{query}/listing/bulk-mark-as-read','QueryController@bulkMarkListingsAsRead');
