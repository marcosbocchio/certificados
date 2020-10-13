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

Route::group(['middleware' => ['auth']], function () {

  Route::get('/area/enod','DashboardController@index')->name('dashboard');
//  Route::get('/area/enod','UserController@callviewPerfil')->name('perfil');

  Route::get('institucionales/{id}','DocumentacionesController@institucionales')->name('institucionales');
  Route::get('informes_importados/{id}','InformesImportadosController@open')->name('pdfinformes_importados');

  Route::get('download/{name}','SoftwareDownloadController@software_download')->name('software_download');
  Route::get('operadores/ot/{id}','OtOperariosController@index')->name('otOperadores');
  Route::get('interno_equipos/ot/{id}','InternoEquiposController@OtInternoEquipos')->name('otInternoEquipos');
  Route::get('soldadores/ot/{id}','OtSoldadoresController@index')->name('otSoldadores');
  Route::get('placas/informe/{id}','PlacasController@index')->name('placas');
  Route::get('documentos-escaneados/ot/{ot_id}/{tipo_documento}/{id}','DocumentosEscaneadosController@index')->name('ddocumentosEscaneados');
  Route::get('procedimientos/ot/{id}','OtProcedimientosPropiosController@index')->name('otProcedimientos');
  Route::get('documentaciones/ot/{id}','OtDocumentacionesController@index')->name('otDocumentaciones');
  Route::get('informes/ot/{id}','InformesController@index')->name('otInformes');
  Route::get('remitos/ot/{id}','RemitosController@index')->name('otRemitos');
  Route::get('partes/ot/{id}','PartesController@index')->name('otPartes');
  Route::get('certificados/ot/{id}','CertificadosController@index')->name('otCertificados');
  Route::get('documentaciones/operador/{id}', 'DocumentacionesController@operarios');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/{metodo}/create','InformesController@create');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/ri','InformesRiController@create')->name('InformeRiCreate');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/pm','InformesPmController@create')->name('InformePmCreate');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/lp','InformesLpController@create')->name('InformeLpCreate');
  Route::get('/area/enod/ot/{ot_id}/informe/metodo/us','InformesUsController@create')->name('InformeUsCreate');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit','InformesController@edit');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit/ri','InformesRiController@edit')->name('InformeRiEdit');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit/pm','InformesPmController@edit')->name('InformePmEdit');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit/lp','InformesLpController@edit')->name('InformeLpEdit');
  Route::get('/area/enod/ot/{ot_id}/informe/{id}/edit/us','InformesUsController@edit')->name('InformeUsEdit');
  Route::get('/area/enod/ot/{ot_id}/remito','RemitosController@create')->name('RemitoCreate');
  Route::get('/area/enod/ot/{ot_id}/remito/{id}/edit','RemitosController@edit')->name('RemitoEdit');
  Route::get('/area/enod/ot/{ot_id}/parte','PartesController@create')->name('ParteCreate');
  Route::get('/area/enod/ot/{ot_id}/parte/{id}/edit','PartesController@edit')->name('ParteEdit');
  Route::get('/area/enod/ot/{ot_id}/certificado','CertificadosController@create')->name('CertificadoCreate');
  Route::get('/area/enod/ot/{ot_id}/certificado/{id}/edit','CertificadosController@edit')->name('CertificadoEdit');

  Route::get('/area/enod/usuarios', 'UserController@callView')->name('usuarios');
  Route::get('/area/enod/materiales', 'MaterialesController@callView')->name('materiales');
  Route::get('/area/enod/agente_acloplamientos', 'AgenteAcoplamientosController@callView')->name('agente-acoplamiento');
  Route::get('/area/enod/clientes', 'ClientesController@callView')->name('clientes');
  Route::get('/area/enod/contratistas', 'ContratistasController@callView')->name('contratistas');
  Route::get('/area/enod/unidades-medidas', 'UnidadesMedidasController@callView')->name('unidades-medidas');
  Route::get('/area/enod/medidas', 'MedidasController@callView')->name('medidas');
  Route::get('/area/enod/medidas', 'MedidasController@callView')->name('medidas');
  Route::get('/area/enod/productos', 'ProductosController@callView')->name('productos');
  Route::get('/area/enod/norma_ensayos', 'NormaEnsayosController@callView')->name('norma-ensayos');
  Route::get('/area/enod/norma_evaluaciones', 'NormaEvaluacionesController@callView')->name('norma-evaluaciones');
  Route::get('/area/enod/servicios', 'ServiciosController@callView')->name('servicios');
  Route::get('/area/enod/soldadores', 'SoldadoresController@index')->name('soldadores');
  Route::get('/area/enod/fuentes', 'FuentesController@callView')->name('fuentes');
  Route::get('/area/enod/equipos', 'EquiposController@callView')->name('equipos');
  Route::get('/area/enod/interno_fuentes', 'InternoFuentesController@callView')->name('Interno-fuentes');
  Route::get('/area/enod/interno_equipos', 'InternoEquiposController@callView')->name('Interno-equipos');
  Route::get('/area/enod/vehiculos', 'VehiculosController@callView')->name('vehiculos');
  Route::get('/area/enod/modelos_3d', 'Modelos3dController@callView')->name('modelos-3d');

  Route::get('/area/enod/ots','OtsController@create')->name('ots.create')->middleware('auth');
  Route::get('/area/enod/ots/{id}/edit','OtsController@edit')->name('ots.edit');
  Route::get('/area/enod/documentaciones','DocumentacionesController@callView')->name('documentaciones');
  Route::get('/area/enod/roles','RolesController@callView')->name('roles');
  Route::get('/area/enod/permisos','PermissionsController@callView')->name('permisos');
  Route::get('/area/enod/dosimetria-operador','DosimetriaOperadorController@callView')->name('dosimetria-operador');
  Route::get('/area/enod/dosimetria-rx','DosimetriaRxController@callView')->name('dosimetria-rx');
  Route::get('/area/enod/dosimetria/estados','DosimetriaEstadosController@callView')->name('dosimetria-estados');
  Route::get('/area/enod/dosimetria/operador_periodo_rx','OperadorPeriodoRxController@callView')->name('operador-periodo-rx');
  Route::get('/area/enod/dosimetria/resumen','DosimetriaResumenController@callView')->name('dosimetria-resumen');
  Route::get('/area/enod/soldadores/estadisticas-soldaduras','EstadisticasSoldadurasController@callView')->name('estadisticas-soldaduras');

  // reportes

      Route::get('/pdf/dosimetria/periodos','PdfDosimetriaPeriodosController@imprimir')->name('pdfDosimetriaPeriodos');

      Route::get('/pdf/remito/{id}','PdfRemitosController@imprimir')->name('pdfRemito');
      Route::get('/pdf/parte/{id}/{estado}','PdfPartesController@imprimir');
      Route::get('/pdf/certificado/{id}/{estado}','PdfCertificadoController@imprimir');

      Route::get('/pdf/ot/{id}','PdfOtController@imprimir')->name('pdfot');
      Route::get('/pdf/servicios/referencias/{id}','PdfServiciosReferenciasController@imprimir')->name('ServiciosReferencias');
      Route::get('/pdf/productos/referencias/{id}','PdfProductosReferenciasController@imprimir')->name('ProductosReferencias');
      Route::get('/pdf/productos/referencias/informe/pm/{id}','PdfInformesPmReferenciasController@imprimir')->name('InformePmReferencias');
      Route::get('/pdf/productos/referencias/informe/lp/{id}','PdfInformesLpReferenciasController@imprimir')->name('InformeLpReferencias');

      Route::get('/pdf/dosimetria/year/{year}/operadores/{str_list_of_ids?}/rs/{cliente_sn}/months/{str_list_of_months}','PdfDosimetriaController@imprimir')->name('pdfDosimetriaAnual');

      Route::get('/pdf/soldadores/estadisticas-soldaduras/cliente/{cliente_id}/obra/{obra}/fecha_desde/{fecha_desde}/fecha_hasta/{fecha_hasta}','PdfEstadisticasSoldadurasController@imprimir')->name('pdfEstadisticasSoldaduras');

      Route::get('/pdf/informe/{id}','PdfInformesController@index')->name('pdfInformes');
      Route::get('/pdf/informe/lp/{informe}','PdfInformesLpController@imprimir')->name('pdfInformeLp');
      Route::get('/pdf/informe/ri/{informe}','PdfInformesRiController@imprimir')->name('pdfInformeRi');
      Route::get('/pdf/informe/pm/{informe}','PdfInformesPmController@imprimir')->name('pdfInformePm');
      Route::get('/pdf/informe/us/{informe}','PdfInformesUsController@imprimir')->name('pdfInformeUs');
      Route::get('/pdf/informe/us/indicaciones/referencia/{id}','PdfInformesUsReferenciaController@imprimir')->name('InformeUsDetalleUsPaUsReferencias');
      Route::get('/pdf/informe/us/{informe}/indicaciones_us_pa','PdfInformesUsIndicacionesUsPaController@imprimir')->name('InformeUsIndicacionesUsPa');
      Route::get('/pdf/informe/us/{informe}/indicaciones_me','PdfInformesUsIndicacionesMeController@imprimir')->name('InformeUsIndicacionesMe');


      /* Reportes */
      Route::get('/area/enod/reportes/estadisticas-soldaduras','EstadisticasSoldadurasController@callView')->name('reporte-estadisticas-soldaduras');
      Route::get('/area/enod/reportes/costuras','CosturasController@callView')->name('reporte-costuras');
      Route::get('/area/enod/reportes/placas-repetidas-testigos','ReportePlacasController@callView')->name('reporte-placas-repetidas-testigos');


      /*SECCION CATEGORIAS/VIDEOS  */

      Route::get('crear-contenido', 'GestionVideoController@callView')->name('crear-contenido');
      Route::get('categoriasVideos', 'GestionVideoController@getCategorias')->name('getCategorias');
      Route::get('subCategoriasVideos/{id}', 'GestionVideoController@getSubCategorias')->name('getSubCategorias');
      Route::get('get-Videos', 'GestionVideoController@getVideos')->name('getVideos');

      Route::post('category-update', 'GestionVideoController@storeCategory');
      Route::delete('category-delete', 'GestionVideoController@deleteCategory');

      Route::post('videos-new', 'GestionVideoController@nuevoVideo');
      Route::delete('video-delete', 'GestionVideoController@deleteVideo');

      Route::get('multimedia', 'VideosController@multimediaHome')->name('multimedia');
      Route::get('multimedia/{id}', 'VideosController@multimediaSubcategoria')->name('irAsubcategoria');
      Route::get('get-Videos-categoria/{id}', 'VideosController@getVideosCategoria');

      /* AYUDA */
      Route::get('ayuda_general', 'AyudaController@openAyuda')->name('ayuda-general');
      Route::get('ayuda_tablero_principal', 'AyudaController@openAyuda')->name('ayuda-tablero-principal');
      Route::get('ayuda_maestros', 'AyudaController@openAyuda')->name('ayuda-maestros');
      Route::get('ayuda_dosimetria', 'AyudaController@openAyuda')->name('ayuda-dosimetria');
      Route::get('ayuda_multimedia', 'AyudaController@openAyuda')->name('ayuda-multimedia');

      Route::get('cambiar_clave', 'AyudaController@cambiarClave')->name('ayuda-cambiar-clave');
      Route::get('buscar_formularios', 'AyudaController@BuscarFormularios')->name('ayuda-buscar-formularios');
      Route::get('visualizar_ot', 'AyudaController@visualizarOt')->name('ayuda-visualizar-ot');
      Route::get('crear_ot', 'AyudaController@crearOt')->name('ayuda-crear-ot');
      Route::get('asignar_soldadores_y_usuarios', 'AyudaController@asignarSoldadoresUsuarios')->name('ayuda-asignar-soldadores-y-usuarios');
      Route::get('generar_informes', 'AyudaController@generarInformes')->name('ayuda-generar-informes');
      Route::get('generar_informes_ri', 'AyudaController@generarInformesRi')->name('ayuda-generar-informes-ri');
      Route::get('generar_informes_pm', 'AyudaController@generarInformesPm')->name('ayuda-generar-informes-pm');
      Route::get('generar_informes_lp', 'AyudaController@generarInformesLp')->name('ayuda-generar-informes-lp');

      /* MODELOS 3D */
      Route::get('/area/enod/visualizador3d/{modelo_id}', 'Modelos3dController@Viewer')->name('viewer-3d');
});

Route::get('/pdf-test',function(){

  $user = auth()->user();
  $header_titulo = "Pdf Test";
  $header_descripcion ="";
  return view('pdf-test',compact('user','header_titulo','header_descripcion'));

});

Route::get('error_404', function(){

    abort(404);

})->name('error-404');


Route::resource('personas_web', 'PersonaController');

 Route::get('php', function () {
   phpinfo();
});

