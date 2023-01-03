<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Informe;
use App\InformesCv;
use App\Ots;
use App\Clientes;
use Illuminate\Support\Facades\Log;
use App\Plantas;
use App\Materiales;
use App\NormaEnsayos;
use App\NormaEvaluaciones;
use App\OtOperarios;
use App\OtProcedimientosPropios;
use App\InternoEquipos;
use App\Documentaciones;
use App\Iluminaciones;
use App\DiametrosEspesor;
use App\Contratistas;
use App\Fuentes;
use App\MetodosTrabajoLp;
use App\TipoLiquidos;
use App\AplicacionesLp;
use App\User;
use App\OtTipoSoldaduras;
use App\Campanas;
use App\Bombas;
use App\MetodoEnsayos;
use App\DetallesCv;

class PdfInformesCvController extends Controller
{
    public function imprimir($id){

        /* header */

        $informe = Informe::findOrFail($id);
        $numero_repetido = $informe->numero_repetido;
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
         $informe_cv= InformesCv::where('informe_id',$informe->id)->firstOrFail();
         $planta= Plantas::where('id',$informe->planta_id)->first();
         $ot = Ots::findOrFail($informe->ot_id);
         $campana= Campanas::findOrFail($informe_cv->campana_id);
         $bomba= Bombas::findOrFail($informe_cv->bomba_id);
         $cliente = Clientes::findOrFail($ot->cliente_id);
         $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
         $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);
         $ot_tipo_soldadura = OtTipoSoldaduras::where('id',$informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();
         $material = Materiales::findOrFail($informe->material_id);
         $material2 = Materiales::find($informe->material2_id);
         $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);
         $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id);
         $equipo = InternoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
         $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
         $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
         $evaluador = User::find($informe->firma);
         $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma,$metodo_ensayo->id);
         $contratista = Contratistas::find($ot->contratista_id);
         $observaciones = $informe->observaciones;
         $aplicacion = AplicacionesLp::findOrFail($informe_cv->aplicacion_id);

        /*  Encabezado */
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();

        $titulo = "CAMPANA DE VACÍO";
        $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        $detalles = DetallesCv::join('diametros_espesor','diametros_espesor.id','=','detalles_cv.diametro_id')
                                ->join('soldadores','soldadores.id','detalles_cv.soldador_id')
                                ->where('informe_cv_id',$informe_cv->id)
                                ->get();
           $pdf = PDF::loadView('reportes.informes.cv',compact('ot','titulo','nro','tipo_reporte','fecha',
                                                                'norma_ensayo',
                                                                'planta',
                                                                'norma_evaluacion',
                                                                'equipo',
                                                                'metodo_ensayo',
                                                                'ejecutor_ensayo',
                                                                'cliente',
                                                                'contratista',
                                                                'informe',
                                                                'ot_procedimiento_propio',
                                                                'procedimiento_inf',
                                                                'informe_cv',
                                                                'ot_tipo_soldadura',
                                                                'material',
                                                                'material2',
                                                                'campana',
                                                                'aplicacion',
                                                                'bomba',
                                                                'evaluador',
                                                                'detalles',
                                                                'informe_modelos_3d',
                                                                'observaciones',
                                                                'numero_repetido',
                                                                'informe_solicitado_por',
                                                                'firma',
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream();

     }
}
