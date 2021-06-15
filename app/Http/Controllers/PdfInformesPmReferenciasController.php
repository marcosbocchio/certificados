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
use App\MetodoEnsayos;
use App\FirmaUsuario;

class PdfInformesPmReferenciasController extends Controller
{
    public function imprimir($id){



        $detalle_referencia = DetallesPmReferencias::find($id);
        $detalle = DetallesPm::where('detalle_pm_referencia_id',$id)->first();
        $informe_pm = InformesPm::find($detalle->informe_pm_id);
        $informe = Informe::find($informe_pm->informe_id);
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
        $ot = Ots:: find($informe->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
        $evaluador = User::find($informe->firma);
        $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma,$metodo_ensayo->id);
        $contratista = Contratistas::find($ot->contratista_id);
        $observaciones = $detalle_referencia->descripcion;

        /*  Encabezado */

        $titulo = "PARTÍCULAS MAGNETIZABLES (REFERENCIA)";
        $nro = FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

        $pdf = \PDF::loadView('reportes.informes.referencias-v2',compact('ot','titulo','nro','tipo_reporte','fecha','metodo_ensayo',
                                                                'informe_pm',
                                                                'informe',
                                                                'detalle',
                                                                'detalle_referencia',
                                                                'cliente',
                                                                'contratista',
                                                                'evaluador',
                                                                'observaciones',
                                                                'firma',
                                                               ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream();



    }
}
