<?php

use App\Documentaciones;
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

Route::redirect('/', '/login',301)->name('login');

Auth::routes();

/*
Route::get('institucionales/{id}','DocumentacionesController@institucionales')
->middleware('auth')
->name('institucionales');

Route::get('operadores/ot/{id}','OtOperariosController@index')
->middleware('auth')
->name('otOperadores');


*/

Route::group(['middleware' => ['permission:Navegar cliente']], function () {

  Route::get('/area/cliente', 'dashboardClientesController@index')->name('dashboardC');

});

Route::group(['middleware' => ['auth']], function () {

  Route::get('institucionales/{id}','DocumentacionesController@institucionales')->name('institucionales');
  Route::get('operadores/ot/{id}','OtOperariosController@index')->name('otOperadores');
  Route::get('informes/ot/{id}','OtInformesController@index')->name('otInformes');
  Route::get('documentaciones/operador/{id}', 'DocumentacionesController@operarios');
  Route::get('/area/enod/ot/{ot_id}/metodo/ri','InformesRiController@create');
  Route::get('/area/enod/ot/{ot_id}/metodo/ri/{id}/edit','InformesRiController@edit');
});

Route::group(['middleware' => ['permission:Navegar operador']], function () {

  Route::get('/area/enod','dashboardOperadoresController@index')->name('dashboardO');
  Route::get('/area/enod/usuarios', 'UserController@callView')->name('usuarios');
  Route::get('/area/enod/materiales', 'MaterialesController@callView')->name('materiales');
  Route::get('/area/enod/ots','OtsController@create')->name('ots.create')->middleware('auth');
  Route::get('/area/enod/ots/{id}/edit','OtsController@Edit')->name('ots.edit');
  Route::get('/area/enod/documentaciones','DocumentacionesController@callView')->name('documentaciones');
 


});

//Route::get('documentaciones/operador/{id}', 'DocumentacionesController@operarios')->middleware('auth');




//Route::get('area/enod/users', 'UserController@index');
//Route::resource('users','UserController');

 //Route::get('test','TestController@index');

 Route::get('test', function () {
  return Auth::id();
}); 
