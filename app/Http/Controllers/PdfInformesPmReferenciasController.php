<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;
use App\InformesPm;
use App\Ots;
use App\Clientes;
use App\DetallesPmReferencias;
use App\DetallesPm;
use App\User;
use App\Contratistas;

class PdfInformesPmReferenciasController extends Controller
{
    public function imprimir($id){ 

      
              
        $detalle_pm_referencia = DetallesPmReferencias::find($id);
        $detalle_pm = DetallesPm::where('detalle_pm_referencia_id',$id)->first();
        $informe_pm = InformesPm::find($detalle_pm->informe_pm_id);
        $informe = Informe::find($informe_pm->informe_id);      
        $ot = Ots:: find($informe->ot_id);
        $cliente = Clientes::find($ot->cliente_id);       
        $evaluador = User::find($informe->firma);       
        $contratista = Contratistas::find($ot->contratista_id);
    //  dd($cliente);

        $pdf = \PDF::loadView('reportes.informes.referencias-pm',compact('ot',
                                                                'informe_pm',                                                              
                                                                'informe',
                                                                'detalle_pm',
                                                                'detalle_pm_referencia',
                                                                'cliente',
                                                                'contratista',
                                                                'evaluador'                                                                    
                                                               ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream();
        


    }
}
