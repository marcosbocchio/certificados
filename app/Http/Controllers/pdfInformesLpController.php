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
use App\Iluminaciones;
use App\InternoEquipos;
use App\Documentaciones;
use App\Fuentes;
use App\DiametrosEspesor;
use App\MetodosTrabajoLp;
use App\User;


class PdfInformesLpController extends Controller
{
    public function imprimir($id){      

        /* header */
      
         $informe = Informe::findOrFail($id);       
         $informe_lp= InformesLp::where('informe_id',$informe->id)->firstOrFail();        
         $ot = Ots::findOrFail($informe->ot_id);
         $cliente = Clientes::findOrFail($ot->cliente_id);           
         $material = Materiales::findOrFail($informe->material_id);   
         $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);   
         $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id); 
         $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
         $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);    
         // $fuente = Fuentes::find($informe_lp->fuente_id);
         $diametro_espesor = DiametrosEspesor::findOrFail($informe->diametro_espesor_id);       
         $equipo = InternoEquipos::findOrFail($informe->interno_equipo_id)->with('equipo')->first(); 
         
         $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
         $metodo = MetodosTrabajoLp::findOrFail($informe_lp->metodo_trabajo_lp_id);
         $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
         
         $iluminacion = Iluminaciones::findOrFail($informe_lp->iluminacion_id);
        
         
       // dd($desmagnetizacion_sn);
         $detalles =  DB::select('SELECT 
                                detalles_lp.pieza as pieza,
                                detalles_lp.numero as numero,
                                detalles_lp.detalle as detalle,
                                detalles_lp.aceptable_sn as aceptable_sn,
                                detalles_lp_referencias.id as referencia_id
                                FROM
                                detalles_lp
                                INNER JOIN informes_lp ON detalles_lp.informe_lp_id = informes_lp.id
                                LEFT JOIN detalles_lp_referencias ON detalles_lp.detalle_lp_referencia_id = detalles_lp_referencias.id
                                WHERE
                                informes_lp.id =:id',['id' => $informe_lp->id ]);
        
        
 
           $pdf = PDF::loadView('reportes.informes.lp',compact('ot',
                                                                'norma_ensayo',
                                                                'norma_evaluacion',
                                                                'procedimiento_inf',                                                               
                                                                'fuente',
                                                                'tipo_pelicula',
                                                                'diametro_espesor',
                                                                'ici',                                                                
                                                                'equipo',
                                                                'ejecutor_ensayo',
                                                                'cliente',
                                                                'informe',
                                                                'informe_lp',
                                                                'material',                                                            
                                                                'metodo',                                                           
                                                                'iluminacion',
                                                                'detalles'
                                                                ))->setPaper('a4','portrait')->setWarnings(false);
                                                        
 
           return $pdf->stream(); 
    
     }
}
