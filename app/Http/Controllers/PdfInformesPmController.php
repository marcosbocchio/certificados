<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Informe;
use App\InformesPm;
use App\Ots;
use App\Clientes;
use App\Materiales;
use App\NormaEnsayos;
use App\NormaEvaluaciones;
use App\Documentaciones;
use App\Fuentes;
use App\TipoPeliculas;
use App\DiametrosEspesor;
use App\Tecnicas;
use App\EjecutorEnsayo;
use App\User;
use App\TecnicasGraficos;
use PDF;
use App\OtOperarios;
use App\OtProcedimientosPropios;

class PdfInformesPmController extends Controller
{
    public function imprimir($id){      

        /* header */
      
         $informe = Informe::findOrFail($id);       
         $informe_pm = InformesPm::where('informe_id',$informe->id)->firstOrFail();
         $ot = Ots::findOrFail($informe->ot_id);
         $cliente = Clientes::findOrFail($ot->cliente_id);           
         $material = Materiales::findOrFail($informe->material_id);   
         $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);   
         $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id); 
         $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
         $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);       
         $fuente = Fuentes::find($informe_pm->fuente_id);
         $diametro_espesor = DiametrosEspesor::findOrFail($informe->diametro_espesor_id);
         $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
         $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
         $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
         
      

 
        
 
       //    dd($juntas_posiciones);
        
 
           $pdf = PDF::loadView('reportes.informes.pm',compact('ot',
                                                                'norma_ensayo',
                                                                'norma_evaluacion',
                                                                'procedimiento_inf',                                                               
                                                                'fuente',
                                                                'tipo_pelicula',
                                                                'diametro_espesor',
                                                                'ici',
                                                                'tecnica',
                                                                'ejecutor_ensayo',
                                                                'cliente',
                                                                'informe',
                                                                'informe_ri',
                                                                'material'
                                                                ))->setPaper('a4','portrait')->setWarnings(false);
                                                        
 
           return $pdf->stream(); 
    
     }
}
