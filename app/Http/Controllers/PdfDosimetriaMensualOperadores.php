<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfDosimetriaMensualOperadores extends Controller
{
   public function imprimir($year,$month,$operador_ids){

    $resultado =  DB::select('CALL DosimetriaMensualOperadores(?,?)',array($year,$month,$operador_ids));

    $pdf = PDF::loadView('reportes.dosimetria.mensual-operadores',compact('fecha','year','resultado'))->setPaper('a4','landscape')->setWarnings(false);
    return $pdf->stream();

   }
}
