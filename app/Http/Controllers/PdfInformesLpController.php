<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Informe;
use App\InformesLp;
use App\Ots;
use App\Clientes;
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
use App\MetodoEnsayos;
use App\DetallesLp;
use App\DetallesLpReferencias;

class PdfInformesLpController extends Controller
{
    public function imprimir($id){

        /* header */

        $informe = Informe::findOrFail($id);
        $numero_repetido = $informe->numero_repetido;
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
         $informe_lp= InformesLp::where('informe_id',$informe->id)->firstOrFail();
         $planta= Plantas::where('id',$informe->planta_id)->first();
         $ot = Ots::findOrFail($informe->ot_id);
         $cliente = Clientes::findOrFail($ot->cliente_id);
         $ot_tipo_soldadura = OtTipoSoldaduras::where('id',$informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();
         $material = Materiales::findOrFail($informe->material_id);
         $material2 = Materiales::find($informe->material2_id);
         $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);
         $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id);
         $diametro_espesor = DiametrosEspesor::findOrFail($informe->diametro_espesor_id);
         $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
         $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);
         $metodo = MetodosTrabajoLp::findOrFail($informe_lp->metodo_trabajo_lp_id);
         $equipo = InternoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
         $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
         $penetrante = TipoLiquidos::findOrFail($informe_lp->penetrante_tipo_liquido_id);
         $penetrante_aplicacion = AplicacionesLp::findOrFail($informe_lp->penetrante_aplicacion_lp_id);
         $revelador = TipoLiquidos::findOrFail($informe_lp->revelador_tipo_liquido_id);
         $revelador_aplicacion = AplicacionesLp::findOrFail($informe_lp->revelador_aplicacion_lp_id);
         $removedor = TipoLiquidos::findOrFail($informe_lp->removedor_tipo_liquido_id);
         $removedor_aplicacion = AplicacionesLp::findOrFail($informe_lp->removedor_aplicacion_lp_id);
         $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
         $iluminacion = Iluminaciones::findOrFail($informe_lp->iluminacion_id);
         $evaluador = User::find($informe->firma);
         $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma,$metodo_ensayo->id);
         $contratista = Contratistas::find($ot->contratista_id);
         $observaciones = $informe->observaciones;

        /*  Encabezado */

        $titulo = "LÍQUIDOS PENETRANTES";
        $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();

        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        $detalles = DetallesLp::with('referencia')
                                ->where('informe_lp_id',$informe_lp->id)
                                ->get();
                                
        $detallesReferencia = DB::table('detalles_lp')
            ->join('detalles_lp_referencias', 'detalles_lp.detalle_lp_referencia_id', '=', 'detalles_lp_referencias.id')
            ->select('detalles_lp_referencias.*')
            ->where('detalles_lp.informe_lp_id', $informe_lp->id)
            ->get();

        $informeEspecial = null;

        obtenerInformeEspecial($informe, $metodo_ensayo, $informeEspecial);

        if($informeEspecial !== null){
            $pdf = PDF::loadView('reportes.informes.lp-v2-ESP',compact('ot','titulo','nro','tipo_reporte','fecha',
                                                                'norma_ensayo',
                                                                'planta',
                                                                'norma_evaluacion',
                                                                'procedimiento_inf',
                                                                'diametro_espesor',
                                                                'equipo',
                                                                'metodo',
                                                                'ejecutor_ensayo',
                                                                'cliente',
                                                                'contratista',
                                                                'informe',
                                                                'informe_lp',
                                                                'ot_tipo_soldadura',
                                                                'material',
                                                                'material2',
                                                                'metodo',
                                                                'penetrante',
                                                                'penetrante_aplicacion',
                                                                'revelador',
                                                                'revelador_aplicacion',
                                                                'removedor',
                                                                'removedor_aplicacion',
                                                                'iluminacion',
                                                                'evaluador',
                                                                'detalles',
                                                                'informe_modelos_3d',
                                                                'observaciones',
                                                                'firma',
                                                                'numero_repetido',
                                                                'informe_solicitado_por',
                                                                'detallesReferencia',
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream();
        }else{

           $pdf = PDF::loadView('reportes.informes.lp-v2',compact('ot','titulo','nro','tipo_reporte','fecha',
                                                                'norma_ensayo',
                                                                'planta',
                                                                'norma_evaluacion',
                                                                'procedimiento_inf',
                                                                'diametro_espesor',
                                                                'equipo',
                                                                'metodo',
                                                                'ejecutor_ensayo',
                                                                'cliente',
                                                                'contratista',
                                                                'informe',
                                                                'informe_lp',
                                                                'ot_tipo_soldadura',
                                                                'material',
                                                                'material2',
                                                                'metodo',
                                                                'penetrante',
                                                                'penetrante_aplicacion',
                                                                'revelador',
                                                                'revelador_aplicacion',
                                                                'removedor',
                                                                'removedor_aplicacion',
                                                                'iluminacion',
                                                                'evaluador',
                                                                'detalles',
                                                                'informe_modelos_3d',
                                                                'observaciones',
                                                                'firma',
                                                                'numero_repetido',
                                                                'informe_solicitado_por',
                                                                ))->setPaper(210, 305,'portrait')->setWarnings(false);


           return $pdf->stream();

     }
    }
}
