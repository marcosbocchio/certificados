<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use PDF;

class PdfDosimetriaPeriodosController extends Controller
{
    public function __construct()
    {

        $this->middleware(['role_or_permission:Super Admin|D_reporte_alta_baja']);  

    }

    public function imprimir(){

        $fecha = date("Y/m/d H:i:s");     
        $operadores = User::whereNull('cliente_id')
                                        ->whereNotNull('film')
                                        ->with('periodos')
                                        ->orderBy('film','asc')
                                        ->get();   
     
        $pdf = PDF::loadView('reportes.dosimetria.periodos',compact('fecha','operadores'))->setPaper('a4','landscape')->setWarnings(false);
        return $pdf->stream();

       }
}
