<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Remitos;
use App\DetalleRemitos;

class PdfRemitosController extends Controller
{
    public function imprimir($id){


        
        $remito = Remitos::findOrFail($id);
        $detalle = DB::select('SELECT 
                                    detalle_remitos.cantidad as cantidad,
                                    productos.descripcion as producto,
                                    medidas.descripcion as medida,
                                    unidades_medidas.codigo as unidad_medida
                                    FROM detalle_remitos
                                    INNER JOIN productos ON productos.id = detalle_remitos.producto_id
                                    INNER JOIN medidas ON medidas.id = detalle_remitos.medida_id
                                    INNER JOIN unidades_medidas ON unidades_medidas.id = medidas.unidades_medida_id
                                    WHERE 
                                    detalle_remitos.remito_id =:id',['id' => $remito->id ]);
      

      return  view('reportes.remitos.remito',compact('remito','detalle'));  
    
    
    }
}
