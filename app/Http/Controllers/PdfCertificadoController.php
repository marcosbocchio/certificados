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
        $productos_parte = DB::select('CALL getProductosCertificados(?,?,?)',array($id,$estado,$modalidadCobro));    
        $productos_unidades_medidas = $this->productosUnicos($productos_parte);            
        $obras=[];
        $obras = $this->obrasUnicas($partes_certificado);
        $tablas_por_obras = $this->generarTablasPorObras($servicios_parte,$servicios_combinaciones,$productos_parte,$productos_unidades_medidas,$obras);  
        $evaluador = User::find($certificado->firma);
        $pdf = PDF::loadView('reportes.certificados.certificado',compact('fecha','certificado','ot','cliente','contratista','servicios_parte','productos_parte','modalidadCobro','partes_certificado','servicios_abreviaturas','productos_unidades_medidas','evaluador','obras','tablas_por_obras'))->setPaper('a4','landscape')->setWarnings(false);
      
        return $pdf->stream();

    }

    public function generarTablasPorObras($servicios_parte,$servicios_combinaciones,$productos_parte,$productos_unidades_medidas,$obras){
        
        $array_obra = [];
        $array_temp =[];    
     //  dd($obras,$servicios_combinaciones,$servicios_parte,$productos_parte);
        foreach ($obras as $obra) {    

            $objObra = new stdClass();
            $objObra->obra = $obra;
            $array_temp =[];    
            $array_productos = [];

            foreach ($servicios_combinaciones as $combinacion) {                

                $obj = new stdClass();                
                $cant_total_servicio = 0;

                foreach ($servicios_parte as $servicio) {                
                    
                    if( ($servicio->obra == $obra) && ($servicio->combinacion == $combinacion)){                        
                        
                        $cant_total_servicio = $cant_total_servicio + $servicio->cantidad;
                        
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
      
     // dd($array_obra);  

       foreach ($array_obra as $obra) {
           
            foreach($obra->servicios as $servicio){

                $servicio->cant_total_servicio = ($servicio->cant_total_servicio) / (substr_count($servicio->servicio,'+') + 1);

            }
       }
     //  dd($array_obra);  
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

        foreach ($productos_parte as $producto) {
            
            $array_temp[] = $producto->unidad_medida_producto;

        }

        return array_unique($array_temp);

    }

    public function obrasUnicas($partes_certificado){

        $array_temp = [];

        foreach ($partes_certificado as $parte) {
            
            $array_temp[] = $parte->obra;

        }

        $array_temp = array_unique($array_temp);

        return $array_temp;        

    }

}