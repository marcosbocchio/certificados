<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportePlacasController extends Controller
{
    public function callView(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="Placas";
        return view('placas.placas',compact('user','header_titulo','header_descripcion'));

    }
}
