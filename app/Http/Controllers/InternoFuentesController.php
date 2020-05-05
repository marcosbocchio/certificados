<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InternoFuenteRequest;
use App\InternoFuentes;
use Illuminate\Support\Facades\DB;


class InternoFuentesController extends Controller
{
  public function __construct()
  {

        $this->middleware(['role_or_permission:Super Admin|M_interno_fuentes'],['only' => ['callView']]);  
  
  }
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
      
        $interno_fuentes =  InternoFuentes::orderBy('id','DESC')->with('fuente')->paginate(10);

        foreach ($interno_fuentes as $interno_fuente) {
          
          $interno_fuente->curie_actual = curie($interno_fuente->id);
        }
        
        return $interno_fuentes;
      }

      public function callView()
      {   
          $user = auth()->user(); 
          $header_titulo = "Interno Fuentes";
          $header_descripcion ="Alta | Baja | Modificación"; 
        
          return view('interno_fuentes',compact('user','header_titulo','header_descripcion'));
  
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

    public function getFuentesActivos(){
      

        return  InternoFuentes::where('activo_sn',1)
                                ->Select('interno_fuentes.*')
                                ->with('fuente')                            
                                ->get();


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InternoFuenteRequest $request){


        $interno_fuente = new InternoFuentes;   
    
        DB::beginTransaction();
        try { 
    
            $this->saveInternoFuente($request,$interno_fuente);
            DB::commit(); 
    
          } catch (Exception $e) {
      
            DB::rollback();
            throw $e;      
            
          }
       
    
      }
    
    public function saveInternoFuente($request,$interno_fuente){

        $interno_fuente->nro_serie = $request['nro_serie'];
        $interno_fuente->activo_sn = $request['activo_sn'];
        $interno_fuente->fecha_evaluacion = date('Y-m-d',strtotime($request['fecha_evaluacion'])) ;
        $interno_fuente->curie = $request['curie'];
        $interno_fuente->foco = $request['foco'];
        $interno_fuente->fuente_id = $request['fuente']['id'];
        $interno_fuente->save();
    
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
    public function update(InternoFuenteRequest $request, $id){

        $interno_fuente = InternoFuentes::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveInternoFuente($request,$interno_fuente);            
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interno_fuente = InternoFuentes::find($id);    
        $interno_fuente->delete();
    }

    public function CalcularCurie($interno_fuente_id, $fecha_final = null){

     // $interno_fuente = InternoFuentes::where('id',$interno_fuente_id)->with('fuente')->first();  
      
      $curie_actual =  curie($interno_fuente_id,$fecha_final);

      return  $curie_actual;

    }

}
