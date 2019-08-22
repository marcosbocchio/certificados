<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;
use App\MetodoEnsayos;
use Illuminate\Support\Facades\DB;


class InformesController extends Controller
{

    public function index($id)
    {
        $header_titulo = "Informes OT";
        $header_descripcion ="Alta | Modificación";    
        $user = auth()->user()->name;
        
     // $ot_informes = Informe::where('ot_id',$id)->get();

        $ot_informes = DB::table('informes')
                    ->join('users','users.id','=','informes.user_id')
                    ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                    ->where('informes.ot_id',$id)
                    ->selectRaw('informes.numero,DATE_FORMAT(informes.created_at,"%d/%m/%Y")as fecha,informes.id,metodo_ensayos.metodo as metodo,users.name,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado')                 
                    ->get();

        $ot_metodos_ensayos = DB::table('ots')
                                   ->join('ot_servicios','ot_servicios.ot_id','=','ots.id')
                                   ->join('servicios','servicios.id','=','ot_servicios.servicio_id') 
                                   ->join('metodo_ensayos','metodo_ensayos.id','=','servicios.metodo_ensayo_id')
                                   ->where('ots.id',$id)
                                   ->select('metodo_ensayos.*')
                                   ->distinct()
                                   ->get();

        return view('ot-informes.index',compact('id',
                                        'ot_informes',
                                        'ot_metodos_ensayos',                                   
                                        'user',                                       
                                        'header_titulo',
                                        'header_descripcion'));

    }

    public function OtInformesTotal($ot_id){


        return Informe::where('ot_id',$ot_id)->count(); 

    }

    public function create($ot_id,$metodo){        


        switch ($metodo) {
            case 'RI':
                return redirect()->route('InformeRiCreate',array('ot_id' => $ot_id));
                break;        
         
        }

    }

    public function edit($ot_id,$id) {

    $metodo_ensayo = DB::table('informes')
              ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
              ->where('informes.id',$id)
              ->where('informes.ot_id',$ot_id)
              ->select('metodo_ensayos.*')
              ->first();      
    
    switch ($metodo_ensayo->metodo) {
        case 'RI':
            return redirect()->route('InformeRiEdit',array('ot_id' => $ot_id, 'id' => $id));
            break;        
     
    }
  

    }

    public function GenerarNumeroInforme($ot_id,$metodo){


        $numero_informe = DB::table('informes')                        
                          ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                          ->where('informes.ot_id',$ot_id)
                          ->where('metodo_ensayos.metodo',$metodo)
                          ->orderBy('informes.numero', 'DESC')   
                          ->limit(1)   
                          ->selectRaw('informes.numero + 1 as numero_informe')                    
                          ->get();    

        return  $numero_informe;                 

       
    }
   
}
