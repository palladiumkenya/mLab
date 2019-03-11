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

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/add/user/form', 'UserController@adduserform')->name('adduserform');
    Route::post('/add/user', 'UserController@adduser')->name('adduser');
    Route::post('/edit/user', 'UserController@edituser')->name('edituser');
    Route::post('/reset/user', 'UserController@resetuser')->name('resetuser');
    Route::post('/change/password', 'UserController@changepass')->name('changepass');

});