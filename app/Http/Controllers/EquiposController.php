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

        $this->middleware(['role_or_permission:Sistemas|M_equipos'],['only' => ['callView']]);

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Equipos::with('metodoEnsayos')->get();

    }

    public function paginate(Request $request){

        $filtro = $request->search;

        return Equipos::orderBy('id','DESC')
                      ->with('metodoEnsayos')
                      ->with('tipoEquipamiento')
                      ->Filtro($filtro)
                      ->paginate(10);

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


        $equipo_aux = Equipos::where('codigo',$request['codigo'])
                                ->where('descripcion',$request['descripcion'])
                                ->first();

        if(!is_null($equipo_aux)){

             return response()->json(['errors' => ['error' => ['Existe un Equipo con ese código y descripción']]], 422);

        }

          DB::beginTransaction();
          try {

              $this->saveEquipo($request,$equipo);
              DB::commit();

          } catch (Exception $e) {

              DB::rollback();
              throw $e;

          }

      }

      public function update(EquipoRequest $request, $id){

        $equipo = Equipos::find($id);

        $equipo_aux = Equipos::where('codigo',$request['codigo'])
                              ->where('descripcion',$request['descripcion'])
                              ->first();

        if(!is_null($equipo_aux) && ($equipo_aux->id != $id)){
           return response()->json(['errors' => ['error' => ['Existe un Equipo con ese código y descripción']]], 422);
        }
          DB::beginTransaction();
          try {
              $this->saveEquipo($request,$equipo);
              DB::commit();

            } catch (Exception $e) {

              DB::rollback();
              throw $e;

            }
      }

      public function saveEquipo($request,$equipo){

        $equipo->codigo = $request['codigo'];
        $equipo->descripcion = $request['descripcion'];
        $equipo->metodo_ensayo_id = $request['metodo_ensayos']['id'];
        $equipo->instrumento_medicion = $request['instrumento_medicion'];
        $equipo->tipo_equipamiento_id = $request['tipo_equipamiento']['id'];
        if($request['metodo_ensayos']['metodo'] == 'US'){
          $equipo->palpador_sn = $request['palpador_sn'];
        }else{
          $equipo->palpador_sn = 0;
        }
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
