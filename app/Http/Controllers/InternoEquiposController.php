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
      
        return InternoEquipos::orderBy('id','DESC')->with('equipo')->with('internoFuente')->paginate(10);
  
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
      

        return  InternoEquipos::join('equipos','equipos.id','=','interno_equipos.equipo_id') 
                                ->join('metodo_ensayos','equipos.metodo_ensayo_id','=','metodo_ensayos.id')
                                ->where('metodo_ensayos.metodo',$metodo)
                                ->where('interno_equipos.activo_sn',1)
                                ->Select('interno_equipos.*')
                                ->with('equipo')
                                ->with('internoFuente')
                                ->get();


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
        //
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
}
