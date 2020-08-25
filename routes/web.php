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
    return redirect('/login');
});


Route::get('/login', ['as'=> 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', ['as'=> 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::group(['middleware' => 'auth'], function(){

    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::resource('users', 'UserController');
    Route::get('users/trocarsenha/{id}', ['as'=> 'users.trocarsenha', 'uses' => 'UserController@trocarsenha']);
    Route::get('users/trocarpropriasenha/{id}', ['as'=> 'users.trocarpropriasenha', 'uses' => 'UserController@trocarpropriasenha']);
    Route::resource('profiles', 'ProfilesController');
});
