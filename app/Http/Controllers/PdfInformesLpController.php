<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Informe;
use App\InformesLp;
use App\Ots;
use App\Clientes;
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

class PdfInformesLpController extends Controller
{
    public function imprimir($id){

        /* header */

         $informe = Informe::findOrFail($id);
         $informe_lp= InformesLp::where('informe_id',$informe->id)->firstOrFail();
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
         $contratista = Contratistas::find($ot->contratista_id);
         $observaciones = $informe->observaciones;

        /*  Encabezado */

        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
        $titulo = "LÍQUIDOS PENETRANTES";
        $nro = FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo);
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

       // dd($evaluador);
       //  dd($equipo);
         $detalles =  DB::select('SELECT
                                detalles_lp.pieza as pieza,
                                detalles_lp.cm as cm,
                                detalles_lp.detalle as detalle,
                                detalles_lp.aceptable_sn as aceptable_sn,
                                detalles_lp_referencias.id as referencia_id
                                FROM
                                detalles_lp
                                INNER JOIN informes_lp ON detalles_lp.informe_lp_id = informes_lp.id
                                LEFT JOIN detalles_lp_referencias ON detalles_lp.detalle_lp_referencia_id = detalles_lp_referencias.id
                                WHERE
                                informes_lp.id =:id',['id' => $informe_lp->id ]);


           $pdf = PDF::loadView('reportes.informes.lp-v2',compact('ot','titulo','nro','tipo_reporte','fecha',
                                                                'norma_ensayo',
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
                                                                'observaciones'
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream();

     }
}
