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
  Route::get('soldadores/ot/{id}','OtSoldadoresController@index')->name('otSoldadores');
  Route::get('procedimientos/ot/{id}','OtProcedimientosPropiosController@index')->name('otProcedimientos');
  Route::get('documentaciones/ot/{id}','OtDocumentacionesController@index')->name('otDocumentaciones');
 // Route::get('informes/ot/{id}','OtInformesController@index')->name('otInformes');
  Route::get('informes/ot/{id}','InformesController@index')->name('otInformes');
  Route::get('remitos/ot/{id}','RemitosController@index')->name('otRemitos');
  Route::get('documentaciones/operador/{id}', 'DocumentacionesController@operarios');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/{metodo}/create','InformesController@create');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/ri','InformesRiController@create')->name('InformeRiCreate');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/pm','InformesPmController@create')->name('InformePmCreate');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit','InformesController@edit');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit/ri','InformesRiController@edit')->name('InformeRiEdit');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit/pm','InformesPmController@edit')->name('InformePmEdit');

  Route::get('/area/enod/ot/{ot_id}/remito','RemitosController@create')->name('RemitoCreate');
  Route::get('/area/enod/ot/{ot_id}/remito/{id}/edit','RemitosController@edit')->name('RemitoEdit');
  
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
