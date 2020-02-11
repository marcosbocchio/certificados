<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FuenteRequest;
use App\Fuentes;
use Illuminate\Support\Facades\DB;

class FuentesController extends Controller
{

  public function __construct()
  {

        $this->middleware(['role_or_permission:Super Admin|M_fuentes'],['only' => ['callView']]);    
  
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Fuentes::All();
    }

    public function paginate(Request $request){
      
        return Fuentes::orderBy('id','DESC')->paginate(10);
  
      }

    public function callView()
      {   
          $user = auth()->user(); 
          $header_titulo = "Fuentes";
          $header_descripcion ="Alta | Baja | Modificación"; 
        
          return view('fuentes',compact('user','header_titulo','header_descripcion'));
  
      }

    public function getFuentePorInterno($interno_fuente_id){

        return Fuentes::join('interno_fuentes','interno_fuentes.fuente_id','fuentes.id')
                        ->where('interno_fuentes.id',$interno_fuente_id)
                        ->select('fuentes.*')
                        ->first();

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuenteRequest $request){

        $fuente = new Fuentes;   
  
          DB::beginTransaction();
          try { 
  
              $this->saveFuente($request,$fuente);
              DB::commit(); 
  
          } catch (Exception $e) {
      
              DB::rollback();
              throw $e;      
              
          }      
  
      }
  
      public function update(FuenteRequest $request, $id){
  
        $fuente = Fuentes::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveFuente($request,$fuente);
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }
      public function saveFuente($request,$fuente){
  
        $fuente->codigo = $request['codigo'];
        $fuente->descripcion = $request['descripcion'];
        $fuente->const_t = $request['t'];
        $fuente->save();
  
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fuente = Fuentes::find($id);    
        $fuente->delete();
    }
}
