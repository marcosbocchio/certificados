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
use App\InternoEquipos;
use App\EjecutorEnsayo;
use App\User;
use App\TecnicasGraficos;
use PDF;
use App\OtOperarios;
use App\OtProcedimientosPropios;
use App\TiposMagnetizacion;
use App\Corrientes;
use App\MetodosTrabajoPm;
use App\ColorParticulas;
use App\Iluminaciones;
use App\Contratistas;
use App\OtTipoSoldaduras;
use App\Particulas;
use App\Contrastes;
use App\DetallesPmReferencias;
use App\MetodoEnsayos;
use App\DetallesPm;

class PdfInformesPmController extends Controller
{
    public function imprimir($id){

        /* header */

         $informe = Informe::findOrFail($id);
         $metodo_ensayo = MetodoEnsayos::find($informe->metodo_ensayo_id);
         $informe_pm = InformesPm::where('informe_id',$informe->id)->firstOrFail();
         $ot = Ots::findOrFail($informe->ot_id);
         $cliente = Clientes::findOrFail($ot->cliente_id);
         $ot_tipo_soldadura = OtTipoSoldaduras::where('id',$informe->ot_tipo_soldadura_id)->with('Tiposoldadura')->first();
         $material = Materiales::findOrFail($informe->material_id);
         $material2 = Materiales::find($informe->material2_id);
         $norma_ensayo = NormaEnsayos::findOrFail($informe->norma_ensayo_id);
         $norma_evaluacion = NormaEvaluaciones::findOrFail($informe->norma_evaluacion_id);
         $ot_procedimiento_propio = OtProcedimientosPropios::findOrFail($informe->procedimiento_informe_id);
         $procedimiento_inf = Documentaciones::findOrFail($ot_procedimiento_propio->documentacion_id);
         $fuente = Fuentes::find($informe_pm->fuente_id);
         $diametro_espesor = DiametrosEspesor::findOrFail($informe->diametro_espesor_id);
         $particula = Particulas::where('id',$informe_pm->particula_id)->with('color')->first();
         $contraste = Contrastes::where('id',$informe_pm->tinta_contraste_id)->first();
         $tecnica = Tecnicas::findOrFail($informe->tecnica_id);
         $interno_equipo = InternoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
         $instrumento_medicion = InternoEquipos::where('id',$informe_pm->instrumento_medicion_id)->with('equipo')->first();
         $tipo_magnetizacion = TiposMagnetizacion::findOrFail($informe_pm->tipo_magnetizacion_id);
         $magnetizacion = Corrientes::findOrFail($informe_pm->corriente_magnetizacion_id);
         $desmagnetizacion_sn = $informe_pm->desmagnetizacion_sn;
         $ot_operador = OtOperarios::findOrFail($informe->ejecutor_ensayo_id);
         $metodo = MetodosTrabajoPm::findOrFail($informe_pm->metodo_trabajo_pm_id);
         $ejecutor_ensayo = User::findOrFail($ot_operador->user_id);
         $iluminacion = Iluminaciones::findOrFail($informe_pm->iluminacion_id);
         $evaluador = User::find($informe->firma);
         $firma = (new \App\Http\Controllers\UserController)->getFirma($informe->firma,$metodo_ensayo->id);
         $contratista = Contratistas::find($ot->contratista_id);
         $observaciones = $informe->observaciones;
         $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);



        /*  Encabezado */

        $titulo = "PARTÍCULAS MAGNETIZABLES";
        $nro = FormatearNumeroInforme($informe->numero,$metodo_ensayo->metodo) .' - Rev.'. FormatearNumeroConCeros($informe->revision,2) ;
        $fecha = date('d-m-Y', strtotime($informe->fecha));
        $tipo_reporte = "INFORME N°";

     //   dd($instrumento_medicion);

        $detalles = DetallesPm::with('referencia')
                                ->where('informe_pm_id',$informe_pm->id)
                                ->get();

           $pdf = PDF::loadView('reportes.informes.pm-v2',compact('ot','titulo','nro','tipo_reporte','fecha',
                                                                'norma_ensayo',
                                                                'norma_evaluacion',
                                                                'procedimiento_inf',
                                                                'fuente',
                                                                'diametro_espesor',
                                                                'tecnica',
                                                                'interno_equipo',
                                                                'instrumento_medicion',
                                                                'ejecutor_ensayo',
                                                                'cliente',
                                                                'contratista',
                                                                'informe',
                                                                'informe_pm',
                                                                'ot_tipo_soldadura',
                                                                'material',
                                                                'material2',
                                                                'tipo_magnetizacion',
                                                                'magnetizacion',
                                                                'particula',
                                                                'contraste',
                                                                'desmagnetizacion_sn',
                                                                'metodo',
                                                                'iluminacion',
                                                                'evaluador',
                                                                'detalles',
                                                                'informe_modelos_3d',
                                                                'observaciones',
                                                                'firma',
                                                                ))->setPaper('a4','portrait')->setWarnings(false);


           return $pdf->stream();

     }
}
