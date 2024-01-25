<?php

namespace App\Http\Controllers;

use PDF;
use App\helpers;
use App\Informe;
use App\InformesUs;
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
use App\DiametrosEspesor;
use App\Contratistas;
use App\Tecnicas;
use App\EstadosSuperficies;
use App\CalibracionesUs;
use App\User;
use App\OtTipoSoldaduras;
use App\AgenteAcoplamientos;
use App\MetodoEnsayos;
use App\InformesUsMe;
use App\Generatrices;
use App\DetalleUsPaUs;

class PdfInformesUsController extends Controller
{

    public function imprimir($id){

        /* header */

         $informe = Informe::findOrFail($id);
         $numero_repetido = $informe->numero_repetido;

         $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
         $informe_us = InformesUs::where('informe_id',$informe->id)->firstOrFail();
         $planta= Plantas::where('id',$informe->planta_id)->first();
         $ot = Ots::findOrFail($informe->ot_id);
         $cliente = Clientes::findOrFail($ot->cliente_id);
         $ot_tipo_soldadura = OtTipoSoldaduras::where('id',$informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();
         $material = Materiales::findOrFail($informe->material_id);
         $material2 = Materiales::find($informe->material2_id);
         $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);
         $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id);
         $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
         $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);
         $diametro_espesor = $informe->diametro_espesor_id ? DiametrosEspesor::findOrFail($informe->diametro_espesor_id) : null;
         $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
         $interno_equipo =InternoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
         $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
         $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
         $evaluador = User::find($informe->firma);
         $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma,$metodo_ensayo->id);
         $contratista = Contratistas::find($ot->contratista_id);
         $estado_superficie = EstadosSuperficies::find($informe_us->estado_superficie_id);
         $agente_acoplamiento = AgenteAcoplamientos::find($informe_us->agente_acoplamiento_id);
         $calibraciones_us = CalibracionesUs::where('informe_us_id',$informe_us->id)->with('Palpador')->get();
         $observaciones = $informe->observaciones;
         $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);
         $generatrices = Generatrices::all();
         $informes_us_me = (new \App\Http\Controllers\InformesUsController)->getTabla_me($informe_us->id);
         $indicaciones_us_pa = DetalleUsPaUs::where('informe_us_id',$informe_us->id)->get();

         $detalles = DetalleUsPaUs::with('referencia')
                    ->where('informe_us_id',$informe_us->id)
                    ->get();
        /*  Encabezado */
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();

        $titulo = "INFORME DE ULTRASONIDO"."     " ." (" . mb_strtoupper($tecnica->descripcion,"UTF-8") . ")";
        $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$tecnica->codigo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$tecnica->codigo) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";
        
        $medicionesAgrupadas = agruparPorAccesorios($informes_us_me);
 
        $pdf = PDF::loadView('reportes.informes.us-v2',compact('ot','titulo','nro','tipo_reporte','fecha',
                                                                'norma_ensayo',
                                                                'planta',
                                                                'norma_evaluacion',
                                                                'procedimiento_inf',
                                                                'ot_tipo_soldadura',
                                                                'diametro_espesor',
                                                                'tecnica',
                                                                'interno_equipo',
                                                                'ejecutor_ensayo',
                                                                'cliente',
                                                                'contratista',
                                                                'informe',
                                                                'informe_us',
                                                                'material',
                                                                'material2',
                                                                'estado_superficie',
                                                                'agente_acoplamiento',
                                                                'calibraciones_us',
                                                                'evaluador','observaciones',
                                                                'firma',
                                                                'informe_modelos_3d',
                                                                'generatrices',
                                                                'informes_us_me',
                                                                'indicaciones_us_pa',
                                                                'numero_repetido',
                                                                'detalles',
                                                                'informe_solicitado_por',
                                                                'medicionesAgrupadas',
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream();

     }
}
