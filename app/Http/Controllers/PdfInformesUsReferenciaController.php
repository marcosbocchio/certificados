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
use App\OtTipoSoldaduras;
use App\MetodoEnsayos;
use App\Tecnicas;
use App\FirmaUsuario;

class PdfInformesUsReferenciaController extends Controller
{
    public function imprimir($id){

        $detalle_referencia = DetallesUsPaUsReferencias::find($id);
        $detalle = DetalleUsPaUs::where('detalle_us_pa_us_referencia_id',$id)->first();
        $informe_us = InformesUs::find($detalle->informe_us_id);
        $informe = Informe::find($informe_us->informe_id);
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
        $ot_tipo_soldadura = OtTipoSoldaduras::where('id',$informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();
        $ot = Ots:: find($informe->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
        $evaluador = User::find($informe->firma);
        $firma_general = ($evaluador) ? ($evaluador->path ? $evaluador->path : null) : null;
        $firma_metodo = FirmaUsuario::where('user_id',$informe->firma)->where('metodo_ensayo_id',$metodo_ensayo->id)->first();
        $firma = $firma_metodo ? ($firma_metodo->path ? $firma_metodo->path : null) : $firma_general;
        $contratista = Contratistas::find($ot->contratista_id);
        $contratista = Contratistas::find($ot->contratista_id);
        $observaciones = $detalle_referencia->descripcion;
        $tecnica = Tecnicas::findOrFail($informe->tecnica_id);

        /*  Encabezado */

        $titulo = "INFORME DE ULTRASONIDO (REFERENCIA)";
        $nro = FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

        $pdf = \PDF::loadView('reportes.informes.referencias-v2',compact('ot','titulo','nro','tipo_reporte','fecha','observaciones','metodo_ensayo','tecnica',
                                                                'informe_us',
                                                                'informe',
                                                                'ot_tipo_soldadura',
                                                                'detalle',
                                                                'detalle_referencia',
                                                                'cliente',
                                                                'contratista',
                                                                'evaluador',
                                                                'firma'
                                                               ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream();



    }
}
