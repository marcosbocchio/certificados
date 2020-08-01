<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function AnalisisSoldadurasDetalleDefectos($informes_ids){

        return DB::select('CALL AnalisisSoldadurasDetalleDefectos(?)',array($informes_ids));    

    }

    public function CantSoldadurasInformes($informes_ids){

        DB::enableQueryLog();

        $total = DB::select('select CantSoldadurasInformes(?) as valor',array($informes_ids));  
        Log::debug("CantSoldadurasInformes " . $total[0]->valor);
        
        return $total[0]->valor;

    }

    public function CantRechazosSoldaduras($informes_ids){

        DB::enableQueryLog();

        $total = DB::select('select CantRechazosSoldaduras(?) as valor',array($informes_ids));  
        Log::debug("CantRechazosSoldaduras " . $total[0]->valor);

        return $total[0]->valor;
    }



 
}
