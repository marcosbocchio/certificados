<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\NormaEvaluacionesRequest;
use App\Repositories\NormaEvaluaciones\NormaEvaluacionesRepository;
use App\NormaEvaluaciones;
use App\User;

class NormaEvaluacionesController extends Controller
{
    Protected $normaEvaluacion;

    public function __construct(NormaEvaluacionesRepository $normaEvaluacionesRepository)
    {
      $this->middleware(['role_or_permission:Super Admin|M_normas_eval']);  

      $this->normaEvaluacion = $normaEvaluacionesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  $this->normaEvaluacion->getAll();
    }

    public function paginate(Request $request){

        return NormaEvaluaciones::orderBy('id','DESC')->paginate(10);
  
     }

    public function callView()
    {   
        $user = auth()->user(); 
        $header_titulo = "Normas Evaluaciones";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('norma-evaluaciones',compact('user','modelo','header_titulo','header_descripcion'));

    }

    public function store(NormaEvaluacionesRequest $request){

        $norma_evaluaciones = new NormaEvaluaciones;   
  
          DB::beginTransaction();
          try { 
  
              $this->saveNormaEvaluaciones($request,$norma_evaluaciones);
              DB::commit(); 
  
          } catch (Exception $e) {
      
              DB::rollback();
              throw $e;      
              
          }      
  
      }
  
      public function update(NormaEvaluacionesRequest $request, $id){
  
        $norma_evaluaciones = NormaEvaluaciones::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveNormaEvaluaciones($request,$norma_evaluaciones);
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }
      public function saveNormaEvaluaciones($request,$norma_evaluaciones){
  
        $norma_evaluaciones->codigo = $request['codigo'];
        $norma_evaluaciones->descripcion = $request['descripcion'];
        $norma_evaluaciones->save();
  
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
        $norma_evaluaciones = NormaEvaluaciones::find($id);    
        $norma_evaluaciones->delete();
    }
}
