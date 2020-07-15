<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtServicios;
use App\Clientes;
use App\Ots;
use App\Servicios;
use App\OtReferencias;
use App\Contratistas;
use App\User;

class PdfServiciosReferenciasController extends Controller
{
    public function imprimir($id){ 

        $ot_modelos = OtServicios::where('ot_referencia_id',$id)->first();             
        $ot = Ots::find($ot_modelos->ot_id);   
        $cliente = Clientes::find($ot->cliente_id);
        $modelo = Servicios::find($ot_modelos->servicio_id);
        $ot_referencia = OtReferencias::find($id);
        $tabla = 'Servicio';
        $evaluador = User::find($ot->firma);
        $contratista = Contratistas::find($ot->contratista_id);
        $observaciones = $ot_referencia->descripcion;       

        /*  Encabezado */
      
        $titulo = "REFERECIA OT";
        $tipo_reporte = 'OT Nº:';
        $nro = $ot->numero;
        $fecha = date('d-m-Y', strtotime($ot->fecha));
      
        $pdf = \PDF::loadView('reportes.ots.referencias-v2',compact('ot','titulo','nro','tipo_reporte','fecha','observaciones',
                                                                'cliente',
                                                                'contratista',
                                                                'modelo',
                                                                'ot_modelos',
                                                                'ot_referencia',
                                                                'evaluador',
                                                                'tabla'
                                                               ));
        return $pdf->stream();
        


    }
}
