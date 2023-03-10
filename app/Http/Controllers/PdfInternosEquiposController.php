<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\TipoEquipamiento;

class PdfInternosEquiposController extends Controller
{
    public function imprimir($tipo_equipamiento_id, $vencidas_sn, $noVencidas_sn,$todos_sn) {

        $tipo_equipamiento = TipoEquipamiento::find($tipo_equipamiento_id);
        $tipo_equipamiento_id = $tipo_equipamiento_id !== 'null' ? $tipo_equipamiento_id : '0';
        $vencidas_sn = $vencidas_sn == 'true' ? 1 : 0;
        $noVencidas_sn = $noVencidas_sn == 'true' ? 1 : 0;
        $todos_sn = $todos_sn == 'true' ? 1 : 0;

        $titulo = 'INTERNO EQUIPOS RI';
        $data = DB::select(DB::raw('CALL ReporteInternoEquipos(?,?,?,?)'),array($tipo_equipamiento_id,$vencidas_sn,$noVencidas_sn,$todos_sn));

        Log::debug('Desde reporte: '. json_encode($tipo_equipamiento_id));
        if($tipo_equipamiento_id === "4") {
            foreach ($data as $item) {
                if($item->interno_fuente_id){
                    $item->curie_actual = curie($item->interno_fuente_id);
                }
              }
        }
        $pdf = $tipo_equipamiento_id === "4" ? \PDF::loadView('reportes.interno-equipos.interno_equipos_ri_proyector',compact('titulo','tipo_equipamiento','vencidas_sn','noVencidas_sn','todos_sn','data'))->setPaper('a4','landscape')->setWarnings(false) : \PDF::loadView('reportes.interno-equipos.interno_equipos_ri',compact('titulo','tipo_equipamiento','vencidas_sn','noVencidas_sn','todos_sn','data'))->setPaper('a4','portrait')->setWarnings(false);

        return $pdf->stream();

    }
}
