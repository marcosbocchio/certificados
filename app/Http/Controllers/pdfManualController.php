<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParteManual;
use PDF;
use App\Ots;
use App\Contratistas;
use App\Clientes;

class PdfManualController extends Controller
{
    public function imprimir($idParteManual)
    {
        // Obtener el parte manual con sus detalles
        $parteManual = ParteManual::with('detalles')->findOrFail($idParteManual);
        $parteManual->fecha = date('d-m-Y', strtotime($parteManual->fecha));
        $ot = Ots::findOrFail($parteManual->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
        // Preparar los datos para la vista del PDF
        $datos = [
            'parteManual' => $parteManual,
            'detalles' => $parteManual->detalles,
            'cliente' =>$cliente,
            'ot'=>$ot,
        ];
        
        // Cargar la vista del PDF y pasarle los datos
        $pdf = PDF::loadView('partes.pdf_parte', $datos);
        $pdf->setPaper('A4', 'landscape');
        
        // Retornar el PDF para visualización o descarga
        return $pdf->stream();
    }
}