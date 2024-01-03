<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\helpers;
use App\Informe;
use App\InformesRi;
use App\Plantas;
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
use App\InternoEquipos;
use App\InternoFuentes;
use App\Icis;
use App\Tecnicas;
use App\EjecutorEnsayo;
use App\User;
use App\TecnicasGraficos;
use PDF;
use App\Juntas;
use App\Tramos;
use App\Soldadores;
use Illuminate\Support\Facades\Log;
use App\Posicion;
use App\PasadasPosicion;
use App\DefectosPasadasPosicion;
use App\OtOperarios;
use App\OtProcedimientosPropios;
use App\Contratistas;
use App\OtTipoSoldaduras;
use App\MetodoEnsayos;
use App\FirmaUsuario;
use App\InformesRiElementosView;
use App\DefectosEsp;

class PdfInformesRiController extends Controller
{

    public function imprimir($id,$informeEspecial = null){
        /* header */
        $informe = Informe::findOrFail($id);
        $numero_repetido = $informe->numero_repetido;
        $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
        $informe_ri = InformesRi::where('informe_id',$informe->id)->firstOrFail();
        $planta = Plantas::where('id',$informe->planta_id)->first();
        $ot = Ots::findOrFail($informe->ot_id);
        $cliente = Clientes::findOrFail($ot->cliente_id);

        $ot_tipo_soldadura = OtTipoSoldaduras::where('id',$informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();

        $material = Materiales::findOrFail($informe->material_id);
        $material2 = Materiales::find($informe->material2_id);
        $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);
        $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id);
        $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
        $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);
        $interno_equipo = InternoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
        $interno_fuente = InternoFuentes::where('id',$informe_ri->interno_fuente_id)->first();
        $actividad = $interno_fuente ? curie($interno_fuente->id,$informe->fecha) : '';
        $tipo_pelicula = TipoPeliculas::findOrFail($informe_ri->tipo_pelicula_id);
        $diametro_espesor = $informe->diametro_espesor_id ? DiametrosEspesor::findOrFail($informe->diametro_espesor_id) : null;
        $ici = Icis::findOrFail($informe_ri->ici_id);
        $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
        $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
        $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
        $tecnicas_grafico = TecnicasGraficos::findOrFail($informe_ri->tecnicas_grafico_id);
        $evaluador = User::find($informe->firma);
        $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma,$metodo_ensayo->id);
        $contratista = Contratistas::find($ot->contratista_id);
        $observaciones = $informe->observaciones;
        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
        

        $informeEspecial = null;

        obtenerInformeEspecial($informe, $metodo_ensayo, $informeEspecial);

/*______________________________________________________________________________________________________________________________________________________________*/
/*______________________________________________________________________________________________________________________________________________________________*/

        if($informeEspecial !== null){
        /*______________ Encabezado ______________*/

          $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
          $titulo = "RADIOGRAFIA INDUSTRIAL v2";
          $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
          $nroAESA= FormatearNumeroConCeros($informe->numero,5);
          $fecha = date('d-m-Y', strtotime($informe->fecha));
          $tipo_reporte = "INFORME N°";

        /*______________ Fin encabezado ______________ */


          $estado = null;

          if($informe_ri->perfil_sn){
            $estado = 'perfil';
          }else if($informe_ri->gasoducto_sn){
            $estado = 'gasoducto';
          }else{
            
        /*______________ Detalle ______________*/
          
          $juntas_posiciones = DB::select('CALL InformeRiPlantaJuntaPosicion(?)',array($informe_ri->id));
          $juntas_posiciones_procesos = DB::select('CALL juntas_posiciones_procesos(?)', array($informe_ri->id));
          $defectos_posiciones = DB::select('CALL InformeRiPlantaDefectosPasadaPosicion(?)',array($informe_ri->id));
          
          
          
          $pdf = PDF::loadView('reportes.informes.ri-planta-especial',compact('titulo','nro','tipo_reporte','fecha',
                                                              'ot',
                                                              'norma_ensayo',
                                                              'planta',
                                                              'norma_evaluacion',
                                                              'procedimiento_inf',
                                                              'ot_tipo_soldadura',
                                                              'interno_equipo',
                                                              'actividad',
                                                              'interno_fuente',
                                                              'tipo_pelicula',
                                                              'diametro_espesor',
                                                              'ici',
                                                              'tecnica',
                                                              'ejecutor_ensayo',
                                                              'cliente',
                                                              'contratista',
                                                              'informe',
                                                              'informe_ri',
                                                              'material',
                                                              'material2',
                                                              'tecnicas_grafico',
                                                              'juntas_posiciones',
                                                              'defectos_posiciones',
                                                              'evaluador',
                                                              'informe_modelos_3d',
                                                              'firma',
                                                              'numero_repetido',
                                                              'informe_solicitado_por',
                                                              'nroAESA',
                                                              'juntas_posiciones_procesos',
                                                              'observaciones'))->setPaper('a4','portrait')->setWarnings(false);


          return $pdf->stream();
          }
        }
/*______________________________________________________________________________________________________________________________________________________________*/
/*______________________________________________________________________________________________________________________________________________________________*/


        if ($informe_ri->perfil_sn){
          /*  Encabezado */

          $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
          $titulo = "RADIOGRAFIA INDUSTRIAL";
          $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
          $fecha = date('d-m-Y', strtotime($informe->fecha));
          $tipo_reporte = "INFORME N°";

          /* Fin encabezado */

            $tamaño_bola = '25,4 mm';
            $detalles2 = (new \App\Http\Controllers\InformesRiController)->getTramos($informe_ri->id);
            $detalles = Tramos::with('referencia')
                                ->where('informes_ri_id',$informe_ri->id)
                                ->get();
            Log::debug($detalles);

            $pdf = PDF::loadView('reportes.informes.ri-perfiles-v2',compact('titulo','nro','tipo_reporte','fecha',
                                                                        'ot',
                                                                        'norma_ensayo',
                                                                        'planta',
                                                                        'norma_evaluacion',
                                                                        'procedimiento_inf',
                                                                        'ot_tipo_soldadura',
                                                                        'interno_equipo',
                                                                        'actividad',
                                                                        'interno_fuente',
                                                                        'tipo_pelicula',
                                                                        'diametro_espesor',
                                                                        'ici',
                                                                        'tecnica',
                                                                        'ejecutor_ensayo',
                                                                        'cliente',
                                                                        'contratista',
                                                                        'informe',
                                                                        'informe_ri',
                                                                        'material',
                                                                        'material2',
                                                                        'tecnicas_grafico',
                                                                        'detalles',
                                                                        'tamaño_bola',
                                                                        'evaluador',
                                                                        'informe_modelos_3d',
                                                                        'firma',
                                                                        'numero_repetido',
                                                                        'informe_solicitado_por',
                                                                        'observaciones'))->setPaper('a4','portrait')->setWarnings(false);


            return $pdf->stream();

        }
        if ($informe_ri->gasoducto_sn){
          /*  Encabezado */

          $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
          $titulo = "RADIOGRAFIA INDUSTRIAL";
          $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
          $fecha = date('d-m-Y', strtotime($informe->fecha));
          $tipo_reporte = "INFORME N°";

          /* Fin encabezado */

        /* Recupero la Max cantidad de pasadas del informe , si tiene más de 6 uso una plantilla especial */
        $max_pasadas = InformesRiElementosView::where('informe_id',$id)->max('cantidad_pasadas');

        $plantilla = ($max_pasadas > 6) ? 'ri-gasoducto-12-v2' : 'ri-gasoducto-6-v2';

        $juntas_posiciones = DB::select('CALL InformeRiGasoductoJuntaPosicion(?)',array($informe_ri->id));
        $pasadas_juntas = DB::select('CALL InformeRiGasoductoPasadasJuntas(?)',array($informe_ri->id));
        $defectos_posiciones = DB::select('CALL InformeRiGasoductoDefectosPasadasPosicion(?)',array($informe_ri->id));

        //  dd($juntas_posiciones,$pasadas_juntas,$defectos_posiciones);

        $pdf = PDF::loadView('reportes.informes.' . $plantilla,compact('titulo','nro','tipo_reporte','fecha',
                                                                        'ot',
                                                                        'planta',
                                                                        'norma_ensayo',
                                                                        'norma_evaluacion',
                                                                        'procedimiento_inf',
                                                                        'interno_equipo',
                                                                        'ot_tipo_soldadura',
                                                                        'actividad',
                                                                        'interno_fuente',
                                                                        'tipo_pelicula',
                                                                        'diametro_espesor',
                                                                        'ici',
                                                                        'tecnica',
                                                                        'ejecutor_ensayo',
                                                                        'cliente',
                                                                        'contratista',
                                                                        'informe',
                                                                        'informe_ri',
                                                                        'material',
                                                                        'material2',
                                                                        'tecnicas_grafico',
                                                                        'juntas_posiciones',
                                                                        'pasadas_juntas',
                                                                        'defectos_posiciones',
                                                                        'evaluador',
                                                                        'informe_modelos_3d',
                                                                        'firma',
                                                                        'numero_repetido',
                                                                        'informe_solicitado_por',
                                                                        'observaciones'))->setPaper('a4','landscape')->setWarnings(false);


        return $pdf->stream();

        }else

        {
          $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
          $titulo = "RADIOGRAFIA INDUSTRIAL";
          $nro = $numero_repetido === 1 ? FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) : FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .'-'.$numero_repetido .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
          $fecha = date('d-m-Y', strtotime($informe->fecha));
          $tipo_reporte = "INFORME N°";
        /* Detalle */

        $juntas_posiciones = DB::select('CALL InformeRiPlantaJuntaPosicion(?)',array($informe_ri->id));
        $defectos_posiciones = DB::select('CALL InformeRiPlantaDefectosPasadaPosicion(?)',array($informe_ri->id));

        //dd($juntas_posiciones,$defectos_posiciones);

        $pdf = PDF::loadView('reportes.informes.ri-planta-v2',compact('titulo','nro','tipo_reporte','fecha',
                                                              'ot',
                                                              'norma_ensayo',
                                                              'planta',
                                                              'norma_evaluacion',
                                                              'procedimiento_inf',
                                                              'ot_tipo_soldadura',
                                                              'interno_equipo',
                                                              'actividad',
                                                              'interno_fuente',
                                                              'tipo_pelicula',
                                                              'diametro_espesor',
                                                              'ici',
                                                              'tecnica',
                                                              'ejecutor_ensayo',
                                                              'cliente',
                                                              'contratista',
                                                              'informe',
                                                              'informe_ri',
                                                              'material',
                                                              'material2',
                                                              'tecnicas_grafico',
                                                              'juntas_posiciones',
                                                              'defectos_posiciones',
                                                              'evaluador',
                                                              'informe_modelos_3d',
                                                              'firma',
                                                              'numero_repetido',
                                                              'informe_solicitado_por',
                                                              'observaciones'))->setPaper('a4','portrait')->setWarnings(false);


        return $pdf->stream();

      }
    }
}