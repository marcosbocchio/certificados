<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use Illuminate\Support\Facades\DB;

class PdfEstadisticasSoldadurasController extends Controller
{
    public function imprimir($cliente_id,$obra,$fecha_desde,$fecha_hasta){ 

        $cliente = Clientes::find($cliente_id);      
        $fd = date('Y-m-d',strtotime($fecha_desde));
        $fh = date('Y-m-d',strtotime($fecha_hasta));
        $estadisticasGenerales = DB::select('CALL getEstadisticasGeneralesSoldaduras(?,?,?,?)',array($cliente_id,$obra,$fd,$fh));    
        $total_costuras_radiografiadas = 0;
        $total_costuras_aprobadas = 0;
        $total_costuras_rechazadas = 0;
        $total_posiciones_radiografiadas = 0;
        $total_posiciones_aprobadas = 0;
        $total_posiciones_rechazadas = 0;
        $this->CalcularTotalesEstadisticasGenerales($estadisticasGenerales,$total_costuras_radiografiadas,$total_costuras_aprobadas,$total_costuras_rechazadas,$total_posiciones_radiografiadas,$total_posiciones_aprobadas,$total_posiciones_rechazadas);
       // dd($estadisticasGenerales,$total_costuras_radiografiadas,$total_costuras_aprobadas,$total_costuras_rechazadas,$total_posiciones_radiografiadas,$total_posiciones_aprobadas,$total_posiciones_rechazadas);
        $cantidadSoldadurasSoldador = DB::select('CALL CantidadSoldadurasSoldador(?,?,?,?)',array($cliente_id,$obra,$fd,$fh));    

      //  dd($estadisticasGenerales,$estadisticasGenerales);
        $pdf = \PDF::loadView('reportes.soldadores.estadisticas-soldaduras',compact(

                                                                'cliente',
                                                                'obra',
                                                                'fecha_desde',
                                                                'fecha_hasta',
                                                                'estadisticasGenerales',
                                                                'cantidadSoldadurasSoldador',
                                                                'total_costuras_radiografiadas',
                                                                'total_costuras_aprobadas',
                                                                'total_costuras_rechazadas',
                                                                'total_posiciones_radiografiadas',
                                                                'total_posiciones_aprobadas',
                                                                'total_posiciones_rechazadas'                                                             
                                                               
                                                               ));
        return $pdf->stream();
        
    }

   public function CalcularTotalesEstadisticasGenerales($estadisticasGenerales,&$total_costuras_radiografiadas,&$total_costuras_aprobadas,&$total_costuras_rechazadas,&$total_posiciones_radiografiadas,&$total_posiciones_aprobadas,&$total_posiciones_rechazadas){

    foreach ($estadisticasGenerales as $item) {

        $total_costuras_radiografiadas+=$item->costuras_radiografiadas ;
        $total_costuras_aprobadas+= $item->costuras_aprobadas;
        $total_costuras_rechazadas+=$item->costuras_rechazadas;
        $total_posiciones_radiografiadas+=$item->posiciones_radiografiadas;
        $total_posiciones_aprobadas+= $item->posiciones_aprobadas;
        $total_posiciones_rechazadas+= $item->posiciones_rechazadas;
    }


   } 

}
