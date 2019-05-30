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

Route::redirect('/', '/login',301);

Auth::routes();


Route::group(['middleware' => ['permission:Navegar cliente']], function () {
  Route::get('/area/cliente', 'dashboardClientesController@index')->name('testcliente');
});

Route::group(['middleware' => ['permission:Navegar operador']], function () {
  Route::get('/area/enod', 'dashboardOperadoresController@index')->name('testoperador');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
