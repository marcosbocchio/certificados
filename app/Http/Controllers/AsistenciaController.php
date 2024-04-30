<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function __construct()
    {

     $this->middleware(['role_or_permission:Sistemas|A_asistencia_acceder'],['only' => ['callViewTotalStock']]);

    }

    public function callView()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "Control Asistencia"; // Título para la página
        $header_descripcion = "Tabla"; // Descripción o subtítulo para la página
    
        // Retornar la vista de stock, pasando los datos necesarios
        return view('control-asistencia.asistencia-table', compact('user', 'header_titulo', 'header_descripcion'));
    }
    public function nuevo()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "Control Asistencia"; // Título para la página
        $header_descripcion = "Tabla"; // Descripción o subtítulo para la página
    
        // Retornar la vista de stock, pasando los datos necesarios
        return view('control-asistencia.asistencia-nuevo', compact('user', 'header_titulo', 'header_descripcion'));
    }
}
