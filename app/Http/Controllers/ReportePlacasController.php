<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class ReportePlacasController extends Controller
{

    public function __construct()
    {

        $this->middleware(['role_or_permission:Sistemas|R_placas'],['only' => ['callView']]);


    }

    public function callView(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="Placas";
        return view('placas.placas',compact('user','header_titulo','header_descripcion'));

    }

    public function getPlacasTotal($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta){

        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;
        $obra = $obra == 'null' ? '' : $obra;

        if($fecha_desde == 'null'){
            $fecha_desde =  date('2000-01-01');
         }

        if($fecha_hasta == 'null'){
            $fecha_hasta =  date('2100-01-01');
        }

        $total = DB::select('CALL ReportePlacasTotal(?,?,?,?,?)',array($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta));

        return $total[0]->valor;
    }

    public function getPlacasRepetidasTestigos($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta){

        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;
        $obra = $obra == 'null' ? '' : $obra;

        if($fecha_desde == 'null'){
            $fecha_desde =  date('2000-01-01');
         }

        if($fecha_hasta == 'null'){
            $fecha_hasta =  date('2100-01-01');
        }

        $res = DB::select('CALL ReportePlacasRepetidasTestigos(?,?,?,?,?)',array($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta));

        return $res;

    }

    public function getPlacasRechazadas($cliente_id,$ot_id,$obra,$componente,$fecha_desde,$fecha_hasta){

        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;
        $obra = $obra == 'null' ? '' : $obra;
        $componente = $componente == 'null' ? '' : $componente;

        if($fecha_desde == 'null'){
            $fecha_desde =  date('2000-01-01');
         }

        if($fecha_hasta == 'null'){
            $fecha_hasta =  date('2100-01-01');
        }

        $res = DB::select('CALL ReportePlacasRechazadas(?,?,?,?,?,?)',array($cliente_id,$ot_id,$obra,$componente,$fecha_desde,$fecha_hasta));

        return $res;

    }

}
