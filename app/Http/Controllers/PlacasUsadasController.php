<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlacasUsadasController extends Controller
{
    public function callView(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="Certificados";
        return view('reporte-placas.placa',compact('user','header_titulo','header_descripcion'));

    }

    public function getInformesRI($parte_id)
    {
        $informes = DB::select('CALL GetInformesRI(?)', [$parte_id]);
        return response()->json($informes);
    }

}
