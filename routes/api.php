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

Route::get('/get_vl_results', ['uses' => 'VLResultsController@getResults', 'as' => 'get_vl_results']);
Route::get('/get_eid_results', ['uses' => 'VLResultsController@getEIDResults', 'as' => 'get_eid_results']);
Route::post('/tb_results', 'TBResultsController@index');
Route::post('/hts_results', 'HTSResultsController@index');
Route::get('/active_facilities', 'FacilityController@active_facilities');