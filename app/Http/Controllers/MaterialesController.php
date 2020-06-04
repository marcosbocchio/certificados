<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use Illuminate\Support\Facades\DB;
use Exception as Exception;
use App\Materiales;
use App\User;

class MaterialesController extends Controller
{

    public function __construct()
    {

       $this->middleware(['role_or_permission:Super Admin|M_materiales'],['only' => ['callView']]);  
    
    }

    public function index()
    {   
         return  Materiales::all();

    }

    public function paginate(Request $request){

      return Materiales::orderBy('codigo','DESC')->paginate(10);

    }

    public function callView()
    {   
      $user = auth()->user();
      $header_titulo = "Materiales";
      $header_descripcion ="Alta | Baja | Modificación";      
      return view('materiales',compact('user','header_titulo','header_descripcion'));

    }

    public function store(MaterialRequest $request){

      $material = new Materiales;   

        DB::beginTransaction();
        try { 

            $this->saveMaterial($request,$material);
            DB::commit(); 

        } catch (Exception $e) {
    
            DB::rollback();
            throw $e;      
            
        }      

    }

    public function update(MaterialRequest $request, $id){
      
      $material = Materiales::where('id',$id)
                              ->where('updated_at',$request['updated_at'])                              
                              ->first();
                              
      if(is_null($material)){


           return response()->json(['errors' => ['error' => ['Otro usuario modificó el registro que intenta actualizar, recargue la página y vuelva a intentarlo']]], 404);

      }else{

        DB::beginTransaction();
        try {
  
         //   $material = Materiales::find($id);
       
      
            $this->saveMaterial($request,$material);
            DB::commit(); 
      
            } catch (Exception $e) {
              
              DB::rollback();
              throw $e;
              
            }

      }

    }


    public function saveMaterial($request,$material){

      $material->codigo = $request['codigo'];
      $material->descripcion = $request['descripcion'];
      $material->save();  

    }

    public function destroy($id){

      $material = Materiales::find($id);    
      $material->delete();
    }

}
