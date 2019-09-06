<?php

/* pdfCantFilasACompletar()  : Funcion que retorna la cantidad de filas en blanco de una tabla que nos hace falta para completar un pdf.

  $filasPage : cantidad de filas por pagina para el pdf 
  $cantFilasTotal : cantidad total de registros que vamos a mostrar

*/

function pdfCantFilasACompletar($filasPage,$cantFilasTotal){


    return ($filasPage - (count($cantFilasTotal) % $filasPage)) ;

}

function FormatearNumeroInforme(int $numero,$metodo){

  return $metodo . sprintf("%03d",$numero) ;

}

function FormatearNumeroConCeros(int $numero,$ceros){

  return sprintf("%0" . $ceros ."d",$numero) ;

}

