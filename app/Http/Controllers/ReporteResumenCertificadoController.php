<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class ReporteResumenCertificadoController extends Controller
{

    public function __construct()
    {

        $this->middleware(['role_or_permission:Sistemas|R_placas'],['only' => ['callView']]);


    }

    public function callView(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="Resumen certificado";
        return view('reporte-resumen-certificado.resumen-certificado',compact('user','header_titulo','header_descripcion'));

    }

    public function resumenServiciosPorCertificado($cliente_id,$ot_id,$fecha_desde,$fecha_hasta){
        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;

        if($fecha_desde == 'null'){
            $fecha_desde =  date('2000-01-01');
         }

        if($fecha_hasta == 'null'){
            $fecha_hasta =  date('2100-01-01');
        }
        $page = Input::get('page', 1);
        $paginate = 10;

        DB::select('CALL armadoReporteServicios(?,?,?,?)',array($cliente_id,$ot_id,$fecha_desde,$fecha_hasta));
        $data = DB::select('CALL getResumenServicios()');
        $offSet = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = array_slice($data, $offSet, $paginate, true);
        $data = new \Illuminate\Pagination\LengthAwarePaginator(array_values($itemsForCurrentPage), count($data), $paginate, $page);

        return $data;
    }

}
