<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtProductos;
use App\Clientes;
use App\Ots;
use App\Productos;
use App\OtReferencias;

class PdfProductosReferenciasController extends Controller
{
    public function imprimir($id){ 

        $ot_modelos = OtProductos::where('ot_referencia_id',$id)->first();             
        $ot = Ots::find($ot_modelos->ot_id);   
        $cliente = Clientes::find($ot->cliente_id);
        $modelo = Productos::find($ot_modelos->producto_id);
        $ot_referencia = OtReferencias::find($id);       
      

        $pdf = \PDF::loadView('reportes.ots.referencias',compact('ot',
                                                                'cliente',
                                                                'modelo',
                                                                'ot_modelo',
                                                                'ot_referencia'
                                                               ));
        return $pdf->stream();
        


    }
}
