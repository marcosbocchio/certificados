<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\TipoEquipamiento;

class PdfInternosEquiposController extends Controller
{
    public function imprimir($tipo_equipamiento_id, $vencidas_sn, $noVencidas_sn) {

        $tipo_equipamiento = TipoEquipamiento::find($tipo_equipamiento_id);
        $tipo_equipamiento_id = $tipo_equipamiento_id !== 'null' ? $tipo_equipamiento_id : '0';
        $vencidas_sn = $vencidas_sn == 'true' ? 1 : 0;
        $noVencidas_sn = $noVencidas_sn == 'true' ? 1 : 0;
        $titulo = 'INTERNO EQUIPOS RI';
        $data = DB::select(DB::raw('CALL ReporteInternoEquipos(?,?,?)'),array($tipo_equipamiento_id,$vencidas_sn,$noVencidas_sn));     
        Log::debug('Desde reporte: '. json_encode($tipo_equipamiento));        
        $pdf = \PDF::loadView('reportes.interno-equipos.interno_equipos_ri',compact('titulo','tipo_equipamiento','vencidas_sn','noVencidas_sn','data'))->setPaper('a4','portrait')->setWarnings(false);

        return $pdf->stream();
      
    }
}
