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
    Route::get('colores', 'ColoresController@index');
    Route::resource('parametros_generales', 'ParametrosGeneralesController');
    Route::get('clientes/paginate', 'ClientesController@paginate');
    Route::get('clientes/{cliente_id}/ots', 'ClientesController@getOts');
    Route::get('clientes/operador/{user_id}', 'ClientesController@getClientesOperador');
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
    Route::put('ots/{ot_id}/firmar', 'OtsController@firmar');
    Route::put('ots/{ot_id}/cerrar', 'OtsController@cerrar');
    Route::get('ots/{ot_id}/obras', 'OtsController@getObras');
    Route::get('ots/{ot_id}/obras_por_tipo_soldaduras', 'OtsController@getObrasTipoSoldaduras');
    Route::resource('ots', 'OtsController');
    Route::get('ot_servicios/informe/{informe_id}/importado_sn/{importado_sn}', 'OtServiciosController@getOtServiciosInforme');
    Route::get('ot_servicios/ot/{ot_id}', 'OtServiciosController@getOtServicios');
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
    Route::get('interno_fuentes/activo_sn/{activo_sn?}', 'InternoFuentesController@getInternoFuentes');
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
    Route::get('tipo_liquidos/penetrante_sn/{penetrante_sn}/revelador_sn/{revelador_sn}/removedor_sn/{removedor_sn}/metodo_trabajo_lp_id/{metodo_trabajo_lp_id}', 'TipoLiquidosController@getTipoLiquidos');
    Route::resource('corrientes', 'CorrientesController');
    Route::get('contrastes/getTodos', 'ContrastesController@getTodos');
    Route::resource('particulas', 'ParticulasController');
    Route::get('particulas/metodo_trabajo_pm/{metodo_trabajo_pm_id}', 'ParticulasController@getParticulasMetodoTrabajoPm');
    Route::resource('color_particulas', 'ColorParticulasController');
    Route::resource('iluminaciones', 'IluminacionesController');
    Route::get('tecnicas/metodo/{metodo}', 'TecnicasController@tecnicasMetodo');
    Route::get('tecnicas_graficos/{id}', 'TecnicasGraficosController@index');
    Route::get('tecnica_distancias/tecnica/{tecnica_id}/diametro/{diametro}/espesor/{espesor}/foco/{foco}', 'TecnicaDistanciasController@DistanciasDiametro');
    Route::get('tecnica_distancias/tecnica/{tecnica_id}/medida/{medida}', 'TecnicaDistanciasController@DistanciasDiametroChapa');
    Route::resource('estados_superficies', 'EstadosSuperficiesController');
    Route::get('agente_acoplamientos/paginate', 'AgenteAcoplamientosController@paginate');
    Route::resource('agente_acoplamientos', 'AgenteAcoplamientosController');
    Route::get('modelos_3d/paginate', 'Modelos3dController@paginate');
    Route::resource('modelos_3d', 'Modelos3dController');
    Route::get('vehiculos/ot/{ot_id}/total', 'VehiculosController@OtVehiculosTotal');
    Route::get('vehiculos/paginate', 'VehiculosController@paginate');
    Route::resource('vehiculos', 'VehiculosController');

    Route::resource('palpadores', 'PalpadoresController');

    Route::resource('generatrices', 'GeneratricesController');

    Route::get('roles/paginate', 'RolesController@paginate');
    Route::resource('roles', 'RolesController');

    Route::get('permissions/user', 'PermissionsController@GetPermissionsUser');
    Route::get('permissions/paginate', 'PermissionsController@paginate');
    Route::resource('permissions', 'PermissionsController');

    Route::resource('tipo_soldaduras', 'TipoSoldadurasController');
    Route::get('users/cliente/{id}','UserController@UserCliente');
    Route::get('users/usuario_metodos/{id}','UserController@getUsuarioMetodos');

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
    Route::get('informes/ot/{ot_id}/obra/{obra}/fecha_desde/{fecha_desde}/fecha_hasta/{fecha_hasta}', 'InformesController@getInformesEstadisticasSoldaduras');
    Route::get('informes/revisiones/ot/{ot_id}/metodo/{metodo}/numero/{numero}', 'InformesController@getInformeRevisiones');


    Route::get('certificados/parte/{parte_id}/servicios', 'CertificadosController@getParteServicios');
    Route::get('certificados/parte/{parte_id}/modo_cobro/{modo_cobro}/productos', 'CertificadosController@getParteProductos');
    Route::get('certificados/ot/{ot_id}/modalidad_cobro', 'CertificadosController@getModalidadCobro');

    Route::get('informes/ot/{ot_id}/metodo/{metodo}/generar-numero-informe', 'InformesController@GenerarNumeroInforme');
    Route::get('certificados/generar-numero-certificado', 'CertificadosController@GenerarNumeroCertificado');

    Route::post('storage/referencia', 'StorageController@saveReferencia');
    Route::post('storage/documento', 'StorageController@saveDocumento');
    Route::post('storage/placas_ri', 'StorageController@savePlacasRi');
    Route::post('storage/placas_us', 'StorageController@savePlacasUs');

    Route::post('storage/calibraciones_us', 'StorageController@saveCalibraciones');
    Route::post('storage/indicaciones_us', 'StorageController@saveIndicacionesUs');
    Route::post('storage/informes_importados', 'StorageController@saveInformesImportados');

    Route::post('storage/documentos_escaneados', 'StorageController@saveDocumentosEscaneados');
    Route::post('storage/logo-cliente', 'StorageController@saveLogoCliente');
    Route::post('storage/logo-contratista', 'StorageController@saveLogoContratista');
    Route::post('storage/modelos_3d', 'StorageController@saveModelos3d');

    Route::post('storage/firma-digital', 'StorageController@saveFirmaDigital');

    Route::post('storage/firma-digital', 'StorageController@saveFirmaDigital');

    Route::post('storage/documentos_videos', 'StorageController@saveDocumentosVideos');

    Route::get('documentaciones/ot','DocumentacionesController@DocumentacionesDeOt');

    Route::get('documentaciones/total', 'DocumentacionesController@DocumentacionesTotal');
    Route::get('documentaciones/verificar_duplicados/tipo/{tipo?}/titulo/{titulo?}/usuario/{user_id?}/equipo/{interno_equipo_id?}/fuente/{interno_fuente_id?}/vehiculo/{vehiculo_id}', 'DocumentacionesController@verificarDuplicados');
    Route::resource('documentaciones', 'DocumentacionesController');
    Route::get('documentaciones/ot/paginate', 'DocumentacionesController@paginate');

    Route::get('documentaciones/ot_operarios/{ot_id}/{user_id}', 'DocumentacionesController@getDocOtOperarios');
    Route::get('documentaciones/vehiculos/{vehiculo_id}', 'DocumentacionesController@getDocVehiculo');
    Route::get('documentaciones/interno_equipo/{interno_equipo_id}', 'DocumentacionesController@getDocInternoEquipo');
    Route::get('documentaciones/ot/{ot_id}/interno_equipo/{interno_equipo_id}/fuentes_documentaciones', 'DocumentacionesController@getDocPorInternoOt');

    Route::get('interno_equipos/metodo/{metodo}/activo_sn/{activo_sn?}/tipo_penetrante/{tipo_penetrante?}', 'InternoEquiposController@getInternoEquipos');
    Route::get('interno_equipos/paginate', 'InternoEquiposController@paginate');
    Route::resource('interno_equipos', 'InternoEquiposController');

    //interno Equipos

    Route::get('interno_equipos/ot/{ot_id}/total', 'InternoEquiposController@OtInternoEquiposTotal');
    Route::post('interno_equipos/ot/{ot_id}', 'InternoEquiposController@StoreOtInternoEquipos');

    //Soldadores
    Route::resource('ot_soldadores', 'OtSoldadoresController');
    Route::post('ot_soldadores/insertar_importados/ot/{id}/cliente/{cliente_id}','OtSoldadoresController@ImportarSoldadores');

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
    Route::get('informes_ri/elementos_reparacion/ot/{ot_id}/obra/{obra}/km/{km}/linea/{linea}/plano_isom/{plano_isom}/hoja/{hoja}', 'InformesRiController@getElementosReparacion');
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

    Route::resource('ot_tipo_soldaduras','OtTipoSoldadurasController');
    Route::get('ot_tipo_soldaduras/ot/{id}','OtTipoSoldadurasController@TipoSoldadurasOt');
    Route::get('ot_tipo_soldaduras/ot/{id}/obra/{obra?}','OtTipoSoldadurasController@TipoSoldadurasOtObra');
    Route::get('ot_tipo_soldaduras/ot/{id}/epss','OtTipoSoldadurasController@EpssOt');
    Route::get('ot_tipo_soldaduras/ot/{id}/pqrs','OtTipoSoldadurasController@PqrsOt');

    //placas

    Route::resource('placas_ri','PlacasRiController');
    Route::get('placas_ri/informe/{id}','PlacasRiController@PlacasInforme');

    Route::resource('placas_us','PlacasUsController');
    Route::get('placas_us/informe/{id}','PlacasUsController@PlacasInforme');

    //Documentos Escaneados

    Route::resource('documentos_escaneados','DocumentosEscaneadosController');
    //Route::post('documentos_escaneados/ot/{ot_id}/{tipo_documento}/{id}','DocumentosEscaneadosController@store');
    //Route::post('documentos_escaneados/{tipo_documento}/{id}','DocumentosEscaneadosController@update');
    Route::get('documentos_escaneados/ot/{ot_id}/tipo_documento/{tipo_documento}/{id}','DocumentosEscaneadosController@DocumentosEscaneadosOt');

    // Dosimetría
    Route::get('dosimetria_operador/operador/{operador_id}/year/{year}/month/{month}','DosimetriaOperadorController@getDosimetriaOperador');
    Route::get('dosimetria_operador/operadores','DosimetriaOperadorController@getDosimetriaOperadores');
    Route::get('dosimetria_rx/year/{year}/month/{month}','DosimetriaRxController@getDosimetriaRx');
    Route::get('dosimetria_estados/year/{year}/month/{month}','DosimetriaEstadosController@getDosimetriaEstados');
    Route::get('estados_operador_rx/estados','EstadosOperadorRxController@getEstados');
    Route::get('operador_periodo_rx/periodos/operador/{id}','OperadorPeriodoRxController@getOperadorPeriodos');
    Route::get('dosimetria_resumen/year/{year}/operadores/{id}','DosimetriaResumenController@getResumen');

    Route::resource('dosimetria_operador','DosimetriaOperadorController');
    Route::resource('dosimetria_rx','DosimetriaRxController');
    Route::resource('dosimetria_estados','DosimetriaEstadosController');
    Route::resource('operador_periodo_rx','OperadorPeriodoRxController');

    //parte diario
    Route::get('partes/ot/{ot_id}/certificado/{certificado_id}/pendientes_editables_certificado', 'PartesController@OtPartesPendienteEditableCertificado');
    Route::get('partes/ot/{ot_id}/pendientes_certificados', 'PartesController@OtPartesPendienteCertificado');
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

    //certificados
    Route::put('certificados/{id}/firmar', 'CertificadosController@firmar');
    Route::get('certificados/ot/{ot_id}/total','CertificadosController@CertificadosTotal');
    Route::get('certificados/ot/{ot_id}/paginate', 'CertificadosController@paginate');
    Route::resource('certificados', 'CertificadosController');

    //trazabilidad
    Route::get('trazabilidad_fuente/interno_equipo/{interno_equipo_id}','TrazabilidadFuenteController@getTrazabilidad');

    /* informes clientes */

    //Estadisticas soldaduras
    Route::get('estadisticas-soldaduras/total_soldaduras_informes/{informes_ids}','EstadisticasSoldadurasController@CantSoldadurasInformes');
    Route::get('estadisticas-soldaduras/total_rechazos_soldaduras/{informes_ids}','EstadisticasSoldadurasController@CantRechazosSoldaduras');
    Route::get('estadisticas-soldaduras/analisis_rechazos_espesor/{informes_ids}','EstadisticasSoldadurasController@AnalisisRechazosEspesor');
    Route::get('estadisticas-soldaduras/analisis_rechazos_diametro/{informes_ids}','EstadisticasSoldadurasController@AnalisisRechazosDiametro');
    Route::get('estadisticas-soldaduras/analisis_defectos_posicion/{informes_ids}','EstadisticasSoldadurasController@AnalisisDefectosPosicion');
    Route::get('estadisticas-soldaduras/analisis_detalle_defectos/{informes_ids}','EstadisticasSoldadurasController@AnalisisSoldadurasDetalleDefectos');
    Route::get('estadisticas-soldaduras/analisis_defectos_soldador/{informes_ids}','EstadisticasSoldadurasController@AnalisisSoldadurasDefectosSoldador');
    Route::get('estadisticas-soldaduras/analisis_indicaciones/{informes_ids}','EstadisticasSoldadurasController@AnalisisSoldadurasIndicaciones');
    Route::get('estadisticas-soldaduras/analisis_detalle_indicaciones/{informes_ids}','EstadisticasSoldadurasController@AnalisisSoldadurasDetalleIndicaciones');
    Route::get('estadisticas-soldaduras/analisis_indicaciones_posicion/posicion/{posicion}/diametro/{diametro}/{informes_ids}','EstadisticasSoldadurasController@AnalisisSoldadurasIndicacionesPosicion');

    //Costuras
    Route::get('costuras/ot/{ot_id}/pk/{pk}/plano/{plano}/costura/{costura}/rechazados/{rechazados}/reparaciones/{reparaciones}','CosturasController@getCosturas');
    Route::get('reporte-placas/cliente/{cliente_id}/ot/{ot_id}/obra/{obra}/fecha_desde/{fecha_desde}/fecha_hasta/{fecha_hasta}/total','ReportePlacasController@getPlacasTotal');
    Route::get('reporte-placas/cliente/{cliente_id}/ot/{ot_id}/obra/{obra}/fecha_desde/{fecha_desde}/fecha_hasta/{fecha_hasta}/repetidas-testigos','ReportePlacasController@getPlacasRepetidasTestigos');

    //Notificaciones
    Route::get('alarmas/dosimetria','AlarmasController@getAlarmaDosimetria');
    Route::get('alarmas/todas','AlarmasController@getTodas');
    Route::get('alarma-receptor/alarma/{id}','AlarmaReceptorController@getAlarmaReceptor');
    Route::get('notificaciones/user/{user_id}','NotificacionesController@getNotificaciones');
    Route::get('notificaciones_resumen/user/{user_id}','NotificacionesResumenViewController@getResumenUsuario');
    Route::put('notificaciones/marcar/{id}','NotificacionesController@marcarNotificaciones');
    Route::resource('alarmas','AlarmasController');
    Route::resource('alarma-receptor','AlarmaReceptorController');
    Route::resource('notificaciones','NotificacionesController');


});

Route::get('/fecha_actual',function(){

    return date("Y/m/d H:i:s");

});

/*
api/tipo_liquidos/penetrante_sn/{penetrante_sn}/revelador_sn{revelador_sn}/removedor_sn/{removedor_sn}/metodo_trabajo_lp_id/{metodo_trabajo_lp_id}
http://certificados.test/api/tipo_liquidos/penetrante_sn/0/revelador_sn/1/removedor_sn/0/metodo_trabajo_lp_id/1?api_token=XOttyjkkDp1MsUzKGAZiP3y6uTLTieB2qAc4YT22I9ApoBia77V7arjioMSG



*/
