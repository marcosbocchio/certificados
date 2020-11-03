<?php

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
Route::get('asignar_procedimientos', 'AyudaController@asignarprocedimientos')->name('ayuda-asignar-procedimientos');
Route::get('visualizar_vehiculos', 'AyudaController@VisualizarVehiculos')->name('ayuda-visualizar-vehiculos');
Route::get('generar_informes', 'AyudaController@generarInformes')->name('ayuda-generar-informes');
Route::get('generar_informes_ri', 'AyudaController@generarInformesRi')->name('ayuda-generar-informes-ri');
Route::get('generar_informes_pm', 'AyudaController@generarInformesPm')->name('ayuda-generar-informes-pm');
Route::get('generar_informes_lp', 'AyudaController@generarInformesLp')->name('ayuda-generar-informes-lp');
Route::get('generar_informes_us', 'AyudaController@generarInformesUs')->name('ayuda-generar-informes-us');
