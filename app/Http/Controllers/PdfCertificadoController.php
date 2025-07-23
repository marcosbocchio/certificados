<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Certificados;
use App\Ots;
use App\Clientes;
use App\Contratistas;
use App\User;
use \stdClass;
use Illuminate\Support\Facades\Log;

class PdfCertificadoController extends Controller
{
    /**
     * Agrupa las partes por fecha, concatenando números de parte y obras.
     *
     * @param array $partes_certificado Array de objetos de partes de certificado.
     * @return array Array de partes agrupadas por fecha.
     */
    private function groupPartesByDate(array $partes_certificado): array
    {
        $groupedPartes = [];

        foreach ($partes_certificado as $parte) {
            $fecha = $parte->fecha_formateada;

            if (!isset($groupedPartes[$fecha])) {
                $groupedPartes[$fecha] = [
                    'fecha_formateada' => $fecha,
                    'partes_numeros_agrupados' => [],
                    'obras_agrupadas' => [],
                    'parte_id' => $parte->parte_id, // Mantener el ID de la primera parte para referencia si es necesario
                    'fecha_parte' => $parte->fecha_parte,
                ];
            }

            // Concatenar números de parte únicos
            if (!in_array($parte->parte_numero, $groupedPartes[$fecha]['partes_numeros_agrupados'])) {
                $groupedPartes[$fecha]['partes_numeros_agrupados'][] = $parte->parte_numero;
            }

            // Concatenar obras únicas
            if (!empty($parte->obra) && !in_array($parte->obra, $groupedPartes[$fecha]['obras_agrupadas'])) {
                $groupedPartes[$fecha]['obras_agrupadas'][] = $parte->obra;
            }
        }

        // Formatear las cadenas concatenadas
        foreach ($groupedPartes as &$groupedParte) {
            $groupedParte['partes_numeros_agrupados'] = implode(' / ', $groupedParte['partes_numeros_agrupados']);
            $groupedParte['obras_agrupadas'] = implode(' / ', $groupedParte['obras_agrupadas']);
            // Convertir a objeto para mantener consistencia con los resultados de DB::select
            $groupedParte = (object)$groupedParte;
        }

        return array_values($groupedPartes); // Resetear las claves del array
    }

    /**
     * Agrupa los servicios por fecha y abreviatura, sumando las cantidades.
     *
     * @param array $servicios_parte Array de objetos de servicios por parte.
     * @return array Array de servicios agrupados por fecha y abreviatura.
     */
    private function groupServiciosByDate(array $servicios_parte): array
    {
        $groupedServicios = [];

        foreach ($servicios_parte as $servicio) {
            $fecha = $servicio->fecha_formateada;
            $abreviatura = $servicio->abreviatura;
            $key = $fecha . '_' . $abreviatura;

            if (!isset($groupedServicios[$key])) {
                $groupedServicios[$key] = [
                    'fecha_formateada' => $fecha,
                    'abreviatura' => $abreviatura,
                    'cantidad' => 0.0,
                    // Puedes añadir otras propiedades si son relevantes para la vista agrupada
                    'descripcion_servicio' => $servicio->descripcion_servicio,
                    'combinado_sn' => $servicio->combinado_sn,
                    'nro_combinacion' => $servicio->nro_combinacion,
                    'combinacion' => $servicio->combinacion,
                    'obra' => $servicio->obra, // Podría ser la primera obra encontrada o concatenar si es necesario
                ];
            }
            $groupedServicios[$key]['cantidad'] += (float) $servicio->cantidad;
        }

        // Convertir a objeto para mantener consistencia con los resultados de DB::select
        foreach ($groupedServicios as &$groupedServicio) {
            $groupedServicio = (object)$groupedServicio;
        }

        return array_values($groupedServicios); // Resetear las claves del array
    }

    /**
     * Agrupa los productos por fecha y unidad de medida, sumando las cantidades.
     *
     * @param array $productos_parte Array de objetos de productos por parte.
     * @return array Array de productos agrupados por fecha y unidad de medida.
     */
    private function groupProductosByDate(array $productos_parte): array
    {
        $groupedProductos = [];

        foreach ($productos_parte as $producto) {
            $fecha = $producto->fecha_formateada;
            $unidadMedida = $producto->unidad_medida_producto;
            $key = $fecha . '_' . ($unidadMedida ?? 'null'); // Manejar unidad_medida_producto nula

            if (!isset($groupedProductos[$key])) {
                $groupedProductos[$key] = [
                    'fecha_formateada' => $fecha,
                    'unidad_medida_producto' => $unidadMedida,
                    'cantidad' => 0,
                    // Puedes añadir otras propiedades si son relevantes para la vista agrupada
                    'modalidad_cobro' => $producto->modalidad_cobro,
                    'obra' => $producto->obra, // Podría ser la primera obra encontrada o concatenar si es necesario
                ];
            }
            $groupedProductos[$key]['cantidad'] += (int) $producto->cantidad; // Sumar como entero
        }

        // Convertir a objeto para mantener consistencia con los resultados de DB::select
        foreach ($groupedProductos as &$groupedProducto) {
            $groupedProducto = (object)$groupedProducto;
        }

        return array_values($groupedProductos); // Resetear las claves del array
    }


    public function imprimir($id,$estado,$agrupado = "normal"){

        $certificado = Certificados::findOrFail($id);
        $ot = Ots::find($certificado->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
        $contratista = Contratistas::find($ot->contratista_id);
        $fecha = date("Y/m/d H:i:s");
        $productoCosturaOt = (new \App\Http\Controllers\CertificadosController)->getModalidadCobro($ot->id);
        $modalidadCobro = ( $productoCosturaOt->count() > 0 ) ? 'COSTURAS' : 'PLACAS';

        // Obtener datos originales
        $partes_certificado_original = DB::select('CALL PartesCertificadoReporte(?)',array($id));
        $servicios_parte_original = DB::select('CALL getServiciosCertificados(?,?)',array($id,$estado));
        $productos_parte_original = DB::select('CALL getProductosCertificados(?,?,?)',array($id,$estado,$modalidadCobro));

        // Por defecto, las variables de la vista usan los datos originales
        $partes_certificado_para_vista = $partes_certificado_original;
        $servicios_parte_para_vista = $servicios_parte_original;
        $productos_parte_para_vista = $productos_parte_original;

        // *** APLICAR LÓGICA DE AGRUPAMIENTO SOLO SI $agrupado ES "agrupado" ***
        if ($agrupado == "agrupado") {
            $partes_certificado_para_vista = $this->groupPartesByDate($partes_certificado_original);
            $servicios_parte_para_vista = $this->groupServiciosByDate($servicios_parte_original);
            $productos_parte_para_vista = $this->groupProductosByDate($productos_parte_original);
        }
        // Fin de la lógica de agrupamiento condicional.

        $servicios_abreviaturas = $this->abreviaturasUnicas($servicios_parte_original); // Las abreviaturas siempre se obtienen de los datos originales para tener todas las columnas posibles
        $servicios_combinaciones = $this->combinacionesUnicas($servicios_parte_original);
        $servicios_footer = $this->ServiciosParteUnicas($servicios_parte_original);

        $productos_unidades_medidas = $this->productosUnicos($productos_parte_original,$modalidadCobro); // Las unidades de medida siempre se obtienen de los datos originales

        $obras=[];
        $obras = $this->obrasUnicas($partes_certificado_original); // Las obras se obtienen de los datos originales
        $fechas = $this->getCombinados($servicios_parte_original); // Asume que getCombinados necesita los datos originales

        // Asegúrate de que generarTablasPorObras pueda manejar los datos originales o agrupados según sea necesario,
        // o si siempre necesita los datos originales para calcular los totales de las tablas por obra.
        // Para este ejemplo, asumimos que sigue usando los originales para los totales por obra.
        $servicios_obras =  DB::select('CALL getServiciosObrasCertificado(?,?)',array($id,$estado));
        $tablas_por_obras = $this->generarTablasPorObras($servicios_obras,$servicios_combinaciones,$productos_parte_original,$productos_unidades_medidas,$obras,$fechas);
        $agrupado_param = $agrupado;
        $evaluador = User::find($certificado->firma);

        $titulo1 = "CERTIFICADO" ;
        $titulo2 = $certificado->titulo;
        $nro = FormatearNumeroConCeros($certificado->numero,8);
        $fecha = date('d-m-Y', strtotime($certificado->fecha));
        $tipo_reporte = "CERTIFICADO N°:";

        // Recopilar todas las variables relevantes en un solo array para depuración
        $debugData = [
            'servicios_parte_para_vista' => $servicios_parte_para_vista,
            'productos_parte_para_vista' => $productos_parte_para_vista,
            'partes_certificado_para_vista' => $partes_certificado_para_vista,
            'tablas_por_obras' => $tablas_por_obras,
            'servicios_abreviaturas' => $servicios_abreviaturas,
            'productos_unidades_medidas' => $productos_unidades_medidas,
            'modalidadCobro' => $modalidadCobro,
            'obras' => $obras,
            'servicios_footer' => $servicios_footer,
            'agrupado_param' => $agrupado, // Para ver el valor del parámetro 'agrupado'
        ];

        // --- BLOQUE DE DEPURACIÓN ---
        // Descomenta las siguientes dos líneas para inspeccionar las variables
        // y ver la estructura de los datos antes de que se genere el PDF.
        // dd([
        //     'Datos Originales de Servicios' => $servicios_parte_original,
        //     'Servicios desde el Procedimiento Almacenado' => $servicios_obras,
        //     'Estructura de las Tablas Agrupadas' => $tablas_por_obras,
        // ]);
        // --- FIN DEL BLOQUE DE DEPURACIÓN ---

        $pdf = PDF::loadView('reportes.certificados.certificado-v2',compact(
            'fecha','nro','titulo1','titulo2','tipo_reporte','certificado','ot','cliente','contratista',
            'servicios_parte_para_vista', // Usar la variable que puede estar agrupada
            'productos_parte_para_vista', // Usar la variable que puede estar agrupada
            'modalidadCobro','partes_certificado_para_vista', // Usar la variable que puede estar agrupada
            'servicios_abreviaturas','productos_unidades_medidas','evaluador','obras','tablas_por_obras','servicios_footer','agrupado_param'
        ))->setPaper('a4','landscape')->setWarnings(false);
        return $pdf->stream();
    }

     public function exportarAExcel($id){
        $estado = "final";
        $result = [];
        $certificado = Certificados::findOrFail($id);
        $ot = Ots::find($certificado->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
        $productoCosturaOt = (new \App\Http\Controllers\CertificadosController)->getModalidadCobro($certificado->ot_id);
        $modalidadCobro = ( $productoCosturaOt->count() > 0 ) ? 'COSTURAS' : 'PLACAS';
        $servicios_parte = DB::select('CALL getServiciosCertificados(?,?)',array($id,$estado));
        $servicios_abreviaturas = $this->abreviaturasUnicas($servicios_parte);
        $productos_parte = DB::select('CALL getProductosCertificados(?,?,?)',array($id,$estado,$modalidadCobro));
        $productos_unidades_medidas = $this->productosUnicos($productos_parte,$modalidadCobro);
        $partes_certificado =DB::select('CALL PartesCertificadoReporte(?)',array($id));
        $servicios_footer = $this->ServiciosParteUnicas($servicios_parte);
        $result = array('certificado' => $certificado,
                        'ot'=> $ot,
                        'modalidadCobro' => $modalidadCobro,
                        'servicios_abreviaturas' => array_values($servicios_abreviaturas),
                        'productos_unidades_medidas' => array_values($productos_unidades_medidas),
                        'partes_certificados' => $partes_certificado,
                        'productos_parte' => $productos_parte,
                        'servicios_parte' => $servicios_parte,
                        'cliente' => $cliente,
                        'servicios_footer' => $servicios_footer);
        return response()->json($result);
    }

    public function getCombinados($servicios_parte){

        $array_fechas = [];

        foreach ($servicios_parte as $item) {

           $fechas[] = $item->fecha_formateada ;
        }

        $temp_fechas = array_unique($fechas);


        foreach ($temp_fechas as $item) {

           $obj = new stdClass();
           $obras = [];
           foreach ($servicios_parte as $servicio) {

                if($item == $servicio->fecha_formateada && $servicio->nro_combinacion)

                    $obras[] = $servicio->obra;

           }

           $temp_obras = array_unique($obras);
           $obj->fecha = $item;
           $obj->cantidad_obras_combinadas = count($temp_obras);
           $array_fechas[] = $obj;

        }

        return $array_fechas;

    }

    public function getCantidadCombinados($fechas,$fecha_formateada){

        foreach ($fechas as $item) {

            if($item->fecha == $fecha_formateada){

                return $item->cantidad_obras_combinadas ;
                break ;
            }
        }

    }

    public function generarTablasPorObras($servicios_obras,$servicios_combinaciones,$productos_parte,$productos_unidades_medidas,$obras,$fechas){

        $array_obra = [];
        $array_temp =[];

        foreach ($obras as $obra) {

            $objObra = new stdClass();
            $objObra->obra = $obra;
            $array_temp =[];
            $array_productos = [];

            foreach ($servicios_combinaciones as $combinacion) {

                $obj = new stdClass();
                $cant_total_servicio = 0;

                foreach ($servicios_obras as $servicio) {


                    if( ($servicio->obra == $obra) && ($servicio->combinacion == $combinacion)){

                             $cant_total_servicio =  $servicio->cantidad_total_servicio;

                    }
                }

                $obj->servicio = $combinacion;
                $obj->cant_total_servicio = $cant_total_servicio;
                $array_temp[]=$obj;

                }

                foreach ($productos_unidades_medidas as $unidad_medida) {

                    $objProducto = new stdClass();

                    $cant_total_producto = 0;
                    foreach ($productos_parte as $producto) {

                        if( ($producto->obra == $obra) && ($producto->unidad_medida_producto == $unidad_medida)){

                            $cant_total_producto = $cant_total_producto + $producto->cantidad;

                        }
                    }

                    $objProducto->producto = $unidad_medida;
                    $objProducto->cant_total_producto = $cant_total_producto;
                    $array_productos[]=$objProducto;
                }

                $objObra->productos = $array_productos;
                $objObra->servicios = $array_temp;
                $array_obra[]= $objObra;

         }

        return $array_obra;

    }

    public function generarFechaCorrelativa($partes_certificado){


     $long_partes = count($partes_certificado);

     if($long_partes == 0){

         return null ;

    }else{

        $fecha_inicial_formateada = $partes_certificado[0]->fecha_formateada;
        $fecha_final_formateada = $partes_certificado[0]->fecha_formateada;
        $fecha_inicial= $partes_certificado[0]->fecha;
        $fecha_final = $partes_certificado[0]->fecha;

        foreach ($partes_certificado as $parte) {

            if( $this->EsFechaIgualoSiguiente($parte->fecha,$fecha_final) ) {

                $fecha_final =  $parte->fecha;
                $fecha_final_formateada =$parte->fecha_formateada;

            }else{

                return null;
                break;
            }

        }

        return  ($fecha_inicial_formateada . '-' . $fecha_final_formateada);

    }

    }

    public function EsFechaIgualoSiguiente($fecha1,$fecha2){

        $result = false;

        if($fecha1 == $fecha2){

            $result = true;
        }else{

            $fecha1 = date('d-m-Y',strtotime($fecha1));
            $fecha2 = date('d-m-Y',strtotime($fecha2));

            // Sumo uno a la fecha que tenia para comparar con la seguiente del parte

            $fecha2 = strtotime ( '+1 day' , strtotime ( $fecha2 ) );
            $fecha2 = date('d-m-Y',strtotime($fecha2));

            if($fecha1 == $fecha2) {

                $result = true;
            }
        }

        return $result;
    }

    public function abreviaturasUnicas($servicios_parte){

        $array_temp = array();

        foreach ($servicios_parte as $servicio) {

            $array_temp[] = $servicio->abreviatura;

        }

        return array_unique($array_temp);

    }

    public function combinacionesUnicas($servicios_parte){

        $array_temp = [];

        foreach ($servicios_parte as $servicio) {

            $array_temp[] = $servicio->combinacion;

        }

        return array_unique($array_temp);

    }


    public function productosUnicos($productos_parte,$modalidadCobro){

      $array_temp = [];

      if($modalidadCobro == 'COSTURAS'){

          foreach ($productos_parte as $producto) {

              $aux1 = explode(' ',$producto->unidad_medida_producto);

              if(count($aux1) > 1){

                  $aux2 = explode('/',$aux1[1]);

                  if(count($aux2) > 1){

                      $frac = (float)$aux2[0]/(float)$aux2[1];
                      $producto->unidad_medida_producto_dec = (float)$aux1[0] + (float)$frac ;

                  }elseif(count($aux2) == 1) {

                      $producto->unidad_medida_producto_dec = (float)$aux1[0] + (float)$aux2[0] ;

                  }

              }elseif(count($aux1) == 1){

                  $aux3 = explode('/',$aux1[0]);

                  if(count($aux3) > 1){

                      $producto->unidad_medida_producto_dec = (float)$aux3[0] / (float)$aux3[1] ;

                  }elseif(count($aux3) == 1){

                      $producto->unidad_medida_producto_dec = (float)$aux3[0];

                  }
              }

          }

          usort($productos_parte, function($a, $b)
          {
              return  ((float)$a->unidad_medida_producto_dec < (float)$b->unidad_medida_producto_dec) ? -1 : 1;

          });
      }

        foreach ($productos_parte as $producto) {

            $array_temp[] = $producto->unidad_medida_producto;

        }

        $array = array_unique($array_temp);
        return $array;

    }

    public function obrasUnicas($partes_certificado){

        $array_temp = [];

        foreach ($partes_certificado as $parte) {

            $array_temp[] = $parte->obra;

        }

        $array_temp = array_unique($array_temp);

        return $array_temp;

    }

    public function ServiciosParteUnicas($servicios_parte){

        $array_temp = [];

        foreach ($servicios_parte as $servicio) {

            $array_temp[] = $servicio->abreviatura;

        }

        $array_temp = array_unique($array_temp);
        $array_temp2 = [];
        foreach ($array_temp as $item) {

            foreach ($servicios_parte as $servicio) {

                if($item == $servicio->abreviatura){

                    $obj = new stdClass();
                    $obj->abreviatura = $servicio->abreviatura;
                    $obj->descripcion_servicio = $servicio->descripcion_servicio;
                    $array_temp2[] = $obj;
                break;
                }
            }
        }

        return $array_temp2;

    }

}
