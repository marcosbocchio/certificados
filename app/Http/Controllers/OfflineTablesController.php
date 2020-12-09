<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Clientes;
use App\Documentaciones;
use App\User;
use File;
use Log;

class OfflineTablesController extends Controller
{
    public function getDataTable(Request $request)
    {
        Log::debug($request);
        $fechaActualzacion = $request->header("dateupdated");
        $nombreTabla = $request->header("tablename");
        if($nombreTabla == ''){
            return response()->json("Error: Falta el nombre de la tabla",500,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
        }
        if($fechaActualzacion == ''){
            $dataTable = DB::table($nombreTabla)->get();
        }
        else{

            $dataTable = DB::table($nombreTabla)
                                    ->where("created_at", ">", $fechaActualzacion)
                                    ->orWhere("updated_at", ">", $fechaActualzacion)
                                    ->orderBy("created_at", "ASC")->get();
        }
        return response()->json($dataTable,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }

    public function GetClientesImg(Request $request){

        $fechaActualzacion = $request->header("dateupdated");
        if($fechaActualzacion == ''){
            return response()->json("Falta fecha",504,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
        }
        else
        {
            $clientes = Clientes::where("created_at", ">", $fechaActualzacion)
                                ->orWhere("updated_at", ">", $fechaActualzacion)
                                ->orderBy("created_at", "ASC")->get();;

            foreach($clientes as $cliente){
                if($cliente->path != null){
                    $path = $cliente->path;
                    $cliente->path = "";
                    if(File::exists($path)){
                        $file = File::get($path);
                        $cliente->path=explode("/", File::mimeType($path))[1]  . "--*--EXT" . base64_encode($file);
                    }
                }
            }
        }

        return response()->json($clientes,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);

     }

    public function GetDocumentaciones(Request $request)//FALTAR FILTRAR POR FECHAS
    {
        $fechaActualzacion = $request->header("dateupdated");

        if($fechaActualzacion == '') {
            return response()->json("Error: Falta fecha",504,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
        } else {

        $documentaciones = Documentaciones::select("id", "metodo_ensayo_id", "tipo", "titulo", "descripcion", "fecha_caducidad", "created_at", "updated_at")
                                                ->where("tipo", "=", "PROCEDIMIENTO GENERAL")
                                                ->orWhere("tipo", "=", "PROCEDIMIENTO")
                                                ->orwhere("created_at", ">", $fechaActualzacion)
                                                ->orWhere("updated_at", ">", $fechaActualzacion)
                                                ->orderBy("created_at", "ASC")
                                                ->get();
        }

        return response()->json($documentaciones,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }

    public function getUsersWithDates(Request $request)
    {
        $fechaActualzacion = $request->header("dateupdated");
        if($fechaActualzacion == ''){
            return $this->getUsuarios();
        }
        else{
            $users =  user::select("id", "name", "dni","email", "cliente_id", "film", "habilitado_arn_sn", "path", "created_at", "updated_at")
                                ->where("created_at", ">", $fechaActualzacion)
                                ->orWhere("updated_at", ">", $fechaActualzacion)
                                ->orderBy("created_at", "ASC")->get();
            return response()->json($users,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
        }
    }

    public function GetDeletedId(Request $request)
    {
        $nombreTabla =$request->header("tablename");
        if($nombreTabla == ''){
            return response()->json("Error: Falta el nombre de la tabla",500,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);
        }
        $idEliminados = DB::select('CALL `getRegistrosBorados`(?)',array($nombreTabla));
        return response()->json($idEliminados,200,['Content-type'=>'application/json;charset=utf-8'],JSON_UNESCAPED_UNICODE);

    }
}
