<?php

//estas rutas tienen que estar protegidas
Route::group(['middleware' => 'auth:api'], function()
{

    Route::get('get_datatabla', 'OfflineTablesController@getDataTable');
    Route::get('get_clientes', 'OfflineTablesController@GetClientesImg');
    Route::get('get_documentaciones', 'OfflineTablesController@GetDocumentaciones');
    Route::get('get_id_to_delete', 'OfflineTablesController@GetDeletedId');
    Route::post('upload_img', 'OfflineInformesController@saveReferenciaImg');
    Route::post('OTS_from_local', 'OfflineInformesController@storeTiposSoldaduras');
    Route::post('upload_one_img', 'OfflineInformesController@saveUsImgFiles');
    Route::post('soldadores_from_local', 'OfflineInformesController@storeSoldadores');
    Route::get('get_Img', 'OfflineTablesController@getImg');

});

//Esta ruta va sin middleware
Route::get('get_Users_With_Dates', 'OfflineTablesController@getUsersWithDates');
Route::post('login', 'Auth\LoginController@apiLogin');
Route::get('get_today', 'OfflineInformesController@getToday');
