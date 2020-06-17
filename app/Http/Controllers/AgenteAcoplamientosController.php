<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgenteAcoplamientos;
use App\Http\Requests\AgenteAcoplamientoRequest;
use Illuminate\Support\Facades\DB;
use Exception as Exception;

class AgenteAcoplamientosController extends Controller
{
    public function __construct()
    {

       $this->middleware(['role_or_permission:Sistemas|M_agente_ac'],['only' => ['callView']]);  
    
    }

    public function index()
    {
        return AgenteAcoplamientos::All();
    }

    public function paginate(Request $request){

        return AgenteAcoplamientos::orderBy('codigo','DESC')->paginate(10);
  
    }

    public function callView()
    {   
      $user = auth()->user();
      $header_titulo = "Agente Acoplamiento";
      $header_descripcion ="Alta | Baja | Modificación";      
      return view('agente-acoplamientos',compact('user','header_titulo','header_descripcion'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgenteAcoplamientoRequest $request){

        $agente_acoplamiento = new AgenteAcoplamientos;   
  
          DB::beginTransaction();
          try { 
  
              $this->saveAgenteAcoplamiento($request,$agente_acoplamiento);
              DB::commit(); 
  
          } catch (Exception $e) {
      
              DB::rollback();
              throw $e;      
              
          }      
  
      }

      public function update(AgenteAcoplamientoRequest $request, $id){
      
        $agente_acoplamiento = AgenteAcoplamientos::where('id',$id)
                                ->where('updated_at',$request['updated_at'])                              
                                ->first();
                                
        if(is_null($agente_acoplamiento)){
  
  
             return response()->json(['errors' => ['error' => ['Otro usuario modificó el registro que intenta actualizar, recargue la página y vuelva a intentarlo']]], 404);
  
        }else{
  
          DB::beginTransaction();
          try {       
         
        
              $this->saveAgenteAcoplamiento($request,$agente_acoplamiento);
              DB::commit(); 
        
              } catch (Exception $e) {
                
                DB::rollback();
                throw $e;
                
              }
  
        }
  
      }

      public function saveAgenteAcoplamiento($request,$agente_acoplamiento){

        $agente_acoplamiento->codigo = $request['codigo'];
        $agente_acoplamiento->descripcion = $request['descripcion'];
        $agente_acoplamiento->save();  
  
      }
  
      public function destroy($id){
  
        $agente_acoplamiento = AgenteAcoplamientos::find($id);    
        $agente_acoplamiento->delete();
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



}
