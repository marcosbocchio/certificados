<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParteManual;
use PDF;
use App\Ots;
use App\Clientes;
use App\User;

class PdfManualController extends Controller
{
    public function imprimir($idParteManual)
    {
        // Obtener el ParteManual y sus detalles
        $parteManual = ParteManual::with('detalles')->findOrFail($idParteManual);
        $parteManual->fecha = date('d-m-Y', strtotime($parteManual->fecha));
        
        // Obtener la OT y el cliente asociado
        $ot = Ots::findOrFail($parteManual->ot_id);
        $cliente = Clientes::find($ot->cliente_id);
    
        // Recolectar todos los IDs de operador e inspector para los detalles
        // Ajustar los IDs para los nuevos campos de la tabla
        $operador1Ids = $parteManual->detalles->pluck('operador1')->unique()->filter();
        $operador2Ids = $parteManual->detalles->pluck('operador2')->unique()->filter();
        $inspector1Ids = $parteManual->detalles->pluck('inspector_id_1')->unique()->filter();
        $inspector2Ids = $parteManual->detalles->pluck('inspector_id_2')->unique()->filter();
    
        // Buscar los nombres de los operadores e inspectores en una sola consulta
        $operadores1 = User::whereIn('id', $operador1Ids)->get()->keyBy('id');
        $operadores2 = User::whereIn('id', $operador2Ids)->get()->keyBy('id');
        $inspectores1 = User::whereIn('id', $inspector1Ids)->get()->keyBy('id');
        $inspectores2 = User::whereIn('id', $inspector2Ids)->get()->keyBy('id');
    
        // Asignar nombres a cada detalle
        foreach ($parteManual->detalles as $detalle) {
            $detalle->operador1name = $operadores1[$detalle->operador1]->name ?? '-';
            $detalle->operador2name = $operadores2[$detalle->operador2]->name ?? '-';
            $detalle->inspector1_name = $inspectores1[$detalle->inspector_id_1]->name ?? '-';
            $detalle->inspector2_name = $inspectores2[$detalle->inspector_id_2]->name ?? '-';
        }
    
        // Preparar los datos para la vista del PDF
        $datos = [
            'parteManual' => $parteManual,
            'detalles' => $parteManual->detalles,
            'cliente' => $cliente,
            'ot' => $ot,
            'dividirTexto' => [$this, 'dividirTexto'], // Pasar la función de dividir texto
        ];
        
        // Cargar la vista del PDF y pasarle los datos
        $pdf = PDF::loadView('partes.pdf_parte', $datos);
        $pdf->setPaper('A4', 'landscape');
        
        // Retornar el PDF para visualización o descarga
        return $pdf->stream();
    }

    // Función para dividir texto en partes de longitud específica
    public function dividirTexto($texto, $longitud = 20)
    {
        return implode('<br>', str_split($texto, $longitud));
    }
}