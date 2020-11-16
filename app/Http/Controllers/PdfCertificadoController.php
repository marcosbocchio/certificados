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

class PdfCertificadoController extends Controller
{
    public function imprimir($id,$estado){

        $certificado = Certificados::findOrFail($id);
        $ot = Ots::find($certificado->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
        $contratista = Contratistas::find($ot->contratista_id);
        $fecha = date("Y/m/d H:i:s");
        $productoCosturaOt = (new \App\Http\Controllers\CertificadosController)->getModalidadCobro($certificado->ot_id);
        $modalidadCobro = ( $productoCosturaOt->count() > 0 ) ? 'COSTURAS' : 'PLACAS';
        $partes_certificado =DB::select('CALL PartesCertificadoReporte(?)',array($id));
        $servicios_parte = DB::select('CALL getServiciosCertificados(?,?)',array($id,$estado));
        $servicios_abreviaturas = $this->abreviaturasUnicas($servicios_parte);
        $servicios_combinaciones = $this->combinacionesUnicas($servicios_parte);
        $servicios_footer = $this->ServiciosParteUnicas($servicios_parte);
        $productos_parte = DB::select('CALL getProductosCertificados(?,?,?)',array($id,$estado,$modalidadCobro));
        $productos_unidades_medidas = $this->productosUnicos($productos_parte);
        $obras=[];
        $obras = $this->obrasUnicas($partes_certificado);
        $fechas = $this->getCombinados($servicios_parte);
        $servicios_obras =  DB::select('CALL getServiciosObrasCertificado(?,?)',array($id,$estado));

        $tablas_por_obras = $this->generarTablasPorObras($servicios_obras,$servicios_combinaciones,$productos_parte,$productos_unidades_medidas,$obras,$fechas);
        $evaluador = User::find($certificado->firma);

        /*  Encabezado */

        $titulo1 = "CERTIFICADO" ;
        $titulo2 = $certificado->titulo;
        $nro = FormatearNumeroConCeros($certificado->numero,8);
        $fecha = date('d-m-Y', strtotime($certificado->fecha));
        $tipo_reporte = "CERTIFICADO N°:";

        $pdf = PDF::loadView('reportes.certificados.certificado-v2',compact('fecha','nro','titulo1','titulo2','tipo_reporte','certificado','ot','cliente','contratista','servicios_parte','productos_parte','modalidadCobro','partes_certificado','servicios_abreviaturas','productos_unidades_medidas','evaluador','obras','tablas_por_obras','servicios_footer'))->setPaper('a4','landscape')->setWarnings(false);
        return $pdf->stream();


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

        $array_temp = [];

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


    public function productosUnicos($productos_parte){

        $array_temp = [];
        dd($productos_parte);
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
