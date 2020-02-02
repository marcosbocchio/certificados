<?php

use App\ParametrosGenerales;
use App\Partes;
use App\InternoFuentes;

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

function CalcularDiasEntreFechas($fecha_inicial, $fecha_final = null){
  
  $Ti = strtotime($fecha_inicial);
  $Tf = null; 

  if($fecha_final){

    $Tf = strtotime($fecha_final);

  }else{

    $Tf = strtotime(date('Y-m-d',strtotime('now')));

  }
 
  $T  = intval(($Tf-$Ti)/60/60/24);

  return $T;
}

function curie($interno_fuente_id, $fecha_final = null){

  $interno_fuente = InternoFuentes::where('id',$interno_fuente_id)->with('fuente')->first();
  $fecha_evaluacion = $interno_fuente->fecha_evaluacion;
  $T = CalcularDiasEntreFechas($fecha_evaluacion,$fecha_final);
  $const_t = $interno_fuente->fuente->const_t;
  $curie = $interno_fuente->curie;
  $curie_actual = round(($curie)  /(pow(2,(($T)/$const_t))),1);
  return $curie_actual;  

}

function PuedeCrearInforme($ot_id){

    $ddppi = ParametrosGenerales::where('codigo','DDPPI')->first();


    if($ddppi!=null){

      $informes_demorados_parte = DB::select('CALL InfomesSinPartePorLimiteDias(?,?)',array($ot_id,$ddppi->valor));  
      
      if(count($informes_demorados_parte) == 0){

        return 1;
      }
      else{

        return 0;
      }

    }

    else{

        return 1;
    }

}

