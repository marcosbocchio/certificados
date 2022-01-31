<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Informe;
use App\InformesDz;
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
use App\DetallesDz;
use App\EstadosSuperficies;
use App\UnidadesMedicionDureza;
use App\DetallesDzReferencias;
use App\OtUsuariosClientes;


class PdfInformesDzController extends Controller
{
    public function imprimir($id){

        /* header */

        $informe = Informe::findOrFail($id);
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
         $informe_dz= InformesDz::where('informe_id',$informe->id)->firstOrFail();
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
         $informe_interno_equipo = internoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
         $informe_estado_superficie = EstadosSuperficies::where('id',$informe_dz->estado_superficie_id)->first();
         $informe_unidad_medicion_dureza = UnidadesMedicionDureza::where('id',$informe_dz->unidad_medicion_dureza_id)->first();
         $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
         /*  Encabezado */
        $titulo = "MEDICIÓN DE DUREZA";
        $nro = FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);
        $detalles = DetallesDz::join('soldadores','soldadores.id','detalles_dz.soldador_id')
                                ->join('diametros_espesor','diametros_espesor.id','detalles_dz.diametro_espesor_id')
                                ->where('detalles_dz.informe_dz_id',$informe_dz->id)
                                ->orderBy('detalles_dz.id','asc')
                                ->get();
           $pdf = PDF::loadView('reportes.informes.dz',compact('ot','titulo','nro','tipo_reporte','fecha',
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
                                                                'informe_dz',
                                                                'ot_tipo_soldadura',
                                                                'material',
                                                                'material2',
                                                                'evaluador',
                                                                'informe_modelos_3d',
                                                                'observaciones',
                                                                'firma',
                                                                'detalles',
                                                                'informe_interno_equipo',
                                                                'informe_estado_superficie',
                                                                'informe_unidad_medicion_dureza',
                                                                'informe_solicitado_por',
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream();

     }
}
