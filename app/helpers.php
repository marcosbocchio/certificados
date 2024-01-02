<?php

use App\ParametrosGenerales;
use App\InternoFuentes;
use Illuminate\Support\Facades\Log;
use App\PdfEspecial;
use App\ots;
use App\InformesRi;
use App\MetodoEnsayos;

/* pdfCantFilasACompletar()  : Funcion que retorna la cantidad de filas en blanco de una tabla que nos hace falta para completar un pdf.

  $filasPage : cantidad de filas por pagina para el pdf
  $cantFilasTotal : cantidad total de registros que vamos a mostrar

*/



function getNombreMes($nro_mes){

  $mes =  '' ;

  switch ($nro_mes) {
    case 1:
      $mes = 'Enero' ;
    break;
    case 2:
      $mes = 'Febrero' ;
      break;
    case 3:
      $mes = 'Marzo' ;
    break;
    case 4:
      $mes = 'Abril' ;
    break;
    case 5:
      $mes = 'Mayo' ;
    break;
    case 6:
      $mes = 'Junio' ;
    break;
    case 7:
      $mes = 'Julio' ;
    break;
    case 8:
      $mes = 'Agosto' ;
      break;
    case 9:
      $mes = 'Septiembre' ;
    break;
    case 10:
      $mes = 'Octubre' ;
    break;
    case 11:
      $mes = 'Noviembre' ;
    break;
    case 12:
      $mes = 'Diciembre' ;
    break;
    default:
    $mes = 'Indifinido' ;
      break;
  }

  return $mes ;
}

function pdfCantFilasACompletar($filasPage,$cantFilasTotal){

  
  $filas_completar = ($filasPage - ($cantFilasTotal % $filasPage)) ;
  Log::Debug('filasPage: ' . $filasPage);
  Log::Debug('cantFilasTotal: '.$cantFilasTotal);
  Log::debug('resto:'. ($cantFilasTotal % $filasPage));
  Log::Debug('filas_completar:'.$filas_completar);
  if($filas_completar == $filasPage){

      return 0 ;

    }
    else {

      return $filas_completar ;

    }

}

function FormatearNumeroInforme(int $numero,$metodo){

  return $metodo . sprintf("%04d",$numero) ;

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

function obtenerInformeEspecial($informe, $metodo_ensayo, &$informeEspecial) {

  
  $ot = ots::where('id', $informe->ot_id)->first();
  $clienteId = $ot->cliente_id;
  $tipoInforme = '';

  if ($metodo_ensayo->metodo == 'RI') {    
      Log::debug("||este log está en el if|| 'RI' ||");

      $informeRi = InformesRi::where('informe_id', $informe->id)->first();
      
      if ($informeRi->gasoducto_sn == 1) {
          $tipoInforme = 'gasoducto';
      } else if ($informeRi->perfil_sn == 1) {
          $tipoInforme = 'perfil';
      } else {
          $tipoInforme = 'planta'; 
      }

  } else if ($metodo_ensayo->metodo == 'US') {

      Log::debug("||este log está en el if|| 'US'");

      if ($informe->tecnica_id == 9) {
          $tipoInforme = 'US convencional';
      } else if ($informe->tecnica_id == 10) {
          $tipoInforme = 'Phased array';
      } else if ($informe->tecnica_id == 11) {
          $tipoInforme = 'Medición de Espesores';
      }

  }else if($metodo_ensayo->metodo == 'LP'){
    $tipoInforme = 'LP convencional';
  }
  
  $metodoEnsayoId = $metodo_ensayo->id;
  
  $pdfEspecial = pdfEspecial::where('cliente_id', $clienteId)
      ->where('metodo_ensayo_id', $metodoEnsayoId)
      ->where('tipo_informe', $tipoInforme)
      ->first();

  
  if ($pdfEspecial) {
      
      return $informeEspecial = $pdfEspecial->informe_especial;
      
  } else {
      Log::debug("No se encontró un registro en pdfEspecial" . $pdfEspecial);
  }
}



