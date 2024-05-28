<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParteManual;
use PDF;
use App\Ots;
use App\Contratistas;
use App\Clientes;
use App\User;

class PdfManualController extends Controller
{
    public function imprimir($idParteManual)
{
    $parteManual = ParteManual::with('detalles')->findOrFail($idParteManual);
    $parteManual->fecha = date('d-m-Y', strtotime($parteManual->fecha));
    $ot = Ots::findOrFail($parteManual->ot_id);
    $cliente = Clientes::find($ot->cliente_id);

    // Recolectar todos los IDs de operador e inspector para los detalles
    $operador1Ids = $parteManual->detalles->pluck('operador1')->unique()->filter();
    $operador2Ids = $parteManual->detalles->pluck('operador2')->unique()->filter();
    $inspectorIds = $parteManual->detalles->pluck('inspector_id')->unique()->filter();

    // Buscar los nombres de los operadores e inspectores en una sola consulta
    $operadores1 = User::whereIn('id', $operador1Ids)->get()->keyBy('id');
    $operadores2 = User::whereIn('id', $operador2Ids)->get()->keyBy('id');
    $inspectores = User::whereIn('id', $inspectorIds)->get()->keyBy('id');

    // Asignar nombres a cada detalle
    foreach ($parteManual->detalles as $detalle) {
        $detalle->operador1name = $operadores1[$detalle->operador1]->name ?? '-';
        $detalle->operador2name = $operadores2[$detalle->operador2]->name ?? '-';
        $detalle->inspector_name = $inspectores[$detalle->inspector_id]->name ?? '-';
    }
    // Preparar los datos para la vista del PDF
    $datos = [
        'parteManual' => $parteManual,
        'detalles' => $parteManual->detalles,
        'cliente' => $cliente,
        'ot' => $ot,
    ];
    
    // Cargar la vista del PDF y pasarle los datos
    $pdf = PDF::loadView('partes.pdf_parte', $datos);
    $pdf->setPaper('A4', 'landscape');
    
    // Retornar el PDF para visualización o descarga
    return $pdf->stream();
}
}