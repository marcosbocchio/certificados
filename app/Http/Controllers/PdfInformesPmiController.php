<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Informe;
use App\InformesPmi;
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
use App\User;
use App\OtTipoSoldaduras;
use App\MetodoEnsayos;
use App\DetallesPmi;

class PdfInformesPmiController extends Controller
{
    public function imprimir($id){

        /* header */

        $informe = Informe::findOrFail($id);
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
         $informe_pmi= InformesPmi::where('informe_id',$informe->id)->firstOrFail();
         $planta= Plantas::where('id',$informe->planta_id)->first();
         $ot = Ots::findOrFail($informe->ot_id);
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

        /*  Encabezado */
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
        Log::debug($informe_pmi->path);
        $titulo = "IDENTIFICACIÓN POSITIVA DE MATERIALES";
        $nro = FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        $detalles = DetallesPmi::join('materiales','materiales.id','detalles_pmi.material_id')
                                 ->where('informe_pmi_id',$informe_pmi->id)
                                ->get();
           $pdf = PDF::loadView('reportes.informes.pmi',compact('ot','titulo','nro','tipo_reporte','fecha',
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
                                                                'informe_pmi',
                                                                'ot_tipo_soldadura',
                                                                'material',
                                                                'material2',
                                                                'evaluador',
                                                                'detalles',
                                                                'informe_modelos_3d',
                                                                'observaciones',
                                                                'informe_solicitado_por',
                                                                'firma',
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream();

     }

     public function getDetalle($id){

        $informe_detalles = DB::table('detalles_pmi')
                               ->where('detalles_pmi.informe_pmi_id',$id)
                               ->selectRaw('detalles_pmi.muestra as muestra,
                                          detalles_pmi.pieza as pieza,
                                          detalles_pmi.material_id as material_id')
                                ->orderBy('detalles_pmi.id','asc')
                                ->get();

        $this->addObjectMaterial($informe_detalles);
        return $informe_detalles;
    }
}
