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
        $obras=[];  
        if(!$ot->obra){

            $obras = $this->getObrasPartes($partes_certificado);
           
        }
     //   dd($obras);
        $servicios_parte = DB::select('CALL getServiciosCertificados(?,?)',array($id,$estado));
        $servicios_abreviaturas = $this->convertToarrayServicios($servicios_parte);
        $productos_parte = DB::select('CALL getProductosCertificados(?,?,?)',array($id,$estado,$modalidadCobro));     
        $productos_unidades_medidas = $this->convertToarrayProductos($productos_parte);     
    
        $evaluador = User::find($certificado->firma);
        $pdf = PDF::loadView('reportes.certificados.certificado',compact('fecha','certificado','ot','cliente','contratista','servicios_parte','productos_parte','modalidadCobro','partes_certificado','servicios_abreviaturas','productos_unidades_medidas','evaluador','obras'))->setPaper('a4','landscape')->setWarnings(false);
      
        return $pdf->stream();

    }

    public function convertToarrayServicios($servicios_parte){

        $array_temp = [];

        foreach ($servicios_parte as $servicio) {
            
            $array_temp[] = $servicio->abreviatura;

        }

        return $array_temp;

    }

    public function convertToarrayProductos($productos_parte){

        $array_temp = [];

        foreach ($productos_parte as $producto) {
            
            $array_temp[] = $producto->unidad_medida_producto;

        }

        return $array_temp;

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
