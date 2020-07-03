<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function viewSoldaduras(){

        $user = auth()->user();
        $header_titulo = "Reporte";
        $header_descripcion ="Análisis de rechazo y defectología";      
        return view('soldadores.estadisticas_soldaduras',compact('user','header_titulo','header_descripcion'));        

    }
}
