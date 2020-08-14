<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PDO;
class EstadisticasSoldadurasController extends Controller
{

    public function viewSoldaduras(){

        $user = auth()->user();
        $header_titulo = "Reporte";
        $header_descripcion ="Análisis de rechazo y defectología";
        return view('soldadores.estadisticas_soldaduras',compact('user','header_titulo','header_descripcion'));

    }

    public function AnalisisRechazosEspesor($informes_ids){

        return DB::select('CALL AnalisisSoldadurasRechazosEspesor(?)',array($informes_ids));

    }

    public function AnalisisDefectosPosicion($informes_ids){

        return DB::select('CALL AnalisisSoldadurasDefectosPosicion(?)',array($informes_ids));

    }

    public function AnalisisSoldadurasDefectosSoldador($informes_ids){

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        return  DB::select('CALL AnalisisSoldadurasDefectosSoldador(?)',array($informes_ids));

    }


    public function AnalisisSoldadurasDetalleDefectos($informes_ids){

        return DB::select('CALL AnalisisSoldadurasDetalleDefectos(?)',array($informes_ids));

    }

    public function CantSoldadurasInformes($informes_ids){

        $total = DB::select('select CantSoldadurasInformes(?) as valor',array($informes_ids));

        return $total[0]->valor;

    }

    public function CantRechazosSoldaduras($informes_ids){

        $total = DB::select('select CantRechazosSoldaduras(?) as valor',array($informes_ids));

        return $total[0]->valor;
    }

    public function AnalisisSoldadurasIndicaciones($informes_ids){

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        $res =  DB::select('CALL AnalisisSoldadurasIndicaciones(?)',array($informes_ids));

        DB::select('CALL DropTemporaryTableDefectoPosReduce()');

        return $res;

    }

    public function AnalisisSoldadurasDetalleIndicaciones($informes_ids){

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        $res =  DB::select('CALL AnalisisSoldadurasDetalleIndicaciones(?)',array($informes_ids));

        DB::select('CALL DropTemporaryTableDefectoPosReduce()');

        return $res;

    }


    public function AnalisisSoldadurasIndicacionesPosicion($posicion, $diametro,$informes_ids){

        $diametro_formateado = str_replace('--','/',$diametro);

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        $res =  DB::select('CALL AnalisisSoldadurasIndicacionesPosicion(?,?,?)',array($posicion,$diametro_formateado,$informes_ids));

        DB::select('CALL DropTemporaryTableDefectoPosReduce()');

        return $res;

    }




}
