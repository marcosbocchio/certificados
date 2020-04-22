<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NormaEnsayosRequest;
use Illuminate\Support\Facades\DB;
use App\Repositories\NormaEnsayos\NormaEnsayosRepository;
use App\NormaEnsayos;
use App\User;

class NormaEnsayosController extends Controller
{

    Protected $normaEnsayo;

    public function __construct(NormaEnsayosRepository $normaEnsayosRepository)
    {
      $this->middleware(['role_or_permission:Super Admin|M_normas_ensayo'],['only' => ['callView']]);  

      $this->normaEnsayo = $normaEnsayosRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  NormaEnsayos::orderBy('codigo','ASC')->get();
    }

    public function paginate(Request $request){

        return NormaEnsayos::orderBy('codigo','ASC')->paginate(10);
  
     }

    public function callView()
    {   
        $user = auth()->user(); 
        $header_titulo = "Normas Ensayos";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('norma-ensayos',compact('user','modelo','header_titulo','header_descripcion'));

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

    public function store(NormaEnsayosRequest $request){

        $norma_ensayo = new NormaEnsayos;   
  
          DB::beginTransaction();
          try { 
  
              $this->saveNormaEnsayos($request,$norma_ensayo);
              DB::commit(); 
  
          } catch (Exception $e) {
      
              DB::rollback();
              throw $e;      
              
          }      
  
      }
  
      public function update(NormaEnsayosRequest $request, $id){
  
        $norma_ensayo = NormaEnsayos::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveNormaEnsayos($request,$norma_ensayo);
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }
      public function saveNormaEnsayos($request,$norma_ensayo){
  
        $norma_ensayo->codigo = $request['codigo'];
        $norma_ensayo->descripcion = $request['descripcion'];
        $norma_ensayo->save();
  
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
        $norma_ensayo = NormaEnsayos::find($id);    
        $norma_ensayo->delete();
    }
}
