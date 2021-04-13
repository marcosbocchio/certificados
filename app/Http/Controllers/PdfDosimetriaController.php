<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfDosimetriaController extends Controller
{
    public function imprimir($year,$str_list_of_ids = '0',$resumen_cliente_sn,$str_list_of_months){

        $fecha = date("Y/m/d H:i:s");
        $resumen = DB::select('CALL DosimetriaResumen(?,?)',array($year,$str_list_of_ids));
        $Max_Rx_Mensual = (new ParametrosGeneralesController())->show('Max_Rx_Mensual');
        $Max_dif_op_rx = (new ParametrosGeneralesController())->show('Max_dif_op_rx');
        $months = explode(",",$str_list_of_months);
        $desvio =  DB::select('CALL DosimetriaDesvioResumen(?,?,?)',array($year,$Max_Rx_Mensual->valor,$str_list_of_ids))[0]->value;
        // dd($desvio);
        $pdf = PDF::loadView('reportes.dosimetria.resumen',compact('fecha','year','resumen','resumen_cliente_sn','months','Max_Rx_Mensual','Max_dif_op_rx','desvio'))->setPaper('a4','landscape')->setWarnings(false);

        return $pdf->stream();
      }
}
