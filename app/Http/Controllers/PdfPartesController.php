<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Partes;
use App\Ots;
use App\Clientes;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Contratistas;
use Illuminate\Support\Collection as Collection;

class PdfPartesController extends Controller
{

    public function __construct()
    {


    }

    public function imprimir($id,$estado){


        if($estado == 'original'){

            $this->middleware(['role_or_permission:Sistemas|T_partes_edita']);

        }

        $parte = Partes::where('id',$id)
                        ->select('partes.*')
                        ->first();

        $ot = Ots::find($parte->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
        $evaluador = User::find($parte->firma);

        $responsables = DB::table('parte_operadores')
                          ->join('users','users.id','=','parte_operadores.user_id')
                          ->where('parte_operadores.parte_id',$id)
                          ->select('users.name as nombre','parte_operadores.responsabilidad')
                          ->get();

        $vehiculos = DB::table('parte_vehiculos')
                          ->join('vehiculos','vehiculos.id','=','parte_vehiculos.vehiculo_id')
                          ->where('parte_vehiculos.parte_id',$id)
                          ->select('vehiculos.*','parte_vehiculos.km_inicial','parte_vehiculos.km_final')
                          ->get();


        /*  Encabezado */

        $titulo = "PARTE DIARIO DE TRABAJO";
        $nro = $parte->id;
        $fecha = date('d-m-Y', strtotime($parte->fecha));
        $observaciones = $parte->observaciones;
        $tipo_reporte = 'PARTE Nº:';
        $fechaFormateada = str_replace('-', '', $fecha);

        $nombreArchivo = $nro . '-' . $fechaFormateada . '.pdf';

        $contratista = Contratistas::find($ot->contratista_id);

        $parte_detalle = DB::select('CALL ParteDetalle(?,?)',array($id,$estado));

        $servicios = DB::table('parte_servicios')
                        ->join('servicios','servicios.id','=','parte_servicios.servicio_id')
                        ->join('metodo_ensayos','metodo_ensayos.id','=','servicios.metodo_ensayo_id')
                        ->join('unidades_medidas','unidades_medidas.id','=','servicios.unidades_medida_id')
                        ->where('parte_servicios.parte_id',$id)
                        ->selectRaw('metodo_ensayos.id as metodo_ensayo_id,metodo_ensayos.metodo,unidades_medidas.id as unidad_medida_id,unidades_medidas.codigo as unidad_medida,servicios.id as servicio_id,servicios.descripcion as servicio_descripcion,cant_original,cant_final')
                        ->get();


        $metodos_informe = DB::table('parte_detalles')
                                 ->leftjoin('informes','parte_detalles.informe_id','=','informes.id')
                                 ->join('informes_view','informes_view.informe_id','=','informes.id')
                                ->leftjoin('informes_importados','parte_detalles.informe_importado_id','=','informes_importados.id')
                                ->join('metodo_ensayos',function($join){

                                    $join->on('metodo_ensayos.id','=','informes.metodo_ensayo_id');
                                    $join->orOn('metodo_ensayos.id','=','informes_importados.metodo_ensayo_id');

                                })
                                ->where('parte_detalles.parte_id',$id)
                                ->selectRaw('metodo_ensayos.metodo as metodo,informes_view.numero_formateado,IFNULL(informes.id,informes_importados.id) as informe_id,informes.id as no_importado')
                                ->groupby('numero_formateado','metodo','informes.id','informes_importados.id')
                                ->orderBy('numero_formateado','ASC')
                                ->get();

        $informes_detalle = DB::table('metodo_ensayos')
                                ->join('informes','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                                ->join('informes_view','informes_view.informe_id','=','informes.id')
                                ->join('parte_detalles','parte_detalles.informe_id','=','informes.id')
                                ->leftjoin('plantas','plantas.id','=','informes.planta_id')
                                ->leftjoin('users','users.id','=','informes.solicitado_por')
                                ->leftjoin('diametros_espesor','diametros_espesor.id','=','informes.diametro_espesor_id')
                                ->where('parte_detalles.parte_id',$id)
                                ->selectRaw('metodo_ensayos.metodo as metodo,informes.id as informe_id,plantas.codigo as planta,users.name as solicitado_por,informes_view.numero_formateado,informes.componente as componente, diametros_espesor.diametro as diametro, informes.diametro_especifico as diametro_especifico')
                                ->groupBy('informes.id','metodo','numero_formateado')
                                ->get();

        $informes_ri_adicionales = [];

        if($estado=='final'){
            $informes_ri_adicionales = DB::table('parte_detalles')
                                    ->whereNull('parte_detalles.informe_id')
                                    ->whereNull('parte_detalles.informe_importado_id')
                                    ->where('parte_detalles.parte_id',$id)
                                    ->selectRaw('parte_detalles.costura_final as costura,parte_detalles.pulgadas_final as pulgadas,parte_detalles.placas_final as placas,parte_detalles.cm_final as cm, 0 as informe_sel')
                                    ->get();
        }
        Log::debug($informes_detalle);
     //  dd($informes_ri_adicionales);

        $pdf = \PDF::loadView('reportes.partes.parte-v2',compact('ot','titulo','nro','fecha','observaciones','tipo_reporte',
                                                            'cliente',
                                                            'contratista',
                                                            'parte',
                                                            'metodos_informe',
                                                            'informes_detalle',
                                                            'informes_ri_adicionales',
                                                            'responsables',
                                                            'vehiculos',
                                                            'servicios',
                                                            'parte_detalle',
                                                            'estado',
                                                            'evaluador'
                                                                ))->setPaper('a4','portrait')->setWarnings(false);
        return $pdf->stream($nombreArchivo);


    }

}

