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

function obtenerInformeEspecial($ot, $metodo_ensayo, &$informeEspecial) {

  $clienteId = $ot->cliente_id;

  
  $metodoEnsayoId = $metodo_ensayo->id;
  
  $pdfEspecial = pdfEspecial::where('cliente_id', $clienteId)
      ->where('metodo_ensayo_id', $metodoEnsayoId)
      ->first();

  
  if ($pdfEspecial) {
      
      return $informeEspecial = $pdfEspecial->informe_especial;
      
  } else {
      Log::debug("No se encontró un registro en pdfEspecial" . $pdfEspecial);
  }
}



function obtenerPropiedadesLiquidos($penetrante) {
  $propiedadesAMostrar = [];
  $propiedades = [
      'revelador_sn' => 'Revelador',
      'removedor_sn' => 'Removedor',
      'fluorescente_sn' => 'Fluorescente',
      'visible_sn' => 'Visible',
      'lavable_agua_sn' => 'Lavable Agua',
      'emusificante_lipofilico_sn' => 'Emusificante Lipofílico',
      'lavable_solvente_sn' => 'Lavable Solvente',
      'emusificante_hidrofilico_sn' => 'Emusificante Hidrofílico',
  ];

  foreach ($propiedades as $clave => $etiqueta) {
      if (isset($penetrante->$clave) && $penetrante->$clave == 1) {
          $propiedadesAMostrar[] = $etiqueta;
      }
  }

  return $propiedadesAMostrar;
}

function verificarSiTodosAceptables($detalles) {
  foreach ($detalles as $detalle) {
      if ($detalle->aceptable_sn != 1) {
          return 'Rechazado'; // Si alguno no es aceptable, retorna 'Rechazado'
      }
  }
  return 'Aceptado'; // Todos son aceptables
}


function transponerMediciones($mediciones) {
  $transpuestas = [];
  foreach ($mediciones as $row => $data) {
      foreach ($data as $col => $value) {
          $transpuestas[$col][$row] = $value;
      }
  }
  return $transpuestas;
}



function agruparPorAccesorios($informes_us_me) {
  $resultado = [];

  foreach ($informes_us_me as $informe) {
      $elemento_me = $informe->elemento_me;
      $medicionesOriginales = $informe->mediciones;

      // Transponer las mediciones originales.
      $medicionesTranspuestas = transponerMediciones($medicionesOriginales);

      // Recorrer las mediciones transpuestas y reemplazar '' por 'S/A' a partir de la tercera posición.
      foreach ($medicionesTranspuestas as &$medicion) {
          $newMedicion = [];
          foreach ($medicion as $key => $value) {
              if ($key >= 2 && $value === '') {
                  $newMedicion[] = 'S/A';
              } else {
                  $newMedicion[] = $value;
              }
          }
          $medicion = $newMedicion;
      }

      $resultado[$elemento_me] = [
          'cantidad_generatrices_me' => $informe->cantidad_generatrices_me,
          'cantidad_posiciones_me' => $informe->cantidad_posiciones_me,
          'cantidad_generatrices_linea_pdf_me' => $informe->cantidad_generatrices_linea_pdf_me,
          'espesor_minimo_me' => $informe->espesor_minimo_me, // Agregando espesor_minimo_me
          'medicionesTranspuestas' => $medicionesTranspuestas
      ];
  }

  return $resultado;
}



