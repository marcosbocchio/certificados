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
    protected function resolveInformesIds(Request $request, $informes_ids = null)
    {
        if ($informes_ids !== null && $informes_ids !== '') {
            return $informes_ids;
        }

        $payload = $request->input('informes_ids', []);

        if (is_array($payload)) {
            $payload = array_values(array_filter($payload, function ($item) {
                return $item !== null && $item !== '';
            }));

            return implode(',', $payload);
        }

        return (string) $payload;
    }

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

    public function AnalisisRechazosEspesor(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        $items = DB::select('CALL AnalisisSoldadurasRechazosEspesor(?)',array($informes_ids));

        return $items;

    }

    public function AnalisisRechazosDiametro(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        return DB::select('CALL AnalisisSoldadurasRechazosDiametro(?)',array($informes_ids));

    }

     /* TAB DEFECTOLOGIA*/

    public function AnalisisDefectosPosicion(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        return DB::select('CALL AnalisisSoldadurasDefectosPosicion(?)',array($informes_ids));

    }

    public function AnalisisSoldadurasDetalleDefectos(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        return DB::select('CALL AnalisisSoldadurasDetalleDefectos(?)',array($informes_ids));

    }


    /* TAB DEFECTOLOGIA/PRODUCCION*/

    public function AnalisisSoldadurasDefectosSoldador(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        return  DB::select('CALL AnalisisSoldadurasDefectosSoldador(?)',array($informes_ids));



    }


    public function CantRechazosSoldaduras(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        $total = DB::select('select CantRechazosSoldaduras(?) as valor',array($informes_ids));

        return $total[0]->valor;
    }

     /* TAB INDICACIONES */

    public function AnalisisSoldadurasIndicaciones(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        $res =  DB::select('CALL AnalisisSoldadurasIndicaciones(?)',array($informes_ids));

        DB::select('CALL DropTemporaryTableDefectoPosReduce()');

        return $res;

    }

    public function AnalisisSoldadurasDetalleIndicaciones(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        $res =  DB::select('CALL AnalisisSoldadurasDetalleIndicaciones(?)',array($informes_ids));

        DB::select('CALL DropTemporaryTableDefectoPosReduce()');

        return $res;

    }


    public function AnalisisSoldadurasIndicacionesPosicion(Request $request, $posicion, $diametro, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        $diametro_formateado = str_replace('--','/',$diametro);

        DB::select('CALL CreateTemporaryTableDefectoPosReduce(?)',array($informes_ids));

        $res =  DB::select('CALL AnalisisSoldadurasIndicacionesPosicion(?,?,?)',array($posicion,$diametro_formateado,$informes_ids));

        DB::select('CALL DropTemporaryTableDefectoPosReduce()');

        return $res;

    }

    public function CantSoldadurasInformes(Request $request, $informes_ids = null){
        $informes_ids = $this->resolveInformesIds($request, $informes_ids);

        $total = DB::select('select CantSoldadurasInformes(?) as valor',array($informes_ids));

        return $total[0]->valor;

    }






}
