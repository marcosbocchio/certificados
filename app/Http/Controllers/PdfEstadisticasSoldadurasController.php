<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;

class PdfEstadisticasSoldadurasController extends Controller
{
    public function imprimir($cliente_id,$obra,$fecha_desde,$fecha_hasta){ 

        $cliente = Clientes::find($cliente_id);      
        $this->CalcularQuincenas($fecha_desde,$fecha_hasta); 
      
        $pdf = \PDF::loadView('reportes.soldadores.estadisticas-soldaduras',compact(

                                                                'cliente'                                                             
                                                               
                                                               ));
        return $pdf->stream();
        
    }

    public function CalcularQuincenas($fecha_desde,$fecha_hasta){

     
       $fd = date('Y-m-d',strtotime($fecha_desde));
       $fh = date('Y-m-d',strtotime($fecha_hasta));
        
       dd($fd);

    }
}
