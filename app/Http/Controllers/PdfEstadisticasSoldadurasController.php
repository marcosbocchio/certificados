<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use Illuminate\Support\Facades\DB;
// use App\helpers;

class PdfEstadisticasSoldadurasController extends Controller
{



    public function imprimir($cliente_id,$obra,$fecha_desde,$fecha_hasta){

        $cliente = Clientes::find($cliente_id);
        $fd = date('Y-m-d',strtotime($fecha_desde));
        $fh = date('Y-m-d',strtotime($fecha_hasta));
        $estadisticasGenerales = DB::select('CALL getEstadisticasGeneralesSoldaduras(?,?,?,?)',array($cliente_id,$obra,$fd,$fh));
        $this->completarTitulosQuicenas($estadisticasGenerales);
        $total_costuras_radiografiadas = 0;
        $total_costuras_aprobadas = 0;
        $total_costuras_rechazadas = 0;
        $total_posiciones_radiografiadas = 0;
        $total_posiciones_aprobadas = 0;
        $total_posiciones_rechazadas = 0;
        $total_cantidad_soldaduras_soldador = 0;
        $this->CalcularTotalesEstadisticasGenerales($estadisticasGenerales,$total_costuras_radiografiadas,$total_costuras_aprobadas,$total_costuras_rechazadas,$total_posiciones_radiografiadas,$total_posiciones_aprobadas,$total_posiciones_rechazadas);
        // dd($estadisticasGenerales,$total_costuras_radiografiadas,$total_costuras_aprobadas,$total_costuras_rechazadas,$total_posiciones_radiografiadas,$total_posiciones_aprobadas,$total_posiciones_rechazadas);
        $cantidadSoldadurasSoldador = DB::select('CALL CantidadSoldadurasSoldador(?,?,?,?)',array($cliente_id,$obra,$fd,$fh));
        $this->CalcularTotalCantidadSoldadurasSoldador($cantidadSoldadurasSoldador,$total_cantidad_soldaduras_soldador);
       // dd($estadisticasGenerales,$cantidadSoldadurasSoldador);
        $pdf = \PDF::loadView('reportes.soldadores.estadisticas-soldaduras2',compact(

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
                                                                'total_posiciones_rechazadas','total_cantidad_soldaduras_soldador'

                                                               ));
        return $pdf->stream();

    }

    function CalcularTotalesEstadisticasGenerales($estadisticasGenerales,&$total_costuras_radiografiadas,&$total_costuras_aprobadas,&$total_costuras_rechazadas,&$total_posiciones_radiografiadas,&$total_posiciones_aprobadas,&$total_posiciones_rechazadas){

        foreach ($estadisticasGenerales as $item) {

            $total_costuras_radiografiadas+=$item->costuras_radiografiadas ;
            $total_costuras_aprobadas+= $item->costuras_aprobadas;
            $total_costuras_rechazadas+=$item->costuras_rechazadas;
            $total_posiciones_radiografiadas+=$item->posiciones_radiografiadas;
            $total_posiciones_aprobadas+= $item->posiciones_aprobadas;
            $total_posiciones_rechazadas+= $item->posiciones_rechazadas;
        }
   }

   function CalcularTotalCantidadSoldadurasSoldador($cantidadSoldadurasSoldador,&$total_cantidad_soldaduras_soldador){

     foreach ($cantidadSoldadurasSoldador as $item) {

        $total_cantidad_soldaduras_soldador+= $item->posiciones_radiografiadas;
     }
   }

public function completarTitulosQuicenas($estadisticasGenerales){

    setlocale(LC_TIME, 'es_ES.UTF-8');

    foreach ($estadisticasGenerales as $item) {

        $dia = date("d",strtotime($item->fecha_inicial));
        $mes = getNombreMes(date("m",strtotime($item->fecha_inicial)));
        $anio = date("Y",strtotime($item->fecha_inicial));
        $quincena = intval($dia) < 15 ? '1ER' : '2DA';
        $item->titulo = $quincena . ' ' .'QUINCENA'. ' ' . strtoupper($mes) . ' ' . 'DE' . ' ' . $anio;
    }

}

}
