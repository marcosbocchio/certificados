<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use Illuminate\Support\Facades\DB;
use Exception as Exception;
use App\Materiales;
use App\User;
use Illuminate\Support\Facades\Log;

class MaterialesController extends Controller
{

    public function __construct()
    {

      $this->middleware(['role_or_permission:Sistemas|M_materiales'],['only' => ['callView']]);

    }

    public function index()
    {
        return  Materiales::all();

    }

    public function paginate(Request $request)
    {
        // Inicia la consulta sobre la tabla materiales
        $query = Materiales::query();
    
        // Si existe un término de búsqueda, aplica el filtro en 'codigo' y 'descripcion'
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }
    
        // Ordena y pagina los resultados
        $query->orderBy('codigo', 'DESC');
        return $query->paginate(10);
    }

    public function callView(){

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
