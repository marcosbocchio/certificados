<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;
use App\InformesLp;
use App\Ots;
use App\Clientes;
use App\DetallesLpReferencias;
use App\DetallesLp;

class PdfInformesLpReferenciasController extends Controller
{
    public function imprimir($id){ 

      
              
        $detalle_lp_referencia = DetallesLpReferencias::find($id);
        $detalle_lp = DetallesLp::where('detalle_lp_referencia_id',$id)->first();
        $informe_lp = InformesLp::find($detalle_lp->informe_lp_id);
        $informe = Informe::find($informe_lp->informe_id);      
        $ot = Ots:: find($informe->ot_id);
        $cliente = Clientes::find($ot->cliente_id);         
        
    //  dd($cliente);

        $pdf = \PDF::loadView('reportes.informes.referencias-lp',compact('ot',
                                                                'informe_lp',                                                              
                                                                'informe',
                                                                'detalle_lp',
                                                                'detalle_lp_referencia',
                                                                'cliente'                                                              
                                                               ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream();
        


    }
}
