<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Remitos;
use App\Ots;
use App\Clientes;
use App\DetalleRemitos;
use App\RemitoInternoEquipos;
use App\User;
use App\DetalleObservacionRemito;
use App\Contratistas;

class PdfRemitosController extends Controller
{
    public function imprimir($id){


        
        $remito = Remitos::findOrFail($id);
        $observacionesRemito = DetalleObservacionRemito::where('remito_id', $id)->get();
        $detalle = DB::select('SELECT 
                                    detalle_remitos.cantidad as cantidad,
                                    productos.descripcion as producto,
                                    medidas.codigo as medida,
                                    unidades_medidas.codigo as unidad_medida
                                    FROM detalle_remitos
                                    INNER JOIN productos ON productos.id = detalle_remitos.producto_id
                                    INNER JOIN medidas ON medidas.id = detalle_remitos.medida_id
                                    INNER JOIN unidades_medidas ON unidades_medidas.id = medidas.unidades_medida_id
                                    WHERE 
                                    detalle_remitos.remito_id =:id',['id' => $remito->id ]);

$remito_interno_equipos = RemitoInternoEquipos::where('remito_id',$id)->with('InternoEquipo.equipo','InternoEquipo.internoFuente.fuente')->get();      

if($remito->interno_sn){
  
        $ot = Ots::find($remito->ot_id);
        $contratista = Contratistas::find($ot->contratista_id);
        $cliente = Clientes::find($ot->cliente_id);
        $user = User::find($remito->user_id);
        
        $titulo = "REMITO INTERNO";
        $nro = FormatearNumeroConCeros($remito->prefijo,'4'). '-' .FormatearNumeroConCeros($remito->numero,'8');
        $fecha = date('d-m-Y', strtotime($remito->fecha));
        $tipo_reporte = 'REMITO N°:';
        $pdf = \PDF::loadView('reportes.remitos.remito-interno-v2',compact('remito','ot','titulo','nro','fecha','tipo_reporte','cliente','detalle','remito_interno_equipos','user','contratista'))->setPaper('a4','portrait')->setWarnings(false);  

        return $pdf->stream();

      }else{

      return  view('reportes.remitos.remito-externo',compact('remito','detalle','remito_interno_equipos','observacionesRemito'));  
    
      }
    }
}
