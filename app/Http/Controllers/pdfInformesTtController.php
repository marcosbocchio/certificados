<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class pdfInformesTtController extends Controller
{
    public function imprimir($id) {

        $informe = (new \App\Http\Controllers\InformesTtController)->show($id);
        $numero_repetido = $informe->numero_repetido;
        $informe_tt = $informe->informeTt;
        $metodo_ensayo = $informe->metodo_ensayo;
        $planta = $informe->planta;
        $ot = $informe->ot;
        $cliente = $ot->cliente;
        $observaciones = $informe->observaciones;
        $contratista = $ot->contratista;
        $ot_tipo_soldadura = $informe->otTipoSoldadura;
        $evaluador = $informe->firma;
        $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma,$metodo_ensayo['id']);
        $ot_operador = $informe->ejecutorEnsayo;
       // $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);
        $informe_solicitado_por = $informe->solicitado_por;
        $titulo = "TRAMIENTO TERMICO";
        $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$metodo_ensayo['metodo']) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$metodo_ensayo['metodo']) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";
        // dd($informe);

        $pdf = PDF::loadView('reportes.informes.tt-v2',compact('ot',
                                                                'cliente',
                                                                'contratista',
                                                                'titulo',
                                                                'nro',
                                                                'tipo_reporte',
                                                                'fecha',
                                                                'informe',
                                                                'planta',
                                                                'observaciones',
                                                                'firma',
                                                                ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream();
    }


}
