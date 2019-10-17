<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;
use App\MetodoEnsayos;
use App\DiametrosEspesor;
use Illuminate\Support\Facades\Auth;
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
                    ->selectRaw('informes.numero,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha,informes.id,metodo_ensayos.metodo as metodo,users.name,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,informes.prefijo as prefijo,firma')                 
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
            case 'PM':
                return redirect()->route('InformePmCreate',array('ot_id' => $ot_id));
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
         case 'PM':
            return redirect()->route('InformePmEdit',array('ot_id' => $ot_id, 'id' => $id));
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

    public function saveInforme($request,$informe){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }
       
        //revisar esto 

        $metodo_ensayo = MetodoEnsayos::where('metodo',$request->metodo_ensayo)->first();
      
        
        $informe->ot_id  = $request->ot['id'];
        $informe->procedimiento_informe_id = $request->procedimiento['ot_procedimientos_propios_id'];
    
        if ($request->diametro =='CHAPA'){
    
          $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro)                                 
                                              ->first(); 
    
          $informe->diametro_espesor_id = $diametro_espesor['id'];
          $informe->espesor_chapa       = $request->espesor_chapa;
    
        }else{
    
          $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro) 
                                              ->where('espesor',$request->espesor)
                                              ->first();
    
          $informe->diametro_espesor_id = $diametro_espesor['id'];
    
        } 
    
        $informe->equipo_id = $request->equipo['id'];
        $informe->Kv = $request->kv;
        $informe->ma =$request->ma;  
        $informe->metodo_ensayo_id  = $metodo_ensayo['id'];
        $informe->norma_evaluacion_id = $request->norma_evaluacion['id'];
        $informe->norma_ensayo_id = $request->norma_ensayo['id'];
        $informe->tecnica_id = $request->tecnica['id'];
        $informe->user_id = $user_id;
        $informe->ejecutor_ensayo_id = $request->ejecutor_ensayo['ot_operario_id'];
        $informe->material_id = $request->material['id'];
        $informe->fecha = date('Y-m-d',strtotime($request->fecha));
        $informe->numero = $request->numero_inf;
        $informe->prefijo = $request->prefijo;  
        $informe->componente = $request->componente;
        $informe->procedimiento_soldadura = $request->procedimiento_soldadura;
        $informe->plano_isom = $request->plano_isom;
        $informe->eps = $request->eps;
        $informe->pqr = $request->pqr;
        $informe->observaciones = $request->observaciones;
        $informe->save();   
        
        return $informe;
      }

     public function OtInformesPendienteParteDiario($ot_id){

        return  informe::with('metodoEnsayos')
                         ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                         ->where('parte_id',null)
                         ->where('ot_id',$ot_id)
                         ->selectRaw('informes.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada')
                         ->get();
     }

     public function OtInformesPendienteEditableParteDiario($ot_id,$parte_id){

        $infomes_pendientes =informe::with('metodoEnsayos')
                                        ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                                        ->where('parte_id',null)
                                        ->where('ot_id',$ot_id)
                                        ->selectRaw('informes.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada');
                                        
        $infomes = informe::with('metodoEnsayos')
                                    ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                                   
                                    ->where('parte_id',$parte_id)
                                    ->where('ot_id',$ot_id)
                                    ->selectRaw('informes.* , 0 as informe_sel,CONCAT(metodo_ensayos.metodo,LPAD(informes.numero, 3, "0")) as numero_formateado,DATE_FORMAT(informes.fecha,"%d/%m/%Y")as fecha_formateada')
                                    ->union($infomes_pendientes)
                                    ->get();

        return $infomes;
     }


     public function setParteId($parte_id,$informe_id){

        $informe  = Informe::find($informe_id);
        $informe->parte_id = $parte_id;
        $informe->save();
     }

     public function deleteParteId($parte_id){

        $informes  = Informe::where('parte_id',$parte_id)->get();
        foreach ($informes as $informe) {
            $informe->parte_id = null;
            $informe->save();
        }
       
     }

    public function firmar($id){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $informe = Informe::findOrFail($id);
        $informe->firma =  $user_id;
        $informe->save();

        return $informe;

    } 
   
}
