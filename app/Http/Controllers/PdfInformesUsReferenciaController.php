<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;
use App\InformesUs;
use App\Ots;
use App\Clientes;
use App\User;
use App\Contratistas;
use App\DetalleUsPaUs;
use App\DetallesUsPaUsReferencias;

class PdfInformesUsReferenciaController extends Controller
{
    public function imprimir($id){ 

      
              
        $detalle_us_pa_us_referencia = DetallesUsPaUsReferencias::find($id);
        $detalle_us_pa_us = DetalleUsPaUs::where('detalle_us_pa_us_referencia_id',$id)->first();
        $informe_us = InformesUs::find($detalle_us_pa_us->informe_us_id);
        $informe = Informe::find($informe_us->informe_id);      
        $ot = Ots:: find($informe->ot_id);
        $cliente = Clientes::find($ot->cliente_id);       
        $evaluador = User::find($informe->firma);       
        $contratista = Contratistas::find($ot->contratista_id);   
      //  dd($detalle_us_pa_us_referencia);
        $pdf = \PDF::loadView('reportes.informes.referencias-us-pa-us',compact('ot',
                                                                'informe_us',                                                              
                                                                'informe',
                                                                'detalle_us_pa_us',
                                                                'detalle_us_pa_us_referencia',
                                                                'cliente',
                                                                'contratista',
                                                                'evaluador'                                                                    
                                                               ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream();
        


    }
}
