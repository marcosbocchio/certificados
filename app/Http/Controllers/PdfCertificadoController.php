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
        $modalidadCobro = $productoCosturaOt->count() > 0 ? 'COSTURAS' : 'PLACAS';   
        $partes_certificado =DB::select('CALL PartesCertificadoReporte(?)',array($id));      
        $servicios_parte = DB::select('CALL getServiciosCertificados(?,?)',array($id,$estado));
        $servicios_abreviaturas = $this->convertToarrayServicios($servicios_parte);
        $productos_parte = DB::select('CALL getProductosCertificados(?,?,?)',array($id,$estado,$modalidadCobro));     
        $productos_unidades_medidas = $this->convertToarrayProductos($productos_parte);     
        $obras=[];  
        

            $obras = $this->getObrasPartes($partes_certificado);
            $tablas_por_obras = $this->generarTablasPorObras($servicios_parte,$servicios_abreviaturas,$productos_parte,$productos_unidades_medidas,$obras);           
         // dd($obras);
       
        //dd($productos_parte);
        $evaluador = User::find($certificado->firma);
        $pdf = PDF::loadView('reportes.certificados.certificado',compact('fecha','certificado','ot','cliente','contratista','servicios_parte','productos_parte','modalidadCobro','partes_certificado','servicios_abreviaturas','productos_unidades_medidas','evaluador','obras','tablas_por_obras'))->setPaper('a4','landscape')->setWarnings(false);
      
        return $pdf->stream();

    }

    public function generarTablasPorObras($servicios_parte,$servicios_abreviaturas,$productos_parte,$productos_unidades_medidas,$obras){
        
        $array_obra = [];
        $array_temp =[];    
     //  dd($obras,$servicios_abreviaturas,$servicios_parte,$productos_parte);

        foreach ($obras as $obra) {    

            $objObra = new stdClass();
            $objObra->obra = $obra;
            $array_temp =[];    
            $array_productos = [];
            foreach ($servicios_abreviaturas as $abreviatura) {                

                $obj = new stdClass();                
                
                
                $cant_total_servicio = 0;
                foreach ($servicios_parte as $servicio) {                
                    
                    if( ($servicio->obra == $obra) && ($servicio->abreviatura == $abreviatura)){
                        
                        $cant_total_servicio = $cant_total_servicio + $servicio->cantidad;
                        
                    }            
                }                    
                
                    $obj->servicio = $abreviatura;
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



    public function convertToarrayServicios($servicios_parte){

        $array_temp = [];

        foreach ($servicios_parte as $servicio) {
            
            $array_temp[] = $servicio->abreviatura;

        }

        return array_unique($array_temp);

    }

    public function convertToarrayProductos($productos_parte){

        $array_temp = [];

        foreach ($productos_parte as $producto) {
            
            $array_temp[] = $producto->unidad_medida_producto;

        }

        return array_unique($array_temp);

    }

    public function getObrasPartes($partes_certificado){

        $array_temp = [];

        foreach ($partes_certificado as $parte) {
            
            $array_temp[] = $parte->obra;

        }

        $array_temp = array_unique($array_temp);

        return $array_temp;        

    }

}
