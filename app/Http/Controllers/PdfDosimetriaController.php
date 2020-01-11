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

       // return $resumen;

        $pdf = PDF::loadView('reportes.dosimetria.resumen',compact('fecha','year','resumen'))->setPaper('a4','landscape')->setWarnings(false);
        return $pdf->stream();
                                                            }
}
