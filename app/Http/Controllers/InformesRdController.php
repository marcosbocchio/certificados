<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\User;
use App\Ots;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Http\Requests\InformeRdRequest;
use App\Informe;
use App\InformesRd;
use App\Materiales;
use App\DiametroView;
use App\DiametrosEspesor;
use App\InternoEquipos;
use App\Fuentes;
use App\InternoFuentes;
use App\Tecnicas;
use App\TecnicasGraficos;
use App\TipoPeliculas;
use App\Icis;
use App\NormaEvaluaciones;
use App\NormaEnsayos;
use App\OtOperarios;
use App\Soldadores;
use App\TipoSoldaduras;
use \stdClass;
use App\OtTipoSoldaduras;
use Illuminate\Support\Facades\Log;
use App\JuntasRd;
use App\TramosRd;
use App\PerfilRd;
use App\PasadasJuntaRd;
use App\DetallesRdReferencias;
use App\PosicionRd;
use App\DefectosPosicionRd;
use Exception as Exception;

class InformesRdController extends Controller
{
    Protected $informesRd;

    public function __construct()
    {

      $this->middleware('ddppi')->only('create');
      $this->middleware(['role_or_permission:Sistemas|T_informes_edita'],['only' => ['create','edit']]);
    }


    public function create($ot_id)
    {
        $metodo = 'RD';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $ot = Ots::findOrFail($ot_id);

        return view('informes.rd.index', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'header_titulo',
                                                 'header_descripcion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformeRdRequest $request,$EsRevision = false)
    {
        $informe  = new Informe;
        $informeRd  = new InformesRd;

        DB::beginTransaction();
        try {

          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe,$EsRevision);
          $this->saveInformeRd($request,$informe,$informeRd);
          $this->saveDetalle($request,$informeRd);
          $this->saveTramos($request,$informeRd);

          DB::commit();

        } catch (Exception $e) {

          DB::rollback();
          throw $e;

        }

        return $informe;


    }

    public function edit($ot_id,$id)
    {
        $header_titulo = "Informe";
        $header_descripcion ="Editar";
        $metodo = 'RD';
        $accion = 'edit';
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::where('id',$id)->with('planta')->first();
        $informe_rd =InformesRd::where('informe_id',$informe->id)->first();
        $informe_material = Materiales::find($informe->material_id);
        $informe_material_accesorio = Materiales::find($informe->material2_id);
        $informe_diametroEspesor = $informe->diametro_espesor_id ? DiametrosEspesor::find($informe->diametro_espesor_id) : null ;
        $informe_diametro = $informe_diametroEspesor ? DiametroView::where('diametro',$informe_diametroEspesor->diametro)->first() : null;
        $informe_interno_fuente = InternoFuentes::where('id',$informe_rd->interno_fuente_id)->with('fuente')->first();

        if ($informe_interno_fuente == null)
           $informe_interno_fuente = new InternoFuentes();

       if ($informe_material_accesorio == null)
           $informe_material_accesorio = new Materiales();

        $informe_ot_tipo_soldadura = OtTipoSoldaduras::join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
        ->where('ot_tipo_soldaduras.id',$informe->ot_tipo_soldadura_id)->with('tipoSoldadura')->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')->first();


        if ($informe_ot_tipo_soldadura == null)
              $informe_ot_tipo_soldadura = new OtTipoSoldaduras();

        $informe_tecnica_grafico = (new TecnicasGraficosController)->show($informe_rd->tecnicas_grafico_id);
        $informe_interno_equipo = internoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
        $documetacionesRepository = new DocumentacionesRepository;
        $informe_procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);
        $infome_tipo_pelicula = TipoPeliculas::find($informe_rd->tipo_pelicula_id);
        $informe_ici = Icis::find($informe_rd->ici_id);
        $informe_norma_evaluacion = NormaEvaluaciones::find($informe->norma_evaluacion_id);
        $informe_norma_ensayo = NormaEnsayos::find($informe->norma_ensayo_id);
        $informe_ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $informe_detalle = $this->getDetalle($informe_rd->id);
        $informe_pasada_juntas = $this->getPasadasJuntas($informe_rd->id);
        $informe_tramos = $this->getTramos($informe_rd->id);
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
        if ($informe_solicitado_por == null){
            $informe_solicitado_por = new User();
        }

        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        if ($informe_diametroEspesor == null)
          $informe_diametroEspesor = new DiametrosEspesor();

        if ($informe_diametro == null)
          $informe_diametro = new DiametroView();

        return view('informes.rd.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_rd',
                                                 'informe_ot_tipo_soldadura',
                                                 'informe_material',
                                                 'informe_material_accesorio',
                                                 'informe_diametro',
                                                 'informe_diametroEspesor',
                                                 'informe_interno_fuente',
                                                 'informe_tecnica_grafico',
                                                 'informe_interno_equipo',
                                                 'informe_procedimiento',
                                                 'infome_tipo_pelicula',
                                                 'informe_ici',
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',
                                                 'informe_detalle',
                                                 'informe_tramos',
                                                 'informe_pasada_juntas',
                                                 'informe_modelos_3d',
                                                 'header_titulo',
                                                 'informe_solicitado_por',
                                                 'header_descripcion'));
    }


    public function getDetalle($id){

          $informe_detalle = DB::table('informes_rd')
                               ->join('juntas_rd','juntas_rd.informe_rd_id','=','informes_rd.id')
                               ->join('posicion_rd','posicion_rd.junta_id','=','juntas_rd.id')
                               ->where('informes_rd.id',$id)
                               ->select('juntas_rd.codigo as junta',
                                      'posicion_rd.descripcion as observacion',
                                      'posicion_rd.densidad as densidad',
                                      'posicion_rd.aceptable_sn as aceptable_sn',
                                      'posicion_rd.codigo as posicion',
                                      'posicion_rd.id as posicion_id')
                                ->orderBy('posicion_rd.id','asc')
                                ->get();



        foreach ($informe_detalle as $detalle_posicion) {

            $defecto_posicion = DB::table('posicion_rd')
                                    ->join('defectos_posicion_rd','defectos_posicion_rd.posicion_id','=','posicion_rd.id')
                                    ->join('defectos_rd','defectos_rd.id','=','defectos_posicion_rd.defecto_rd_id')
                                    ->where('posicion_rd.id',$detalle_posicion->posicion_id)
                                    ->select('defectos_rd.codigo','defectos_rd.descripcion','defectos_rd.id','defectos_posicion_rd.posicion','pasada')
                                    ->get();

            $detalle_posicion->defectos = $defecto_posicion;

        }

      return $informe_detalle;

    }
    public function getTramos($id){

        $informe_tramo = DB::table('tramo_perfil_rd')
                             ->leftjoin('detalles_rd_referencias','detalles_rd_referencias.id','=','tramo_perfil_rd.tramo_rd_referencia_id')
                             ->where('tramo_perfil_rd.informes_rd_id',$id)
                             ->selectRaw('tramo_perfil_rd.*, (round(((espesor*25.4)/bola_comparadora),2)) as espesor_real, observaciones as observacion_tramo, espesor as espesor_tramo, detalles_rd_referencias.descripcion as observaciones, detalles_rd_referencias.path1 as path1,detalles_rd_referencias.path2 as path2,detalles_rd_referencias.path3 as path3,detalles_rd_referencias.path4 as path4')
                              ->orderBy('tramo_perfil_rd.id','asc')
                              ->get();

    return $informe_tramo;

  }

    public function getPasadasJuntas($id){

        $pasadas_juntas = DB::table('informes_rd')
                                ->join('juntas_rd','juntas_rd.informe_rd_id','=','informes_rd.id')
                                ->join('pasadas_junta_rd','pasadas_junta_rd.junta_id','=','juntas_rd.id')
                                ->where('informes_rd.id',$id)
                                ->selectRaw('numero as pasada,soldadorl_id,soldadorp_id,soldadorz_id,juntas_rd.codigo as elemento_pasada')
                                ->get();

        foreach ($pasadas_juntas as $pasadas_junta) {

            $obj = new stdClass();

            $obj->soldador1 = DB::table('soldadores')
                                        ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')
                                        ->where('ot_soldadores.id',$pasadas_junta->soldadorz_id)
                                        ->select('soldadores.codigo','soldadores.nombre','ot_soldadores.*')
                                        ->first();

            $obj->soldador2 = DB::table('soldadores')
                                        ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')
                                        ->where('ot_soldadores.id',$pasadas_junta->soldadorl_id)
                                        ->select('soldadores.codigo','soldadores.nombre','ot_soldadores.*')
                                        ->first();

            $obj->soldador2 =   $obj->soldador2 ? $obj->soldador2 : "";

            $obj->soldador3 = DB::table('soldadores')
                                        ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')
                                        ->where('ot_soldadores.id',$pasadas_junta->soldadorp_id)
                                        ->select('soldadores.codigo','soldadores.nombre','ot_soldadores.*')
                                        ->first();

            $obj->soldador3 = $obj->soldador3 ? $obj->soldador3 : "";

            $pasadas_junta->soldador1 = $obj->soldador1;
            $pasadas_junta->soldador2 = $obj->soldador2;
            $pasadas_junta->soldador3 = $obj->soldador3;

        }

        return $pasadas_juntas;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeRdRequest $request, $id)
    {

        $EsRevision = (new \App\Http\Controllers\InformesController)->EsRevision($id);

        if($EsRevision){

            return $this->store($request,$EsRevision);

        }

        $informe = Informe::where('id',$id)
                            ->where('updated_at',$request['updated_at'])
                            ->first();

        if(is_null($informe)){

        return response()->json(['errors' => ['error' => ['Otro usuario modificó el registro que intenta actualizar, recargue la página y vuelva a intentarlo']]], 404);

        }else{

            $informeRd =InformesRd::where('informe_id',$informe->id)->first();

            DB::beginTransaction();
            try {

                $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
                $this->saveInformeRd($request,$informe,$informeRd);
                $this->deleteDetalle($request,$informeRd->id);
                $this->saveDetalle($request,$informeRd);
                $this->deleteTramos($request,$informeRd->id);
                $this->saveTramos($request,$informeRd);

            DB::commit();

            } catch (Exception $e) {

                DB::rollback();
                throw $e;

                }

            return $informe;
        }
    }

    public function getElementosReparacion($ot_id,$obra,$km,$linea,$plano_isom,$hoja){

        $km          = ($km=='null') ? '' : $km;
        $obra        = str_replace('--','/',$obra);
        $linea       = ($linea=='null') ? '' : str_replace('--','/',$linea);
        $plano_isom  = ($plano_isom=='null') ? '' : str_replace('--','/',$plano_isom);
        $hoja        = ($hoja=='null') ? '' : str_replace('--','/',$hoja);
        return  DB::select('CALL InformeRdJuntasReparacion(?,?,?,?,?,?)',array($ot_id,$obra,$km,$linea,$plano_isom,$hoja));

    }

    public function saveInformeRd($request,$informe,$informeRd){
        $informeRd->informe_id = $informe->id;
        $informeRd->reparacion_sn = $request->reparacion_sn;
        $informeRd->kv = $request->kv;
        $informeRd->ma = $request->ma;
        $informeRd->interno_fuente_id =  $request->interno_fuente ? $request->interno_fuente['id'] : null;
        $informeRd->tipo_pelicula_id = $request->tipo_pelicula['id'];
        $informeRd->medida = $request->medida['codigo'];
        $informeRd->ici_id  = $request->ici['id'];
        $informeRd->gasoducto_sn = $request->gasoducto_sn;
        $informeRd->perfil_sn = $request->perfil_sn;
        $informeRd->pantalla = $request->pantalla;
        $informeRd->pos_ant = $request->pos_ant;
        $informeRd->pos_pos = $request->pos_pos;
        $informeRd->lado    = $request->lado;
        $informeRd->distancia_fuente_pelicula = $request->distancia_fuente_pelicula;
        Log::debug($request->tecnica);
        $informeRd->tecnicas_grafico_id = $request->tecnica['grafico_id'];
        Log::debug($informeRd->tecnicas_grafico_id);
        $informeRd->exposicion = $request->exposicion;
        $informeRd->resultado_pdf_sn = $request->resultado_pdf_sn;
        $informeRd->save();

      }
      public function saveTramos($request,$informeRd){
          foreach ($request->tramos as $tramo){
            try {
                $referencia_id = $this->saveReferencia($tramo);
                $tramox =  new TramosRd;
                $tramox->informes_rd_id = $informeRd->id;
                $tramox->bola_comparadora = $tramo['bola_comparadora'];
                $tramox->espesor = $tramo['espesor_tramo'];
                $tramox->tramo = $tramo['tramo'];
                $tramox->observaciones = $tramo['observacion_tramo'];
                $tramox->tramo_rd_referencia_id = $referencia_id;
                $tramox->save();
            }
            catch(Exception $e){

                if ($e->getCode() != '23000'){

                  throw $e;

                }

            }
          }
      }
      public function saveReferencia($detalle){
        if (($detalle['path1']) ||
            ($detalle['path2']) ||
            ($detalle['path3']) ||
            ($detalle['path4'])){

              $detalle_rd_referencia                     = new DetallesRdReferencias;
              $detalle_rd_referencia->descripcion        = $detalle['observaciones'];
              $detalle_rd_referencia->path1              = $detalle['path1'];
              $detalle_rd_referencia->path2              = $detalle['path2'];
              $detalle_rd_referencia->path3              = $detalle['path3'];
              $detalle_rd_referencia->path4              = $detalle['path4'];
              $detalle_rd_referencia->save();

              return $detalle_rd_referencia->id;
           }
           else{
              return null;
           }

      }
      public function saveDetalle($request,$informeRd){

          foreach ($request->detalles as $detalle){
            try {

              $junta = $this->saveJunta($detalle,$informeRd);
              $this->savePasadasJunta($request->TablaPasadas,$junta);

            }
            catch(Exception $e){

              if ($e->getCode() != '23000'){

                throw $e;

              }

            }

            try {

              $posicion = $this->savePosicion($detalle,$junta);


             }
             catch(Exception $j){

               if ($j->getCode() != '23000'){

                 throw $j;

               }

             }

             try {

              $this->saveDefectos($detalle['defectos'],$posicion);

             }
             catch(Exception $z){

               if ($z->getCode() != '23000'){

                 throw $z;

               }

             }

          }

      }

      public function saveJunta($detalle,$informeRd){

        $junta =  new JuntasRd;
        $junta->codigo = $detalle['junta'];
        $junta->informe_rd_id = $informeRd->id;
        $junta->save();

        return $junta;
      }

      public function saveTramo($tramo,$informeRd){
        $tramox =  new TramosRd;
        $tramox->informes_rd_id = $informeRd->id;
        $tramox->bola_comparadora = $tramo['bola_comparadora'];
        $tramox->espesor = $tramo['espesor_tramo'];
        $tramox->tramo = $tramo['tramo'];
        $tramox->observaciones = $tramo['observacion_tramo'];
        $tramox->save();

        return $tramox;
      }
      public function savePosicion($detalle,$junta){

        $posicion = new PosicionRd;
        $posicion->junta_id = $junta['id'];
        $posicion->codigo = $detalle['posicion'];
        $posicion->densidad = $detalle['densidad'];
        $posicion->descripcion = $detalle['observacion'] ;
        $posicion->aceptable_sn = $detalle['aceptable_sn'];
        $posicion->save();

        return $posicion;
      }

      public function savePasadasJunta($pasadas,$junta){

          foreach ($pasadas as $pasada) {

            if(trim($pasada['elemento_pasada']) == trim($junta['codigo'])){

                $pasadasJunta = new PasadasJuntaRd;
                $pasadasJunta->numero = $pasada['pasada'];
                $pasadasJunta->junta_id = $junta['id'];
                $pasadasJunta->soldadorz_id = $pasada['soldador1']['id'];
                $pasadasJunta->soldadorl_id = $pasada['soldador2']['id'];
                $pasadasJunta->soldadorp_id = $pasada['soldador3']['id'];
                $pasadasJunta->save();

            }

          }
      }

      public function saveDefectos($defectos,$posicion){

            foreach ($defectos as $defecto) {
              $defectosPosicion = new DefectosPosicionRd;
              $defectosPosicion->posicion_id = $posicion['id'];
              $defectosPosicion->defecto_rd_id = $defecto['id'];
              $defectosPosicion->posicion = $defecto['posicion'];
              $defectosPosicion->pasada = $defecto['pasada'];
              Log::debug($defectosPosicion);
              $defectosPosicion->save();
            }

      }

    public function deleteDetalle($request,$id){

          DB::delete('delete dpp from defectos_posicion_rd as dpp
                          inner join posicion_rd as p on dpp.posicion_id = p.id
                          inner join juntas_rd as j on j.id = p.junta_id
                          inner join informes_rd as ir on j.informe_rd_id = ir.id
                          where
                          ir.id= ?',[$id]);

          DB::delete('delete pj from pasadas_junta_rd as pj
                          inner join juntas_rd as j on j.id = pj.junta_id
                          inner join informes_rd as ir on j.informe_rd_id = ir.id
                          where
                          ir.id= ?',[$id]);

          DB::delete('delete p from posicion_rd as p
                          inner join juntas_rd as j on j.id = p.junta_id
                          inner join informes_rd as ir on j.informe_rd_id = ir.id
                          where
                          ir.id= ?',[$id]);

          DB::delete('delete j from juntas_rd as j
                          inner join informes_rd as ir on j.informe_rd_id = ir.id
                          where
                          ir.id= ?',[$id]);

      }
      public function deleteTramos($request,$id){

        DB::delete('delete tramos from tramo_perfil_rd as tramos
                        where
                        tramos.informes_rd_id= ?',[$id]);

    }
    public function destroy($id)
    {
        //
    }
}
