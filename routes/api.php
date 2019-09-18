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

/*
Route::middleware('auth:api')->get('/clientes','ClientesController@index');
*/

Route::group(['middleware' => 'auth:api'], function()
{
    Route::resource('clientes', 'ClientesController'); 
    Route::get('users/empresa', 'UserController@getUsersEmpresa');    
    Route::resource('users', 'UserController');    
    Route::resource('materiales', 'MaterialesController');
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
    Route::get('productos/ots', 'ProductosController@ProductosOts');
    Route::resource('productos', 'ProductosController');
    Route::resource('medidas', 'MedidasController');
    Route::resource('epps', 'EppsController');
    Route::resource('riesgos', 'RiesgosController');
    Route::resource('ot_riesgos', 'OtRiesgosController');
    Route::resource('fuentes', 'FuentesController');
    Route::resource('equipos', 'EquiposController');
    Route::resource('icis', 'IcisController');
    Route::resource('tecnicas', 'TecnicasController');
    Route::resource('tipos_magnetizacion', 'TiposMagnetizacionController');
    Route::resource('metodos_trabajo_pm', 'MetodosTrabajoPmController');
    Route::resource('corrientes', 'CorrientesController');
    Route::resource('color_particulas', 'ColorParticulasController');
    Route::resource('iluminaciones', 'IluminacionesController');
    Route::get('tecnicas/metodo/{metodo}', 'TecnicasController@tecnicasMetodo');
    Route::get('tecnicas_graficos/{id}', 'TecnicasGraficosController@index');
    Route::get('tecnica_distancias/{id}/diametro/{diametro}', 'TecnicaDistanciasController@TecnicaDistanciasDiametro');

    Route::resource('tipo_soldaduras', 'TipoSoldadurasController');
    Route::get('soldadores/cliente/{id}','SoldadoresController@SoldadoresCliente');
    
    Route::get('equipos/metodo/{metodo}', 'EquiposController@EquiposMetodo');

    Route::get('defectos_ri/planta', 'DefectosRiController@DefectosPlanta');
    Route::get('defectos_ri/gasoducto', 'DefectosRiController@DefectosGasoducto');

    
    Route::get('diametros', 'DiametrosEspesorController@getDiametros');
    Route::get('espesor/{id}', 'DiametrosEspesorController@getEspesor');
    
    Route::get('procedimientos_informes/ot/{id_ot}/metodo/{metodo}', 'DocumentacionesController@ProcedimientosMetodo');
    Route::get('informes/ot/{ot_id}/total', 'InformesController@OtInformesTotal');

  
    Route::get('informes/ot/{ot_id}/metodo/{metodo}/generar-numero-informe', 'InformesController@GenerarNumeroInforme');   

    Route::post('storage/referencia', 'StorageController@saveReferencia');
    Route::post('storage/documento', 'StorageController@saveDocumento');

    Route::resource('documentaciones', 'DocumentacionesController');
    Route::get('documentaciones/ot_operarios/{ot_id}/{user_id}', 'DocumentacionesController@getDocOtOperarios');

    //Soldadores
    Route::resource('ot_soldadores', 'OtSoldadoresController');  
    Route::get('ot_soldadores/ot/{id}','OtSoldadoresController@SoldadoresOt');
    Route::get('ot_soldadores/ot/{ot_id}/total', 'OtSoldadoresController@OtSoldadoresTotal');

    //operarios
    Route::resource('ot_operarios', 'OtOperariosController');
    Route::get('ot-operarios/users', 'OtOperariosController@users');
    Route::get('ot-operarios/ejecutor_ensayo/{ot_id}', 'OtOperariosController@getOperadoresOt');
    Route::get('ot_operarios/users/{ot_id}/total', 'OtOperariosController@OtOperadoresTotal');
   
    /*  informes */ 
    Route::resource('informes_ri', 'InformesRiController');
    Route::resource('informes_pm', 'InformesPmController');

    //Remito
  
    Route::get('remitos/ot/{ot_id}/total', 'RemitosController@RemitosTotal');
    Route::resource('remitos', 'RemitosController');
    
});


Route::get('/pdf/remito/{id}','PdfRemitosController@imprimir')->name('pdfRemito');
Route::get('/pdf/ot/{id}','PdfOtController@imprimir')->name('pdfot');
Route::get('/pdf/servicios/referencias/{id}','PdfServiciosReferenciasController@imprimir')->name('ServiciosReferencias');
Route::get('/pdf/productos/referencias/{id}','PdfProductosReferenciasController@imprimir')->name('ProductosReferencias');
Route::get('/pdf/productos/referencias/informe/pm/{id}','PdfInformesPmReferenciasController@imprimir')->name('InformePmReferencias');

Route::get('/pdf/informe/{id}','PdfInformesController@index')->name('pdfInformes');
Route::get('/pdf/informe/ri/{informe}','PdfInformesRiController@imprimir')->name('pdfInformeRi');
Route::get('/pdf/informe/pm/{informe}','PdfInformesPmController@imprimir')->name('pdfInformePm');



