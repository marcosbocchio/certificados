<?php

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
function curie($curie,$fecha_evaluacion,$const_t){

  $Ti = strtotime($fecha_evaluacion);
  $Tf = strtotime(date('Y-m-d',strtotime('now')));
  $t  = intval(($Tf-$Ti)/60/60/24);
  $curie_actual = round(($curie)  /(pow(2,(($t)/$const_t))),1);
  return $curie_actual;   
}

