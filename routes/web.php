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

Route::get('area/enod/usuarios', function(){

  return view('usuarios');
});

Route::get('area/enod/users', 'UserController@index');
//Route::resource('users','UserController');

 //Route::get('test','TestController@index');
