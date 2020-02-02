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

Route::group(['middleware' => 'auth:api'], function()
{   
    Route::resource('parametros_generales', 'ParametrosGeneralesController');
    Route::get('clientes/paginate', 'ClientesController@paginate'); 
    Route::resource('clientes', 'ClientesController'); 
    Route::get('contratistas/paginate', 'ContratistasController@paginate'); 
    Route::resource('contratistas', 'ContratistasController'); 
    Route::get('users/empresa', 'UserController@getUsersEmpresa');  
    Route::get('users/paginate', 'UserController@paginate');      
    Route::resource('users', 'UserController');  
    Route::get('materiales/paginate', 'MaterialesController@paginate');        
    Route::resource('materiales', 'MaterialesController');
    Route::get('unidades_medidas/paginate', 'UnidadesMedidasController@paginate');
    Route::resource('unidades_medidas', 'UnidadesMedidasController');
    Route::get('medidas/cm', 'MedidasController@getCms');
    Route::get('medidas/paginate', 'MedidasController@paginate');
    Route::resource('medidas', 'MedidasController');
    Route::resource('provincias', 'ProvinciasController');
    Route::resource('localidades', 'LocalidadesController');
    Route::resource('contactos', 'ContactosController');
    Route::get('servicios/paginate', 'ServiciosController@paginate');
    Route::resource('servicios', 'ServiciosController');
    Route::resource('tipo_peliculas', 'TipoPeliculasController');
    Route::resource('metodo_ensayos', 'MetodoEnsayosController');
    Route::get('norma_ensayos/paginate', 'NormaEnsayosController@paginate');
    Route::resource('norma_ensayos', 'NormaEnsayosController');
    Route::get('norma_evaluaciones/paginate', 'NormaEvaluacionesController@paginate');
    Route::resource('norma_evaluaciones', 'NormaEvaluacionesController');
    Route::put('ots/{id}/firmar', 'OtsController@firmar');
    Route::resource('ots', 'OtsController');
    Route::get('ot_servicios/informe/{informe_id}/importado_sn/{importado_sn}', 'OtServiciosController@getOtServiciosInforme');
    Route::get('ot_servicios/ot/{ot_id}/generales', 'OtServiciosController@getOtServiciosGenerales');
    Route::resource('ot_servicios', 'OtServiciosController');
    Route::get('productos/ots', 'ProductosController@ProductosOts');
    Route::get('productos/paginate', 'ProductosController@paginate');
    Route::resource('productos', 'ProductosController');
    Route::resource('medidas', 'MedidasController');
    Route::resource('epps', 'EppsController');
    Route::resource('riesgos', 'RiesgosController');
    Route::resource('ot_riesgos', 'OtRiesgosController');
    Route::get('fuentes/interno_fuente/{interno_fuente_id}', 'FuentesController@getFuentePorInterno');
    Route::get('interno_fuentes/{interno_fuente_id}/fecha_final/{fecha_final}/curie', 'InternoFuentesController@CalcularCurie');
    Route::get('interno_fuentes/activos', 'InternoFuentesController@getFuentesActivos');  
    Route::get('interno_fuentes/paginate', 'InternoFuentesController@paginate');
    Route::resource('interno_fuentes', 'InternoFuentesController');
    Route::get('fuentes/paginate', 'FuentesController@paginate');
    Route::resource('fuentes', 'FuentesController');
    Route::get('equipos/paginate', 'EquiposController@paginate');
    Route::resource('equipos', 'EquiposController');
    Route::resource('icis', 'IcisController');
    Route::resource('tecnicas', 'TecnicasController');
    Route::resource('tipos_magnetizacion', 'TiposMagnetizacionController');
    Route::resource('metodos_trabajo_pm', 'MetodosTrabajoPmController');
    Route::resource('metodos_trabajo_lp', 'MetodosTrabajoLpController');
    Route::resource('aplicaciones_lp', 'AplicacionesLpController');
    Route::get('tipo_liquidos/{tipo}', 'TipoLiquidosController@getTipoLiquidos');
    Route::resource('corrientes', 'CorrientesController');
    Route::resource('color_particulas', 'ColorParticulasController');
    Route::resource('iluminaciones', 'IluminacionesController');
    Route::get('tecnicas/metodo/{metodo}', 'TecnicasController@tecnicasMetodo');
    Route::get('tecnicas_graficos/{id}', 'TecnicasGraficosController@index');
    Route::get('tecnica_distancias/{id}/diametro/{diametro}', 'TecnicaDistanciasController@TecnicaDistanciasDiametro');
    Route::resource('estados_superficies', 'EstadosSuperficiesController');
    Route::resource('palpadores', 'PalpadoresController');
    Route::resource('generatrices', 'GeneratricesController');

    Route::get('roles/paginate', 'RolesController@paginate');      
    Route::resource('roles', 'RolesController');

    Route::get('permissions/paginate', 'PermissionsController@paginate');      
    Route::resource('permissions', 'PermissionsController');

    Route::resource('tipo_soldaduras', 'TipoSoldadurasController');
    Route::get('users/cliente/{id}','UserController@UserCliente');

    Route::resource('soldadores', 'SoldadoresController');
    Route::get('soldadores/cliente/{id}/paginate', 'SoldadoresController@paginate');
    Route::get('soldadores/cliente/{id}','SoldadoresController@SoldadoresCliente');
    Route::post('soldadores/cliente/{id}','SoldadoresController@store');   

    Route::get('equipos/metodo/{metodo}', 'EquiposController@EquiposMetodo');

    Route::get('defectos_ri/planta', 'DefectosRiController@DefectosPlanta');
    Route::get('defectos_ri/gasoducto', 'DefectosRiController@DefectosGasoducto');

    
    Route::get('diametros', 'DiametrosEspesorController@getDiametros');
    Route::get('espesor/{id}', 'DiametrosEspesorController@getEspesor');
    
    Route::get('procedimientos_informes/ot/{id_ot}/metodo/{metodo}', 'DocumentacionesController@ProcedimientosMetodo');
    Route::get('informes/ot/{ot_id}/total', 'InformesController@OtInformesTotal');   
    Route::get('informes/ot/{ot_id}/paginate', 'InformesController@paginate');   
    Route::get('informes/{id}/importado_sn/{importado_sn}', 'InformesController@getObraInforme');   
    Route::put('informes/{id}/firmar', 'InformesController@firmar');   
    Route::put('informes/{id}/clonar', 'InformesController@clonar');   
    Route::get('informes/ot/{ot_id}/pendientes_parte_diario', 'InformesController@OtInformesPendienteParteDiario');
    Route::get('informes/ot/{ot_id}/parte/{parte_id}/pendientes_editables_parte_diario', 'InformesController@OtInformesPendienteEditableParteDiario');

  
    Route::get('informes/ot/{ot_id}/metodo/{metodo}/generar-numero-informe', 'InformesController@GenerarNumeroInforme');   

    Route::post('storage/referencia', 'StorageController@saveReferencia');
    Route::post('storage/documento', 'StorageController@saveDocumento');
    Route::post('storage/placas', 'StorageController@savePlacas');
    Route::post('storage/calibraciones_us', 'StorageController@saveCalibraciones');
    Route::post('storage/indicaciones_us', 'StorageController@saveIndicacionesUs');
    Route::post('storage/informes_importados', 'StorageController@saveinformesImportados');

    Route::post('storage/logo-cliente', 'StorageController@saveLogoCliente');
    Route::post('storage/logo-contratista', 'StorageController@saveLogoContratista');

    Route::post('storage/firma-digital', 'StorageController@saveFirmaDigital');

    Route::post('storage/firma-digital', 'StorageController@saveFirmaDigital');

    Route::get('documentaciones/ot','DocumentacionesController@DocumentacionesDeOt'); 
    Route::resource('documentaciones', 'DocumentacionesController');   
    Route::get('documentaciones/ot_operarios/{ot_id}/{user_id}', 'DocumentacionesController@getDocOtOperarios');
    
    Route::get('interno_equipos/metodo/{metodo}/activos', 'InternoEquiposController@getEquiposMetodoActivos');   
    Route::get('interno_equipos/paginate', 'InternoEquiposController@paginate');
    Route::resource('interno_equipos', 'InternoEquiposController');
      
    //interno Equipos

    Route::get('interno_equipos/ot/{ot_id}/total', 'InternoEquiposController@OtInternoEquiposTotal');
    Route::post('interno_equipos/ot/{ot_id}', 'InternoEquiposController@StoreOtInternoEquipos');

    //Soldadores
    Route::resource('ot_soldadores', 'OtSoldadoresController');  
    Route::get('ot_soldadores/ot/{id}','OtSoldadoresController@SoldadoresOt');
    Route::get('ot_soldadores/ot/{ot_id}/total', 'OtSoldadoresController@OtSoldadoresTotal');
    Route::get('ot_usuarios_clientes/ot/{ot_id}/total', 'OtUsuariosClientesController@OtUsuariosClienteTotal');
    
    //operarios
    Route::resource('ot_operarios','OtOperariosController');
    Route::get('ot-operarios/users','OtOperariosController@users');
    Route::get('ot-operarios/ot/{ot_id}','OtOperariosController@getOperadoresOt');
    Route::get('ot_operarios/users/{ot_id}/total','OtOperariosController@OtOperadoresTotal');
    
    /* Documentaciones*/
    Route::resource('ot_documentaciones','OtDocumentacionesController');
    Route::get('ot-documentaciones/ot/{id}','OtDocumentacionesController@DocumentacionesOt');
    Route::get('ot-documentaciones/ot/{ot_id}/total','OtDocumentacionesController@OtDocumentacionesTotal');
    
    /*  informes */ 
    Route::resource('informes_ri','InformesRiController');    
    Route::resource('informes_pm','InformesPmController');
    Route::resource('informes_lp','InformesLpController');
    Route::resource('informes_us','InformesUsController');

     /*  informes importados */ 

    Route::resource('informes_importados','InformesImportadosController');

    //Remito  
    Route::get('remitos/ot/{ot_id}/total','RemitosController@RemitosTotal');
    Route::get('remitos/ot/{ot_id}/paginate', 'RemitosController@paginate');   
    Route::resource('remitos','RemitosController');
    Route::get('remitos/ot/{ot_id}/generar-numero-remito', 'RemitosController@GenerarNumeroRemito');   


    //procedimientos
    Route::resource('ot_procedimientos_propios','OtProcedimientosPropiosController');
    Route::get('ot_procedimientos_propios/ot/{id}','OtProcedimientosPropiosController@ProcedimientosPropiosOt');
    Route::get('ot_procedimientos_propios/ot/{id}/total','OtProcedimientosPropiosController@OtProcedimientosTotal');   
    
    //placas
    Route::resource('placas_ri','PlacasRiController');
    Route::get('placas_ri/informe/{id}','PlacasRiController@PlacasInforme');

    // Dosimetría

    Route::get('dosimetria_operador/operador/{operador_id}/year/{year}/month/{month}','DosimetriaOperadorController@getDosimetriaOperador');
    Route::get('dosimetria_operador/operadores','DosimetriaOperadorController@getDosimetriaOperadores');
    Route::get('dosimetria_rx/year/{year}/month/{month}','DosimetriaRxController@getDosimetriaRx');
    Route::get('dosimetria_estados/year/{year}/month/{month}','DosimetriaEstadosController@getDosimetriaEstados');
    Route::get('estados_operador_rx/estados','EstadosOperadorRxController@getEstados');
    Route::get('operador_periodo_rx/periodos/operador/{id}','OperadorPeriodoRxController@getOperadorPeriodos');
    Route::get('dosimetria_resumen/year/{year}','DosimetriaResumenController@getResumen');

    Route::resource('dosimetria_operador','DosimetriaOperadorController');
    Route::resource('dosimetria_rx','DosimetriaRxController');
    Route::resource('dosimetria_estados','DosimetriaEstadosController');
    Route::resource('operador_periodo_rx','OperadorPeriodoRxController');

    //parte diario

    Route::get('partes/ot/{ot_id}/paginate', 'PartesController@paginate');       
    Route::get('partes/ot/{ot_id}/ddppi', 'PartesController@ddppi');   
    Route::get('partes/ot/{ot_id}/total','PartesController@PartesTotal');
    Route::put('partes/{id}/firmar', 'PartesController@firmar');
    Route::resource('partes', 'PartesController');
    Route::get('partes/informe_importado/{id}','PartesController@getInformeImportado');
    Route::get('partes/informe_ri/{id}','PartesController@getInformeRiParte');
    Route::get('partes/informe_pm/{id}','PartesController@getInformePmParte');
    Route::get('partes/informe_lp/{id}','PartesController@getInformeLpParte');    
    Route::get('partes/informe_us/{id}','PartesController@getInformeUsParte');

});


Route::get('/pdf/remito/{id}','PdfRemitosController@imprimir')->name('pdfRemito');
Route::get('/pdf/parte/{id}/{estado}','PdfPartesController@imprimir')->name('pdfParteOriginal');
Route::get('/pdf/parte/{id}/{estado}','PdfPartesController@imprimir')->name('pdfParteFinal');
Route::get('/pdf/ot/{id}','PdfOtController@imprimir')->name('pdfot');
Route::get('/pdf/servicios/referencias/{id}','PdfServiciosReferenciasController@imprimir')->name('ServiciosReferencias');
Route::get('/pdf/productos/referencias/{id}','PdfProductosReferenciasController@imprimir')->name('ProductosReferencias');
Route::get('/pdf/productos/referencias/informe/pm/{id}','PdfInformesPmReferenciasController@imprimir')->name('InformePmReferencias');
Route::get('/pdf/productos/referencias/informe/lp/{id}','PdfInformesLpReferenciasController@imprimir')->name('InformeLpReferencias');


Route::get('/pdf/dosimetria/year/{year}','PdfDosimetriaController@imprimir')->name('pdfDosimetriaAnual');
Route::get('/pdf/dosimetria/periodos','PdfDosimetriaPeriodosController@imprimir')->name('pdfDosimetriaPeriodos');

Route::get('/pdf/informe/{id}','PdfInformesController@index')->name('pdfInformes');
Route::get('/pdf/informe/lp/{informe}','PdfInformesLpController@imprimir')->name('pdfInformeLp');
Route::get('/pdf/informe/ri/{informe}','PdfInformesRiController@imprimir')->name('pdfInformeRi');
Route::get('/pdf/informe/pm/{informe}','PdfInformesPmController@imprimir')->name('pdfInformePm');
Route::get('/pdf/informe/us/{informe}','PdfInformesUsController@imprimir')->name('pdfInformeUs');
Route::get('/pdf/informe/us/indicaciones/referencia/{id}','PdfInformesUsReferenciaController@imprimir')->name('InformeUsDetalleUsPaUsReferencias');
Route::get('/pdf/informe/us/{informe}/indicaciones_us_pa','PdfInformesUsIndicacionesUsPaController@imprimir')->name('InformeUsIndicacionesUsPa');
Route::get('/pdf/informe/us/{informe}/indicaciones_me','PdfInformesUsIndicacionesMeController@imprimir')->name('InformeUsIndicacionesMe');

Route::get('/fecha_actual',function(){

    return date("Y/m/d H:i:s");
});


Route::resource('personas', 'PersonaController');


