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
Route::post('/login', 'PassportController@login');
Route::post('/register', 'PassportController@register');
Route::post('/receive/results', ['uses' => 'VLResultsController@index', 'as' => 'receive_results']);
Route::get('/get_vl_results', ['uses' => 'VLResultsController@getResults', 'as' => 'get_vl_results']);
Route::get('/get_eid_results', ['uses' => 'VLResultsController@getEIDResults', 'as' => 'get_eid_results']);
Route::post('/receive/tb_results', 'TBResultsController@index');
Route::post('/receive/hts_results', 'HTSResultsController@index');
Route::get('/active_facilities', 'FacilityController@active_facilities');
Route::post('/get/results', 'SendResultsController@sendVLEID');
Route::post('/historical/results', 'SendResultsController@sendhistorical');
Route::post('/hts_results', 'SendResultsController@sendHTS');
Route::post('/tb_results', 'SendResultsController@sendTB');
Route::post('/remote/login/vl', 'RemoteLoginController@vl_results');
Route::post('/remote/login/eid', 'RemoteLoginController@eid_results');
//Route::post('/remote/login/hts', 'RemoteLoginController@hts_results');
Route::post('/remote/login/all', 'NewRemoteLoginController@results');
Route::post('/remote/login/hts', 'NewRemoteLoginController@hts');
Route::post('/get/il/viral_loads', 'SendResultsController@sendILInternet');
Route::post('/ushauri/get/results', 'UshauriController@getResults');
Route::post('/emr/get/results', 'EMRController@getResults');

Route::get('/notify/clients', 'UshauriController@notifyClients');
Route::get('/fetch/blacklist_users', 'SenderController@get_blacklist');


Route::middleware('auth:api')->group(function () {
    Route::post('/viral/loads', 'SendResultsController@ViralLoads');
    Route::get('/sms/gateway', 'SmsGatewayController@sender');
});
