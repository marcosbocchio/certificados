<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class ReporteServiciosController extends Controller
{

    public function __construct()
    {

        $this->middleware(['role_or_permission:Sistemas|R_placas'],['only' => ['callView']]);


    }

    public function callView(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="Servicios";
        return view('reporte-servicios.servicios',compact('user','header_titulo','header_descripcion'));

    }

}
