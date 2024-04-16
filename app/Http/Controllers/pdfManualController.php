<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParteManual;
use PDF;

class PdfManualController extends Controller
{
    public function imprimir($idParteManual)
    {
        // Obtener el parte manual con sus detalles
        $parteManual = ParteManual::with('detalles')->findOrFail($idParteManual);

        // Preparar los datos para la vista del PDF
        $datos = [
            'parteManual' => $parteManual,
            'detalles' => $parteManual->detalles,
        ];

        // Cargar la vista del PDF y pasarle los datos
        $pdf = PDF::loadView('partes.pdf_parte', $datos);
        $pdf->setPaper('A4', 'landscape');
        
        // Retornar el PDF para visualización o descarga
        return $pdf->stream();
    }
}