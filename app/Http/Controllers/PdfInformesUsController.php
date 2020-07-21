<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Informe;
use App\InformesUs;
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
use App\Tecnicas;
use App\EstadosSuperficies;
use App\CalibracionesUs;
use App\User;
use App\OtTipoSoldaduras;
use App\AgenteAcoplamientos;
use App\MetodoEnsayos;

class PdfInformesUsController extends Controller
{

    public function imprimir($id){      

        /* header */
      
         $informe = Informe::findOrFail($id);       
         $informe_us = InformesUs::where('informe_id',$informe->id)->firstOrFail();
         $ot = Ots::findOrFail($informe->ot_id);
         $cliente = Clientes::findOrFail($ot->cliente_id);        
         $ot_tipo_soldadura = OtTipoSoldaduras::where('id',$informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();
         $material = Materiales::findOrFail($informe->material_id);   
         $material_accesorio = Materiales::find($informe->material_accesorio_id);
         $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);   
         $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id); 
         $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
         $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);       
         $diametro_espesor = DiametrosEspesor::findOrFail($informe->diametro_espesor_id);
         $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
         $interno_equipo = InternoEquipos::findOrFail($informe->interno_equipo_id)->with('equipo')->first(); 
         $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
         $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
         $evaluador = User::find($informe->firma);
         $contratista = Contratistas::find($ot->contratista_id);
         $estado_superficie = EstadosSuperficies::find($informe_us->estado_superficie_id);
         $agente_acoplamiento = AgenteAcoplamientos::find($informe_us->agente_acoplamiento_id);
         $calibraciones_us = CalibracionesUs::where('informe_us_id',$informe_us->id)->with('Palpador')->get();
         $observaciones = $informe->observaciones;   

        /*  Encabezado */

        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);  
        $titulo = "INFORME DE ULTRASONIDO"." (" . mb_strtoupper($tecnica->descripcion,"UTF-8") . ")";        
        $nro = FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo);
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

        //  dd($calibraciones_us);
        $pdf = PDF::loadView('reportes.informes.us-v2',compact('ot','titulo','nro','tipo_reporte','fecha',
                                                                'norma_ensayo',
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
                                                                'material_accesorio',
                                                                'estado_superficie',
                                                                'agente_acoplamiento',
                                                                'calibraciones_us',
                                                                'evaluador','observaciones'
                                                        
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream(); 
    
     }
}
