<?php

use App\ParametrosGenerales;
use App\Partes;

/* pdfCantFilasACompletar()  : Funcion que retorna la cantidad de filas en blanco de una tabla que nos hace falta para completar un pdf.

  $filasPage : cantidad de filas por pagina para el pdf 
  $cantFilasTotal : cantidad total de registros que vamos a mostrar

*/

function pdfCantFilasACompletar($filasPage,$cantFilasTotal){
   

    $filas_completar = ($filasPage - ($cantFilasTotal % $filasPage)) ;

    if($filas_completar == $filasPage){

      return 0 ;

    }
    else {

      return $filas_completar ;
      
    }

}

function FormatearNumeroInforme(int $numero,$metodo){

  return $metodo . sprintf("%03d",$numero) ;

}

function FormatearNumeroConCeros(int $numero,$ceros){

  return sprintf("%0" . $ceros ."d",$numero) ;

}

function CalcularDiasHastaFechaActual($fecha_inicial){

  $Ti = strtotime($fecha_inicial);
  $Tf = strtotime(date('Y-m-d',strtotime('now')));
  $T  = intval(($Tf-$Ti)/60/60/24);

  return $T;
}

function curie($curie,$fecha_evaluacion,$const_t){

  $T = CalcularDiasHastaFechaActual($fecha_evaluacion);
  $curie_actual = round(($curie)  /(pow(2,(($T)/$const_t))),1);
  return $curie_actual;  

}

function PuedeCrearInforme($ot_id){

    $ddppi = ParametrosGenerales::where('codigo','DDPPI')->first();

    $parte = Partes::where('ot_id',$ot_id)
                    ->orderBy('fecha','desc')
                    ->limit('1')
                    ->first();

    if($parte != null && $ddppi!=null){

        $T = CalcularDiasHastaFechaActual($parte->fecha);
    
        return ($T <= $ddppi->valor) ? 1 : 0;
    }

    else{

        return 1;
    }

}

