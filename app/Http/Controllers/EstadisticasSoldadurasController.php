<?php

namespace App\Http\Controllers;

use App\Ots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PDO;
class EstadisticasSoldadurasController extends Controller
{

    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|R_estadisticas_soldaduras'],['only' => ['callView']]);

    }

    public function callView($ot_id){

        $user = auth()->user();
        $ot_prop = Ots::with('cliente')->find($ot_id);
        $header_titulo = "Reporte";
        $header_descripcion ="Análisis de rechazo y defectología";
        return view('soldadores.estadisticas_soldaduras',compact('user','ot_prop','header_titulo','header_descripcion'));

    }
    /* TAB  INDICES DE RECHAZOS*/

    public function AnalisisRechazosEspesor($informes_ids){

        $items = DB::select('CALL AnalisisSoldadurasRechazosEspesor(?)',array($informes_ids));

        return $items;

    }

    public function AnalisisRechazosDiametro($informes_ids){

        return DB::select('CALL AnalisisSoldadurasRechazosDiametro(?)',array($informes_ids));

    }

     /* TAB DEFECTOLOGIA*/

    public function AnalisisDefectosPosicion($informes_ids){

        return DB::select('CALL AnalisisSoldadurasDefectosPosicion(?)',array($informes_ids));

    }

    public function AnalisisSoldadurasDetalleDefectos($informes_ids){

        return DB::select('CALL AnalisisSoldadurasDetalleDefectos(?)',array($informes_ids));

    }


    /* TAB DEFECTOLOGIA/PRODUCCION*/

    public function AnalisisSoldadurasDefectosSoldador($informes_ids){

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        return  DB::select('CALL AnalisisSoldadurasDefectosSoldador(?)',array($informes_ids));



    }


    public function CantRechazosSoldaduras($informes_ids){

        $total = DB::select('select CantRechazosSoldaduras(?) as valor',array($informes_ids));

        return $total[0]->valor;
    }

     /* TAB INDICACIONES */

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

    public function CantSoldadurasInformes($informes_ids){

        $total = DB::select('select CantSoldadurasInformes(?) as valor',array($informes_ids));

        return $total[0]->valor;

    }






}
