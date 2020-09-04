<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CosturasController extends Controller
{
    public function callView(){

        $user = auth()->user();
        $header_titulo = "Reporte";
        $header_descripcion ="Seguimiento de costuras / Plano-isométrico";
        return view('costuras.costuras',compact('user','header_titulo','header_descripcion'));

    }
}
