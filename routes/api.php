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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::resource('users', 'UserController');
Route::resource('materiales', 'MaterialesController');
Route::resource('clientes', 'ClientesController');
Route::resource('provincias', 'ProvinciasController');
Route::resource('localidades', 'LocalidadesController');
Route::resource('contactos', 'ContactosController');
Route::resource('servicios', 'ServiciosController');
Route::resource('tipo_peliculas', 'TipoPeliculasController');
Route::resource('metodo_ensayos', 'MetodoEnsayosController');
Route::resource('norma_ensayos', 'NormaEnsayosController');
Route::resource('norma_evaluaciones', 'NormaEvaluacionesController');
Route::resource('ots', 'OtsController');
Route::resource('ot_servicios', 'OtServiciosController');
Route::resource('productos', 'ProductosController');
Route::resource('medidas', 'MedidasController');
Route::resource('epps', 'EppsController');
Route::resource('riesgos', 'RiesgosController');
Route::resource('ot_riesgos', 'OtRiesgosController');
Route::post('storage/create', 'StorageController@save');


Route::get('/pdf/ot/{id}','PdfOtController@imprimir')->name('pdfot');
Route::get('/pdf/servicios/referencias/{id}','PdfServiciosReferenciasController@imprimir')->name('ServiciosReferencias');
Route::get('/pdf/productos/referencias/{id}','PdfProductosReferenciasController@imprimir')->name('ProductosReferencias');

