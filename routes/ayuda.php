<?php

Route::group(['middleware' => ['auth']], function () {

    Route::get('ayuda_general', 'AyudaController@openAyuda')->name('ayuda-general');
    Route::get('ayuda_tablero_principal', 'AyudaController@openAyuda')->name('ayuda-tablero-principal');
    Route::get('ayuda_maestros', 'AyudaController@openAyuda')->name('ayuda-maestros');
    Route::get('ayuda_dosimetria', 'AyudaController@openAyuda')->name('ayuda-dosimetria');
    Route::get('ayuda_multimedia', 'AyudaController@openAyuda')->name('ayuda-multimedia');
    Route::get('cambiar_clave', 'AyudaController@cambiarClave')->name('ayuda-cambiar-clave');
    Route::get('buscar_formularios', 'AyudaController@BuscarFormularios')->name('ayuda-buscar-formularios');
    Route::get('visualizar_ot', 'AyudaController@visualizarOt')->name('ayuda-visualizar-ot');
    Route::get('crear_ot', 'AyudaController@crearOt')->name('ayuda-crear-ot');
    Route::get('asignar_operadores', 'AyudaController@asignarOperadores')->name('ayuda-asignar-operadores');
    Route::get('visualizar_documentacion_operadores', 'AyudaController@VisualizarDocOperadores')->name('ayuda-visualizar-doc-operadores');
    Route::get('asignar_soldadores_y_usuarios', 'AyudaController@asignarSoldadoresUsuarios')->name('ayuda-asignar-soldadores-y-usuarios');
    Route::get('asignar_vehiculos', 'AyudaController@asignarVehiculos')->name('ayuda-asignar-vehiculos');
    Route::get('asignar_procedimientos', 'AyudaController@asignarProcedimientos')->name('ayuda-asignar-procedimientos');
    Route::get('visualizar_procedimientos', 'AyudaController@visualizarProcedimientos')->name('ayuda-visualizar-procedimientos');
    Route::get('visualizar_vehiculos', 'AyudaController@VisualizarVehiculos')->name('ayuda-visualizar-vehiculos');
    Route::get('generar_informes', 'AyudaController@generarInformes')->name('ayuda-generar-informes');
    Route::get('generar_informes_ri', 'AyudaController@generarInformesRi')->name('ayuda-generar-informes-ri');
    Route::get('generar_informes_pm', 'AyudaController@generarInformesPm')->name('ayuda-generar-informes-pm');
    Route::get('generar_informes_lp', 'AyudaController@generarInformesLp')->name('ayuda-generar-informes-lp');
    Route::get('generar_informes_us', 'AyudaController@generarInformesUs')->name('ayuda-generar-informes-us');
    Route::get('gestionar_usuarios', 'AyudaController@VisualizarGestionUsuario')->name('ayuda-gestion-usuario');

    Route::get('ayuda_creacion_remito', 'AyudaController@creacionRemito')->name('ayuda-creacion-remito');
    Route::get('ayuda_gestion_normas', 'AyudaController@gestionNormas')->name('ayuda-gestion-normas');
    Route::get('ayuda_gestion_medidas', 'AyudaController@gestionMedidas')->name('ayuda-gestion-medidas');
    Route::get('ayuda_gestion_interno_fuente', 'AyudaController@gestionarInternoFuente')->name('ayuda-gestion-interno-fuente');
    Route::get('ayuda_gestion_cliente', 'AyudaController@gestionCliente')->name('ayuda-gestion-cliente');
    Route::get('ayuda_gestion_comitente', 'AyudaController@gestionComitente')->name('ayuda-gestion-comitente');
    Route::get('ayuda_gestion_documentaciones', 'AyudaController@gestionDocumentaciones')->name('ayuda-gestion-documentaciones');
    Route::get('ayuda_gestion_equipos', 'AyudaController@gestionEquipos')->name('ayuda-gestion-equipos');
    Route::get('ayuda_gestion_fuentes', 'AyudaController@gestionFuentes')->name('ayuda-gestion-fuentes');
    Route::get('ayuda_gestion_interno_equipos', 'AyudaController@gestionInternoEquipos')->name('ayuda-gestion-interno-equipos');
    Route::get('ayuda_gestion_materiales', 'AyudaController@gestionMateriales')->name('ayuda-gestion-materiales');
    Route::get('ayuda_gestion_productos', 'AyudaController@gestionProductos')->name('ayuda-gestion-productos');
    Route::get('ayuda_gestion_servicios', 'AyudaController@gestionServicios')->name('ayuda-gestion-servicios');
    Route::get('ayuda_gestion_soldadores', 'AyudaController@gestionSoldadores')->name('ayuda-gestion-soldadores');
    Route::get('ayuda_gestion_unidades_de_medida', 'AyudaController@gestionUnidadesDeMedida')->name('ayuda-gestion-unidades-de-medida');
    Route::get('ayuda_gestionar_roles', 'AyudaController@gestionarRoles')->name('ayuda-gestionar-roles');
});
