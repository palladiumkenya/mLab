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
    return view('sessions/signIn');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/get_subcounties', ['uses'=>'HomeController@get_subcounties', 'as'=>'get_subcounties']);
    Route::post('/get_facilities', ['uses'=>'HomeController@get_facilities', 'as'=>'get_facilities']);

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/add/user/form', 'UserController@adduserform')->name('adduserform');
    Route::post('/add/user', 'UserController@adduser')->name('adduser');
    Route::post('/edit/user', 'UserController@edituser')->name('edituser');
    Route::post('/reset/user', 'UserController@resetuser')->name('resetuser');
    Route::post('/change/password', 'UserController@changepass')->name('changepass');


    Route::get('/partners', 'PartnerController@index')->name('partners');
    Route::get('/add/partner/form', 'PartnerController@addpartnerform')->name('addpartnerform');
    Route::post('/add/partner', 'PartnerController@addpartner')->name('addpartner');
    Route::post('/edit/partner', 'PartnerController@editpartner')->name('editpartner');
    Route::post('/delete/partner', 'PartnerController@deletepartner')->name('deletepartner');


    Route::get('/facilities', 'FacilityController@index')->name('facilities');


    Route::get('/il/facilities', 'ILFacilityController@index')->name('il_facilities');
    Route::get('/add/il/facility/form', 'ILFacilityController@addilfacilityform')->name('addilfacilityform');
    Route::post('/add/il/facility', 'ILFacilityController@addilfacility')->name('addilfacility');
    Route::post('/edit/il/facility', 'ILFacilityController@edit_ilfacility')->name('edit_ilfacility');
    Route::post('/delete/il/facility', 'ILFacilityController@delete_ilfacility')->name('delete_ilfacility');

});