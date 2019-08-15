<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Informe;
use App\InformesRi;
use App\Ots;
use App\Clientes;
use App\Materiales;
use App\NormaEnsayos;
use App\NormaEvaluaciones;
use App\Documentaciones;
use App\Equipos;
use App\Fuentes;
use App\TipoPeliculas;
use App\DiametrosEspesor;
use App\Icis;
use App\Tecnicas;
use App\EjecutorEnsayo;
use App\User;
use App\TecnicasGraficos;
use PDF;
use App\Juntas;
use App\Soldadores;
use App\Posicion;
use App\PasadasPosicion;
use App\DefectosPasadasPosicion;

class PdfInformesRiController extends Controller
{

    public function inprimir($id){      

       /* header */

        $informe = Informe::findOrFail($id);       
        $informe_ri = InformesRi::where('informe_id',$informe->id)->firstOrFail();
        $ot = Ots::findOrFail($informe->ot_id);
        $cliente = Clientes::findOrFail($ot->cliente_id);
        $material = Materiales::findOrFail($informe->material_id);   
        $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);   
        $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id); 
        $procedimiento_inf = Documentaciones::findOrFail($informe->procedimiento_informe_id);
        $equipo = Equipos::findOrFail($informe->equipo_id);
        $fuente = Fuentes::find($informe_ri->fuente_id);
        $tipo_pelicula = TipoPeliculas::findOrFail($informe_ri->tipo_pelicula_id);     
        $diametro_espesor = DiametrosEspesor::findOrFail($informe->diametro_espesor_id);
        $ici = Icis::findOrFail($informe_ri->ici_id);
        $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
        $ejecutor_ensayo = User::findOrFail($informe->ejecutor_ensayo_id);
        $tecnicas_grafico = TecnicasGraficos::findOrFail($informe_ri->tecnicas_grafico_id);
        
      //  dd($informe_ri);

        if ($informe_ri->gasoducto_sn){

          $juntas_posiciones = DB::select('CALL InformeRiGasoductoJuntaPosicion(?)',array($informe_ri->id));        
          $pasadas_posiciones = DB::select('CALL InformeRiGasoductoPasadasPosicion(?)',array($informe_ri->id));
          $defectos_posiciones = DB::select('CALL InformeRiGasoductoDefectosPasadasPosicion(?)',array($informe_ri->id));   
        //  dd($juntas_posiciones);
       

          $pdf = PDF::loadView('reportes.informes.ri-gasoducto',compact('ot',
          'norma_ensayo',
          'norma_evaluacion',
          'procedimiento_inf',
          'equipo',
          'fuente',
          'tipo_pelicula',
          'diametro_espesor',
          'ici',
          'tecnica',
          'ejecutor_ensayo',
          'cliente',
          'informe',
          'informe_ri',
          'material',
          'tecnicas_grafico',
          'juntas_posiciones',
          'pasadas_posiciones',
          'defectos_posiciones'))->setPaper('a4','landscape')->setWarnings(false);


          return $pdf->stream();

        }else

        {
        
      /* Detalle */ 

          $juntas_posiciones = DB::select('CALL InformeRiPlantaJuntaPosicion(?)',array($informe_ri->id));
          $defectos_posiciones = DB::select('CALL InformeRiPlantaDefectosPasadaPosicion(?)',array($informe_ri->id));                     
                      
      

          $pdf = PDF::loadView('reportes.informes.ri-planta',compact('ot',
                                                              'norma_ensayo',
                                                              'norma_evaluacion',
                                                              'procedimiento_inf',
                                                              'equipo',
                                                              'fuente',
                                                              'tipo_pelicula',
                                                              'diametro_espesor',
                                                              'ici',
                                                              'tecnica',
                                                              'ejecutor_ensayo',
                                                              'cliente',
                                                              'informe',
                                                              'informe_ri',
                                                              'material',
                                                              'tecnicas_grafico',
                                                              'juntas_posiciones',
                                                              'defectos_posiciones'))->setWarnings(false);

                                                    
          return $pdf->stream();

      }
    }
}
