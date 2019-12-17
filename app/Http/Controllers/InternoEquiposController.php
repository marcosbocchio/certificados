<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternoEquipos;
use App\Http\Requests\InternoEquipoRequest;
use Illuminate\Support\Facades\DB;
use App\Fuentes;
use \stdClass;

class InternoEquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function paginate(Request $request){
      
        $interno_equipos = InternoEquipos::orderBy('id','DESC')->with('ot.localidad.provincia','ot.cliente')->with('equipo')->with('internoFuente.fuente')->paginate(10);

        foreach ( $interno_equipos as $interno_equipo) {
          
          if($interno_equipo->internoFuente){

            $interno_fuente = $interno_equipo->internoFuente;
            $fuente = $interno_fuente->fuente;         
            $curie_actual = curie($interno_fuente->id);
            $interno_fuente->curie_actual = $curie_actual;
          
          }
       
     
        }

        return $interno_equipos;
  
      }

    public function callView()
      {   
          $user = auth()->user()->name; 
          $header_titulo = "Interno Equipos";
          $header_descripcion ="Alta | Baja | Modificación"; 
        
          return view('interno_equipos',compact('user','header_titulo','header_descripcion'));
  
      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getEquiposMetodoActivos($metodo){
      
        if($metodo != 'null'){

            return  InternoEquipos::join('equipos','equipos.id','=','interno_equipos.equipo_id') 
                                    ->join('metodo_ensayos','equipos.metodo_ensayo_id','=','metodo_ensayos.id')
                                    ->where('metodo_ensayos.metodo',$metodo)
                                    ->where('interno_equipos.activo_sn',1)
                                    ->Select('interno_equipos.*')
                                    ->with('equipo')
                                    ->with('internoFuente')
                                    ->get();

        }else{

          return InternoEquipos::where('interno_equipos.activo_sn',1)
                                  ->with('equipo')
                                  ->with('internoFuente')
                                  ->Select('interno_equipos.*')
                                  ->get();

        }
                  


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InternoEquipoRequest $request){


        $interno_equipo = new InternoEquipos;   
    
        DB::beginTransaction();
        try { 
    
            $this->saveInternoEquipo($request,$interno_equipo);

            if($interno_equipo->interno_fuente_id){
                 (new \App\Http\Controllers\TrazabilidadFuenteController)->saveTrazabilidadfuente($interno_equipo->id,$request['interno_fuente']['id']);
            }
            DB::commit(); 
    
          } catch (Exception $e) {
      
            DB::rollback();
            throw $e;      
            
          }       
    
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return InternoEquipos::where('id',$id)
                               ->with('ot')
                               ->select('interno_equipos.*')
                               ->first(); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InternoEquipoRequest $request, $id){

        $interno_equipo = InternoEquipos::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveInternoEquipo($request,$interno_equipo);
              if($interno_equipo->interno_fuente_id){
                (new \App\Http\Controllers\TrazabilidadFuenteController)->saveTrazabilidadfuente($interno_equipo->id,$request['interno_fuente']['id']);
              }
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }

      public function saveInternoEquipo($request,$interno_equipo){

        $interno_equipo->nro_serie = $request['nro_serie'];
        $interno_equipo->nro_interno = $request['nro_interno'];
        $interno_equipo->voltaje = $request['voltaje'];
        $interno_equipo->amperaje = $request['amperaje'];
        $interno_equipo->activo_sn = $request['activo_sn'];       
        $interno_equipo->equipo_id = $request['equipo']['id'];
        $interno_equipo->interno_fuente_id = $request['interno_fuente']['id'];
        $interno_equipo->save();
    
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interno_equipo = InternoEquipos::find($id);    
        $interno_equipo->delete();
    }


    public function OtInternoEquiposTotal($ot_id){


      return InternoEquipos::where('ot_id',$ot_id)->count(); 

  }

  public function OtInternoEquipos($ot_id){

        $header_titulo = "Equipos OT";
        $header_descripcion ="Baja";      
        $accion = 'edit';      
        $user = auth()->user()->name;

        $interno_equipos = $this->getInternoEquiposOt($ot_id);
 

        return view('ot-interno-equipos.index',compact('ot_id',
                                        'interno_equipos',                                   
                                        'user',                                       
                                        'header_titulo',
                                        'header_descripcion'));


  }

  public function getInternoEquiposOt($ot_id){


    return InternoEquipos::where('ot_id',$ot_id)
                           ->with('equipo')
                           ->select('interno_equipos.*')
                           ->get();
      }
  
  public function StoreOtInternoEquipos(Request $request,$ot_id){
       
        $ot_interno_equipos = InternoEquipos::where('ot_id',$ot_id)->get();

        foreach ($ot_interno_equipos as $ot_interno_equipo) {

            $existe = false;
            foreach ($request->interno_equipos as $interno_equipo) {

                if( ($ot_interno_equipo['id'] == $interno_equipo['id'])){
                  $existe = true;
                }
          
            }

          if (!$existe){
            
            InternoEquipos::where('ot_id',$ot_id)
                          ->where('id',$ot_interno_equipo['id'])
                          ->update(['ot_id' => null]);

            (new \App\Http\Controllers\TrazabilidadEquipoController)->saveTrazabilidadEquipo($ot_interno_equipo['id']);

            }
        }           

        } 

 



}
