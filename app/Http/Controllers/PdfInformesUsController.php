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
use App\Soldadores;
use App\OtTipoSoldaduras;
use App\AgenteAcoplamientos;
use App\MetodoEnsayos;
use App\InformesUsMe;
use App\Generatrices;
use App\DetalleUsPaUs;
use App\ComponenteUsMe;
use App\PdfEspecial;
use App\MaterialUs;
use App\Equipos;
use App\DetalleUsMe;
use App\NormasFabricacion;
use App\CategoriasInspeccion;
use App\ItemsCategoriaInspeccion;
use App\RespuestasInforme;
use Illuminate\Support\Facades\Log;


class PdfInformesUsController extends Controller
{
    public function getTablaInforme(int $informeId)
    {
       
        $categorias = CategoriasInspeccion::with('items')->get();
    
        
        $respuestas = RespuestasInforme::where('informe_id', $informeId)
                         ->get()
                         ->keyBy('item_categoria_id'); 
    
   
        $tabla = $categorias->map(function($cat) use ($respuestas) {
            return [
                'id'         => $cat->id,
                'categoria'  => $cat->nombre,
                'items'      => $cat->items->map(function($item) use ($respuestas) {
                    return [
                        'id'        => $item->id,
                        'nombre'    => $item->nombre,
                       
                        'respuesta' => $respuestas->has($item->id)
                                       ? $respuestas[$item->id]->respuesta
                                       : null,
                    ];
                })->toArray(),
            ];
        });
    

        $tabla_informe = $tabla->toArray();
    

    
        return $tabla_informe;
    }
    public function getComponente($informe_us_id){

        $componente =  ComponenteUsMe::
                             where('informe_us_id',$informe_us_id)
                            ->with('norma')
                            ->with('material')
                            ->with('materiales')
                            ->with('fluido')
                            ->with('modelo')
                            ->first();
        return $componente;

    }
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
         $indicaciones_us_pa_actualizado = DetalleUsPaUs::where('informe_us_id',$informe_us->id)->get();
         $indicaciones_us_pa = remplazarSoldadores($indicaciones_us_pa_actualizado);
         $equipo = Equipos::where('id', $interno_equipo->equipo_id)->first();
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

        $componente_us          = ComponenteUsMe::where('informe_us_id', $informe_us->id)->first();
        if ($componente_us) {
            $informes_us_me_f = $informes_us_me->first();
            $espesorMinimo_form = DetalleUsMe::where('informe_us_me_id', $informes_us_me_f->id)->whereNotNull('generatriz')->min('valor');
            $pdfEspecial          = PdfEspecial::find($componente_us->pdf_especial_id);
            $materialesUS         = MaterialUs::where('componente_us_me_id', $componente_us->id)->get();
            $materialMinMedido    = $materialesUS->min('espesor_minimo_medido');
            $calibracion_us       = $calibraciones_us->first();
            $palpadorUS           = optional($calibracion_us)->palpador;
            $equipoPalpador       = $palpadorUS ? Equipos::find($palpadorUS->equipo_id) : null;
            $tablaInforme         = $this->getTablaInforme($informe->id);
            $componenteEntero     = $this->getComponente($informe_us->id);
        } else {
            // 2b) Si no existe, les damos un valor “seguro” para no romper el compact()
            $pdfEspecial          = null;
            $materialesUS         = collect();
            $materialMinMedido    = null;
            $calibracion_us       = null;
            $palpadorUS           = null;
            $equipoPalpador       = null;
            $tablaInforme         = null;
            $componenteEntero     = null;
            $informes_us_me_f     = null;
            $espesorMinimo_form     = null;
        }
    
        // 3) Elijo la plantilla Blade igual que antes
        $nombre = optional($pdfEspecial)->informe_especial;
        $blade  = $nombre 
                    ? 'reportes.informes.' . $nombre 
                    : 'reportes.informes.us-v2';

        $pdf = PDF::loadView(
            $blade,
            compact('ot','titulo','nro','tipo_reporte','fecha',
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
                                                                'componente_us',
                                                                'pdfEspecial',
                                                                'materialesUS',
                                                                'equipo',
                                                                'palpadorUS',
                                                                'equipoPalpador',
                                                                'calibracion_us',
                                                                'tablaInforme',
                                                                'materialMinMedido',
                                                                'componenteEntero',
                                                                'espesorMinimo_form',
                                                                'informes_us_me_f'
                                                                ))->setPaper('a4','portrait')->setWarnings(false);
           return $pdf->stream();

     }
}
