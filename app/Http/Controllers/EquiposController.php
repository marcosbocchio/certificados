<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EquipoRequest;
use App\Equipos;
use Illuminate\Support\Facades\DB;

class EquiposController extends Controller
{

  public function __construct()
  {

        $this->middleware(['role_or_permission:Super Admin|M_equipos']);  
  
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Equipos::All();

    }

    public function paginate(Request $request){
      
        return Equipos::orderBy('id','DESC')->with('metodoEnsayos')->paginate(10);
  
      }

    public function callView()
      {   
          $user = auth()->user(); 
          $header_titulo = "Equipos";
          $header_descripcion ="Alta | Baja | Modificación"; 
        
          return view('equipos',compact('user','header_titulo','header_descripcion'));
  
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
    public function store(EquipoRequest $request){

        $equipo = new Equipos;   
  
          DB::beginTransaction();
          try { 
  
              $this->saveMaterial($request,$equipo);
              DB::commit(); 
  
          } catch (Exception $e) {
      
              DB::rollback();
              throw $e;      
              
          }      
  
      }
  
      public function update(EquipoRequest $request, $id){
  
        $equipo = Equipos::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveMaterial($request,$equipo);
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }
      public function saveMaterial($request,$equipo){
  
        $equipo->codigo = $request['codigo'];
        $equipo->descripcion = $request['descripcion'];
        $equipo->metodo_ensayo_id = $request['metodo_ensayos']['id'];
        $equipo->tipo_lp = $request['tipo_lp'];
        $equipo->save();
  
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
        $equipo = Equipos::find($id);    
        $equipo->delete();
    }

    public function EquiposMetodo($metodo)
    {
        return DB::table('equipos')
        ->join('metodo_ensayos','equipos.metodo_ensayo_id','=','metodo_ensayos.id')
        ->where('metodo_ensayos.metodo','=',$metodo)
        ->select('equipos.*')
        ->get();
    }
}
