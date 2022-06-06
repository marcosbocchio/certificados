<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class ReporteCertificadosPartesController extends Controller
{

    public function __construct()
    {

        $this->middleware(['role_or_permission:Sistemas|R_certificados_partes'],['only' => ['callView']]);


    }

     public function callView(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="Certificados";
        return view('certificados-partes.certificados-partes',compact('user','header_titulo','header_descripcion'));

    }
    public function getPartes($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta){

        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;
        $obra = $obra == 'null' ? '' : $obra;

        if($fecha_desde == 'null'){
            $fecha_desde =  date('2000-01-01');
         }

        if($fecha_hasta == 'null'){
            $fecha_hasta =  date('2100-01-01');
        }
        $obra = str_replace('--','/',$obra);


        $res = DB::select('CALL getPartes(?,?,?,?,?)',array($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta));
        return $res;

    }

    public function getCertificados($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta){

        $cliente_id = $cliente_id == 'null' ? 0 : $cliente_id;
        $ot_id = $ot_id == 'null' ? 0 : $ot_id;
        $obra = $obra == 'null' ? '' : $obra;

        if($fecha_desde == 'null'){
            $fecha_desde =  date('2000-01-01');
         }

        if($fecha_hasta == 'null'){
            $fecha_hasta =  date('2100-01-01');
        }
        $obra = str_replace('--','/',$obra);


        $res = DB::select('CALL getCertificados(?,?,?,?,?)',array($cliente_id,$ot_id,$obra,$fecha_desde,$fecha_hasta));
        return $res;

    }


}
