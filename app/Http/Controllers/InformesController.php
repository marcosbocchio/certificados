<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\Informe;
use App\MetodoEnsayos;
use App\DiametrosEspesor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\OtProcedimientosPropios;
use App\InformesView;
use App\InformesImportados;
use \stdClass;

class InformesController extends Controller
{

    public function index($id)
    {
        $header_titulo = "Informes";
        $header_descripcion ="Alta | Modificación";    
        $user = auth()->user()->name;

        $ot = Ots::where('id',$id)->with('cliente')->first();
        $header_sub_titulo =' / ' .$ot->cliente->nombre_fantasia . ' / OT N°: ' . $ot->numero;

        $ot_metodos_ensayos = DB::table('ots')
                                   ->join('ot_servicios','ot_servicios.ot_id','=','ots.id')
                                   ->join('servicios','servicios.id','=','ot_servicios.servicio_id') 
                                   ->join('metodo_ensayos','metodo_ensayos.id','=','servicios.metodo_ensayo_id')
                                   ->where('ots.id',$id)
                                   ->select('metodo_ensayos.*')
                                   ->distinct()
                                   ->get();

        return view('ot-informes.index',compact('ot',
                                        'ot_metodos_ensayos',                                   
                                        'user',                                       
                                        'header_titulo',
                                        'header_sub_titulo',
                                        'header_descripcion'));

    }

    public function paginate(Request $request,$id){

          return DB::table('informes_view')
                     ->where('ot_id',$id) 
                     ->orderBy('fecha','DESC')     
                     ->orderBy('id','DESC')           
                     ->paginate(10);
      
    }

    public function OtInformesTotal($ot_id){


        return InformesView::where('ot_id',$ot_id)->count(); 

    }

    public function create($ot_id,$metodo){        


        switch ($metodo) {
            case 'RI':
                return redirect()->route('InformeRiCreate',array('ot_id' => $ot_id));
                break;  

            case 'PM':
                return redirect()->route('InformePmCreate',array('ot_id' => $ot_id));
                break;

            case 'LP':
                return redirect()->route('InformeLpCreate',array('ot_id' => $ot_id));
                break;      

            case 'US':
                return redirect()->route('InformeUsCreate',array('ot_id' => $ot_id));
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
            
         case 'LP':
            return redirect()->route('InformeLpEdit',array('ot_id' => $ot_id, 'id' => $id));
            break;

        case 'US':
            return redirect()->route('InformeUsEdit',array('ot_id' => $ot_id, 'id' => $id));
            break;
     
    }
  

    }

    public function GenerarNumeroInforme($ot_id,$metodo){

        $metodo_ensayo = MetodoEnsayos::where('metodo',$metodo)->first();

        if ($metodo_ensayo->importable_sn){

            $numero_informe = DB::table('informes_importados')                        
                                ->join('metodo_ensayos','metodo_ensayos.id','=','informes_importados.metodo_ensayo_id')
                                ->where('informes_importados.ot_id',$ot_id)
                                ->where('metodo_ensayos.metodo',$metodo)
                                ->orderBy('informes_importados.numero', 'DESC')   
                                ->limit(1)   
                                ->selectRaw('informes_importados.numero + 1 as numero_informe')                    
                                ->get();    

        }else{
    
            $numero_informe = DB::table('informes')                        
                                ->join('metodo_ensayos','metodo_ensayos.id','=','informes.metodo_ensayo_id')
                                ->where('informes.ot_id',$ot_id)
                                ->where('metodo_ensayos.metodo',$metodo)
                                ->orderBy('informes.numero', 'DESC')   
                                ->limit(1)   
                                ->selectRaw('informes.numero + 1 as numero_informe')                    
                                ->get();    


        }

        return  $numero_informe;                 

    }

    public function saveInforme($request,$informe){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }
        
        $metodo_ensayo = MetodoEnsayos::where('metodo',$request->metodo_ensayo)->first();
      
        $informe->ot_id  = $request->ot['id'];
        $informe->obra = $request->obra;
        
        If(!isset($request->procedimiento['ot_procedimientos_propios_id'])){
        
        $ot_procedimieto_propio = new OtProcedimientosPropios;
        (new \App\Http\Controllers\OtProcedimientosPropiosController)->store($request->procedimiento['id'],$ot_procedimieto_propio,$request->ot['id']);
        $informe->procedimiento_informe_id = $ot_procedimieto_propio->id;

        }else{

                 $informe->procedimiento_informe_id = $request->procedimiento['ot_procedimientos_propios_id'];
          }

        if (($request->diametro['diametro'] =='CHAPA') || ($request->diametro['diametro'] =='VARIOS')){
    
          $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro['diametro'])                                 
                                              ->first(); 
    
          $informe->diametro_espesor_id = $diametro_espesor['id'];

          
    
        }else{
    
          $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro['diametro']) 
                                              ->where('espesor',$request->espesor['espesor'])
                                              ->first();
    
          $informe->diametro_espesor_id = $diametro_espesor['id'];
    
        } 
        $informe->espesor_chapa       = $request->espesor_chapa;
        $informe->interno_equipo_id = $request->interno_equipo['id'];
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

        $informes = DB::select('CALL InformesPendientesSinParteDiario(?,?)',array($ot_id,0));
        
        return $informes;


     }

     public function OtInformesPendienteEditableParteDiario($ot_id,$parte_id){

        $infomes_pendientes = DB::select('CALL InformesPendientesSinParteDiario(?,?)',array($ot_id,$parte_id));
                                        
        return $infomes_pendientes;
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

    public function clonar($id){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $clonar = DB::select('CALL ClonarInforme(?,?)',array($id,$user_id));

        return $clonar;

    } 

    public function getObraInforme($informe_id,$importado_sn){
       
        
       $valor = DB::select('CALL getObraInforme(?,?)',array($informe_id,$importado_sn));
    
       return $valor[0]->obra;
       
    }
   
}
