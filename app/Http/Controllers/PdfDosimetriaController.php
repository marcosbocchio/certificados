<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfDosimetriaController extends Controller
{
    public function imprimir($year){

        $fecha = date("Y/m/d H:i:s");
        $resumen = DB::select('CALL DosimetriaResumen(?)',array($year));   
        $Max_Rx_Mensual = (new ParametrosGeneralesController())->show('Max_Rx_Mensual'); 
        $Max_dif_op_rx = (new ParametrosGeneralesController())->show('Max_dif_op_rx');    

        //return $Max_dif_op_rx;

        $pdf = PDF::loadView('reportes.dosimetria.resumen',compact('fecha','year','resumen','Max_Rx_Mensual','Max_dif_op_rx'))->setPaper('a4','landscape')->setWarnings(false);
        return $pdf->stream();
                                                            }
}