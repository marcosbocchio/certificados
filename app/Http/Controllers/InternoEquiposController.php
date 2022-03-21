<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\InternoEquipos;
use App\Http\Requests\InternoEquipoRequest;
use Illuminate\Support\Facades\DB;
use App\Fuentes;
use \stdClass;
use Illuminate\Support\Facades\Log;
use App\Frentes;

class InternoEquiposController extends Controller
{

    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|M_interno_equipos'],['only' => ['callView']]);
          $this->middleware(['role_or_permission:Sistemas|T_equipos_acceder'],['only' => ['OtInternoEquipos']]);
          $this->middleware(['role_or_permission:Sistemas|T_equipos_actualiza'],['only' => ['store','destroy']]);


    }
    public function paginate(Request $request){

        $filtro = $request->search;
        $interno_equipos = InternoEquipos::with('equipo.metodoEnsayos')
                                          ->with('internoFuente.fuente')
                                          ->with('frente')
                                          ->selectRaw('interno_equipos.*,CONVERT(nro_interno,UNSIGNED) as nro_interno_numeric' )
                                          ->orderby('nro_interno_numeric','ASC')
                                          ->Filtro($filtro)
                                          ->paginate(10);

        foreach ( $interno_equipos as $interno_equipo) {

          if($interno_equipo->internoFuente){

            $interno_fuente = $interno_equipo->internoFuente;
            $fuente = $interno_fuente->fuente;
            $curie_actual = curie($interno_fuente->id);
            $interno_fuente->curie_actual = $curie_actual;

          }

        }

        return $interno_equipos;

      }

    public function callView()
      {
          $user = auth()->user();
          $header_titulo = "Interno Equipos";
          $header_descripcion ="Alta | Baja | Modificación";

          return view('interno_equipos',compact('user','header_titulo','header_descripcion'));

      }

    public function getInternoEquipos($metodo, $activo_sn, $tipo_penetrante){
      $interno_equipos='';
      $instrumento_medicion='';

      if($tipo_penetrante != 'null'){
            $instrumento_medicion = ($tipo_penetrante == 'Fluorescente') ? 'Lampara luz UV' : 'Luxometro luz blanca';

            $interno_equipos =  InternoEquipos::join('equipos','equipos.id','=','interno_equipos.equipo_id')
                                              ->where('interno_equipos.activo_sn',1)
                                              ->where('equipos.instrumento_medicion',$instrumento_medicion)
                                              ->where('equipos.palpador_sn',0)
                                              ->selectRaw('interno_equipos.*,CONVERT(nro_interno,UNSIGNED) as nro_interno_numeric' )
                                              ->with('equipo')
                                              ->with('internoFuente')
                                              ->orderby('nro_interno_numeric','ASC')
                                              ->get();

      }elseif(($metodo != 'null')&&($activo_sn)){
            $interno_equipos = InternoEquipos::join('equipos','equipos.id','=','interno_equipos.equipo_id')
                                                ->join('metodo_ensayos','equipos.metodo_ensayo_id','=','metodo_ensayos.id')
                                                ->where('metodo_ensayos.metodo',$metodo)
                                                ->where('interno_equipos.activo_sn',1)
                                                ->where('equipos.palpador_sn',0)
                                                ->whereNull('equipos.instrumento_medicion')
                                                ->selectRaw('interno_equipos.*,CONVERT(nro_interno,UNSIGNED) as nro_interno_numeric' )
                                                ->with('equipo')
                                                ->with('internoFuente')
                                                ->orderby('nro_interno_numeric','ASC')
                                                ->get();


      }elseif($activo_sn !='null'){
        $interno_equipos = InternoEquipos::where('interno_equipos.activo_sn',1)
                                            ->with('equipo')
                                            ->with('internoFuente')
                                            ->selectRaw('interno_equipos.*,CONVERT(nro_interno,UNSIGNED) as nro_interno_numeric' )
                                            ->orderby('nro_interno_numeric','ASC')
                                            ->get();

      }else{
          $interno_equipos = InternoEquipos::with('equipo')
                                            ->with('internoFuente')
                                            ->selectRaw('interno_equipos.*,CONVERT(nro_interno,UNSIGNED) as nro_interno_numeric' )
                                            ->orderby('nro_interno_numeric','ASC')
                                            ->get();

          }

        return $interno_equipos;
    }

    public function InternoEquiposFrente($frente_origen_id){

        return InternoEquipos::where('interno_equipos.activo_sn',1)
                                ->where('interno_equipos.frente_id',$frente_origen_id)
                                ->with('equipo')
                                ->with('internoFuente')
                                ->selectRaw('interno_equipos.*,CONVERT(nro_interno,UNSIGNED) as nro_interno_numeric' )
                                ->orderby('nro_interno_numeric','ASC')
                                ->get();

    }

    public function store(InternoEquipoRequest $request){


        $interno_equipo = new InternoEquipos;

        DB::beginTransaction();
        try {

            $this->saveInternoEquipo($request,$interno_equipo);
            (new \App\Http\Controllers\TrazabilidadEquipoController)->saveTrazabilidadEquipo($interno_equipo->id,$interno_equipo->frente_id);

            if($interno_equipo->interno_fuente_id){
                 (new \App\Http\Controllers\TrazabilidadFuenteController)->saveTrazabilidadfuente($interno_equipo->id,$request['interno_fuente']['id']);
            }
            DB::commit();

          } catch (Exception $e) {

            DB::rollback();
            throw $e;

          }

      }

    public function show($id)
    {
        return InternoEquipos::where('id',$id)
                               ->select('interno_equipos.*')
                               ->first();
    }

    public function update(InternoEquipoRequest $request, $id){

        $interno_equipo = InternoEquipos::find($id);

        DB::beginTransaction();
        try {

          $this->saveInternoEquipo($request,$interno_equipo);

         (new \App\Http\Controllers\TrazabilidadFuenteController)->saveTrazabilidadfuente($interno_equipo->id,$request['interno_fuente']['id']);


          DB::commit();

          } catch (Exception $e) {

            DB::rollback();
            throw $e;

          }
      }

      public function saveInternoEquipo($request,$interno_equipo){
        $interno_equipo->nro_serie = $request['nro_serie'];
        $interno_equipo->nro_interno = $request['nro_interno'];
        $interno_equipo->foco = $request['foco'];
        $interno_equipo->voltaje = $request['voltaje'];
        $interno_equipo->amperaje = $request['amperaje'];
        $interno_equipo->probeta = $request['probeta'];
        $interno_equipo->dureza_calibracion = $request['dureza_calibracion'];
        $interno_equipo->activo_sn = $request['activo_sn'];
        $interno_equipo->equipo_id = $request['equipo']['id'];
        $interno_equipo->interno_fuente_id = $request['interno_fuente']['id'];

        if($request->isMethod('post')){
            $frente = Frentes::where('centro_distribucion_sn',1)->first();
            $interno_equipo->frente_id = $frente->id;
        }

        $interno_equipo->save();

      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interno_equipo = InternoEquipos::find($id);
        $interno_equipo->delete();
    }

    /*
  public function StoreOtInternoEquipos(Request $request,$ot_id){

    $ot_interno_equipos = InternoEquipos::where('ot_id',$ot_id)->get();

    DB::beginTransaction();
    try {

        foreach ($ot_interno_equipos as $ot_interno_equipo) {

            $existe = false;
            foreach ($request->interno_equipos as $interno_equipo) {

                if( ($ot_interno_equipo['id'] == $interno_equipo['id'])){
                  $existe = true;
                }

            }

          if (!$existe){

            InternoEquipos::where('ot_id',$ot_id)
                          ->where('id',$ot_interno_equipo['id'])
                          ->update(['ot_id' => null]);

            (new \App\Http\Controllers\TrazabilidadEquipoController)->saveTrazabilidadEquipo($ot_interno_equipo['id']);

            }
        }

        DB::commit();

      } catch (Exception $e) {

        DB::rollback();
        throw $e;

      }

  }
*/

}
