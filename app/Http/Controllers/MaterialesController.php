<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use Illuminate\Support\Facades\DB;
use App\Materiales;
use App\User;


class MaterialesController extends Controller
{

    public function index()
    {   
         return  Materiales::all();

    }

    public function paginate(Request $request){

      return Materiales::orderBy('id','DESC')->paginate(10);

    }

    public function callView()
    {   
        $user = auth()->user()->name;
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

      $material = Materiales::find($id);     
    
        DB::beginTransaction();
        try {
            $this->saveMaterial($request,$material);
            DB::commit(); 
    
          } catch (Exception $e) {
      
            DB::rollback();
            throw $e;      
            
          }
    }

    public function destroy($id){

      $material = Materiales::find($id);    
      $material->delete();
    }

    public function saveMaterial($request,$material){

      $material->codigo = $request['codigo'];
      $material->descripcion = $request['descripcion'];
      $material->save();

    }
}
