<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \stdClass;

class PdfDosimetriaMensualOperadores extends Controller
{
   public function imprimir($year,$month,$operador_ids){

    $fecha = date("Y/m/d H:i:s");
    $resumen =  DB::select('CALL DosimetriaMensualOperadores(?,?,?)',array($year,$month,$operador_ids));
    $operadores = $this->FormatearOperadores($resumen,$operador_ids);
    $pdf = PDF::loadView('reportes.dosimetria.mensual-operadores',compact('fecha','year','month','operadores'))->setPaper('a4','landscape')->setWarnings(false);
    return $pdf->stream();

   }

   public function FormatearOperadores($resumen){

    $users_ids = $this->getOperadorsIdsOrderFilm($resumen);
    $operadores = [];

    foreach ($users_ids as $item_user) {
        foreach ($resumen as $item_resumen) {
            if($item_user == $item_resumen->user_id){
                $obj = new stdClass();
                $obj->name = $item_resumen->name;
                $obj->user_id = $item_resumen->user_id;
                $obj->film = $item_resumen->film;
                $obj->dni = $item_resumen->dni;
                $obj->habilitado_arn_sn = $item_resumen->habilitado_arn_sn;
                $operadores[] = $obj;

                break 1;
            }
        }
    }

    foreach ($operadores as $item_operador) {
        $obj = new stdClass();
        $array_temp = [];
        for ($i=1; $i <= 31; $i++) {
            $microsievert = '';
            foreach ($resumen as $item_resumen) {
                if($item_operador->user_id == $item_resumen->user_id && $i == date('d',strtotime($item_resumen->fecha)) ){
                    $microsievert = $item_resumen->microsievert;
                }
            }
            $array_temp[] = $microsievert;
        }
        $obj->microsievert = $array_temp;
        $item_operador->data = $obj;
    }

    return $operadores;

   }


   public function getOperadorsIdsOrderFilm($resumen){

        $array_temp = [];

        foreach ($resumen as $item) {

            $array_temp[] = $item->user_id;

        }

        $array_temp = array_unique($array_temp);

        return $array_temp;

   }

}
