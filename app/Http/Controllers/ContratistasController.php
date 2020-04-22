<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ContratistaRequest;
use App\Contratistas;
class ContratistasController extends Controller
{

    public function __construct()
    {

    $this->middleware(['role_or_permission:Super Admin|M_contratistas'],['only' => ['callView']]);  
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contratistas::orderBy('nombre','ASC')->get();
    }

    public function paginate(Request $request){

      return Contratistas::orderBy('nombre','ASC')->paginate(10);
  
      }

    public function callView()
      {   
          $user = auth()->user(); 
          $header_titulo = "Comitente";
          $header_descripcion ="Alta | Baja | Modificación"; 
        
          return view('contratistas',compact('user','header_titulo','header_descripcion'));
  
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

    public function store(ContratistaRequest $request){

        $contratista = new Contratistas;   
  
          DB::beginTransaction();
          try { 
  
              $this->saveContratista($request,$contratista);
              DB::commit(); 
  
          } catch (Exception $e) {
      
              DB::rollback();
              throw $e;      
              
          }      
  
      }
  
      public function update(ContratistaRequest $request, $id){
  
        $contratista = Contratistas::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveContratista($request,$contratista);
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }
      public function saveContratista($request,$contratista){
  
        $contratista->nombre = $request['nombre'];
        $contratista->path_logo = $request['path_logo'];
        $contratista->save();
  
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
        $contratista = Contratistas::find($id);    
        $contratista->delete();
    }
}
