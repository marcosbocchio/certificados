<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoEquipamiento;
use App\Http\Requests\TipoEquipamientoRequest;
use Illuminate\Support\Facades\DB;
use Exception as Exception;
use Illuminate\Support\Facades\Log;

class TipoEquipamientoController extends Controller
{
    public function __construct()
    {

       $this->middleware(['role_or_permission:Sistemas|M_tipos_equipamiento'],['only' => ['callView']]);

    }

    public function index()
    {
        return TipoEquipamiento::orderby('codigo','asc')->get();
    }

    public function paginate(Request $request){

        return TipoEquipamiento::orderBy('codigo','ASC')->paginate(10);
  
    }

    public function callView() {

        $user = auth()->user();
        $header_titulo = "Tipo Equipamiento";
        $header_descripcion ="Alta | Baja | Modificación";
        return view('tipos_equipamiento',compact('user','header_titulo','header_descripcion'));       

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
    public function store(TipoEquipamientoRequest $request){

        $tipo_equipamiento = new TipoEquipamiento;
 
         DB::beginTransaction();
         try {
 
             $this->saveTipoEquipamiento($request,$tipo_equipamiento);
             (new \App\Http\Controllers\AlarmasController)->storeNuevaAlarma($request['codigo'],$request['descripcion']);
             DB::commit();
 
         } catch (Exception $e) {
 
             DB::rollback();
             throw $e;
         }
     }

    public function update(TipoEquipamientoRequest $request, $id){

        $tipo_equipamiento = TipoEquipamiento::where('id',$id)
                                ->where('updated_at',$request['updated_at'])
                                ->first();
  
        if(is_null($tipo_equipamiento)){
  
             return response()->json(['errors' => ['error' => ['Otro usuario modificó el registro que intenta actualizar, recargue la página y vuelva a intentarlo']]], 404);
  
        }else{
  
          DB::beginTransaction();
          try {
  
              (new \App\Http\Controllers\AlarmasController)->update($tipo_equipamiento->codigo,$request['codigo'], $request['descripcion']);              
              $this->saveTipoEquipamiento($request,$tipo_equipamiento);

              DB::commit();
  
              } catch (Exception $e) {
  
                DB::rollback();
                throw $e;
  
              }
          }
      }

      public function saveTipoEquipamiento($request,$tipo_equipamiento){

        $tipo_equipamiento->codigo = $request['codigo'];
        $tipo_equipamiento->descripcion = $request['descripcion'];
        $tipo_equipamiento->save();
  
      }

    public function destroy($id)
    
    {
        DB::beginTransaction();
        try {
            $tipo_equipamiento = TipoEquipamiento::find($id);
            (new \App\Http\Controllers\AlarmasController)->destroy($tipo_equipamiento->codigo);
            Log::debug("tipo_equipamiento:". json_encode($tipo_equipamiento));
            $tipo_equipamiento->delete();
            DB::commit();

        } catch (Exception $e) {
    
            DB::rollback();
            throw $e;

        }        
    }
}
