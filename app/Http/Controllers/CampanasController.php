<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CampanasRequest;
use App\Campanas;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CampanasController extends Controller
{

  public function __construct()
  {

        $this->middleware(['role_or_permission:Sistemas|M_fuentes'],['only' => ['callView']]);

  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Campanas::All();
    }

    public function paginate(Request $request){
        $filtro = $request->search;
        $campanas = Campanas::orderBy('designacion','DESC')
                              ->paginate(10);
        return $campanas;
    }

    public function callView()
      {
          $user = auth()->user();
          $header_titulo = "Campanas";
          $header_descripcion ="Alta | Baja | Modificación";

          return view('campanas',compact('user','header_titulo','header_descripcion'));

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
    public function store(CampanasRequest $request){

        $campana = new Campanas;


          DB::beginTransaction();
          try {

              $this->saveCampana($request,$campana);
              DB::commit();

          } catch (Exception $e) {

              DB::rollback();
              throw $e;

          }

      }

      public function update(CampanasRequest $request, $id){

        $campana = Campanas::find($id);

          DB::beginTransaction();
          try {
              $this->saveCampana($request,$campana);
              DB::commit();

            } catch (Exception $e) {

              DB::rollback();
              throw $e;

            }
      }
      public function saveCampana($request,$campana){

        $campana->designacion = $request['designacion'];
        $campana->tipo_angular_sn = $request['tipo_angular_sn'];
        $campana->presion_max_manometro = $request['presion_max_manometro'];
        $campana->presion_trabajo_min = $request['presion_trabajo_min'];
        $campana->presion_trabajo_max = $request['presion_trabajo_max'];
        $campana->ancho = $request['ancho'];
        $campana->alto = $request['alto'];
        $campana->profundidad = $request['profundidad'];
        $campana->save();

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
        $fuente = Campanas::find($id);
        $fuente->delete();
    }
}
