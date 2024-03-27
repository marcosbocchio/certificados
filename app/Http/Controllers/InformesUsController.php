<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InformeUsRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Informe;
use App\InformesUs;
use App\Materiales;
use App\DiametroView;
use App\DiametrosEspesor;
use App\Tecnicas;
use App\InternoEquipos;
use App\NormaEvaluaciones;
use App\NormaEnsayos;
use App\EstadosSuperficies;
use App\CalibracionesUs;
use App\DetalleUsPaUs;
use App\DetallesUsPaUsReferencias;
use App\InformesUsMe;
use App\AccesoriosUs;
use App\DetalleUsMe;
use App\Ots;
use \stdClass;
use App\User;
use App\OtTipoSoldaduras;
use App\AgenteAcoplamientos;
use Exception as Exception;
use Illuminate\Support\Facades\Log;

class InformesUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('ddppi')->only('create');
        $this->middleware(['role_or_permission:Sistemas|T_informes_edita'],['only' => ['create','edit']]);

    }

    public function create($ot_id)
    {
        $metodo = 'US';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $ot = Ots::findOrFail($ot_id);
        return view('informes.us.index', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'header_titulo',
                                                 'header_descripcion'));
    }

    public function store(InformeUsRequest $request,$EsRevision = false)
    {
        $informe  = new Informe;
        $informeUs  = new InformesUs;

        DB::beginTransaction();
        try {

          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe,$EsRevision);
          $informeUs = $this->saveinformeUs($request,$informe,$informeUs);
          $tecnica = Tecnicas::find($informe->tecnica_id);
          $this->saveCalibraciones($request,$informeUs);

          if ($tecnica->codigo == 'ME'){

            $this->saveInforme_us_me($request,$informeUs);

          }else{

            $this->saveDetalle_us_pa_us($request,$informeUs);

          }

          DB::commit();

        } catch (Exception $e) {

          DB::rollback();
          throw $e;

        }

        return $informe;
    }

    public function update(InformeUsRequest $request, $id){


        $EsRevision = (new \App\Http\Controllers\InformesController)->EsRevision($id);

        if($EsRevision){

            return $this->store($request,$EsRevision);

        }

        $informe  = Informe::find($id);
        $informeUs =InformesUs::where('informe_id',$informe->id)->first();
        $tecnica = Tecnicas::find($request->tecnica['id']);

        DB::beginTransaction();
        try {

            $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
            $this->saveInformeUs($request,$informe,$informeUs);
            CalibracionesUs::where('informe_us_id',$informeUs->id)->delete();
            $this->saveCalibraciones($request,$informeUs);

            DetalleUsPaUs::where('informe_us_id',$informeUs->id)->delete();
            $this->deleteInforme_us_me($informeUs->id);

            if ($tecnica->codigo == 'ME'){

                $this->saveInforme_us_me($request,$informeUs);
            }else{

                $this->saveDetalle_us_pa_us($request,$informeUs);
            }

            DB::commit();

          } catch (Exception $e) {

            DB::rollback();
            throw $e;

          }
          return $informe;

      }

      public function deleteInforme_us_me($informe_us_id){

        DB::delete('delete dum from detalle_us_me as dum
                      inner join informes_us_me as ium on dum.informe_us_me_id = ium.id
                      where
                      ium.informe_us_id= ?',[$informe_us_id]);

        DB::delete('delete ium from informes_us_me as ium
                      where
                      ium.informe_us_id= ?',[$informe_us_id]);
      }

    public function saveInformeUs($request,$informe,$informeUs){

        $informeUs->informe_id = $informe->id;
        $informeUs->estado_superficie_id = $request->estado_superficie['id'];
        $informeUs->encoder = $request->encoder;
        $informeUs->agente_acoplamiento_id  = $request->agente_acoplamiento['id'];
        $informeUs->path1_calibracion = $request->path1_calibracion;
        $informeUs->path2_calibracion = $request->path2_calibracion;
        $informeUs->path3_calibracion = $request->path3_calibracion;
        $informeUs->path4_calibracion = $request->path4_calibracion;
        $informeUs->path1_indicacion = $request->path1_indicacion;
        $informeUs->path2_indicacion = $request->path2_indicacion;
        $informeUs->path3_indicacion = $request->path3_indicacion;
        $informeUs->path4_indicacion = $request->path4_indicacion;
        $informeUs->save();

        return $informeUs;

      }

    public function saveCalibraciones($request,$informeUs){


        foreach ($request->calibraciones as $calibracion){

            $calibracionUs  = new CalibracionesUs;
            $calibracionUs->informe_us_id = $informeUs->id;
            $calibracionUs->palpador_id = $calibracion['palpador']['id'];
            $calibracionUs->zapata = $calibracion['zapata'];
            $calibracionUs->frecuencia = $calibracion['frecuencia'];
            $calibracionUs->angulo_apertura = $calibracion['angulo_apertura'];
            $calibracionUs->rango = $calibracion['rango'];
            $calibracionUs->posicion = $calibracion['posicion'];
            $calibracionUs->curva_elevacion = $calibracion['curva_elevacion'];
            $calibracionUs->block_calibracion = $calibracion['block_calibracion'];
            $calibracionUs->block_sensibilidad = $calibracion['block_sensibilidad'];
            $calibracionUs->tipo_reflector = $calibracion['tipo_reflector'];
            $calibracionUs->reflector_referencia = $calibracion['reflector_referencia'];
            $calibracionUs->ganancia_referencia = $calibracion['ganancia_referencia'];
            $calibracionUs->nivel_registro = $calibracion['nivel_registro'];
            $calibracionUs->correccion_transferencia = $calibracion['correccion_transferencia'];
            $calibracionUs->adicional_barrido = $calibracion['adicional_barrido'];
            $calibracionUs->amplificacion_total = $calibracion['amplificacion_total'];

            $calibracionUs->save();

          }

    }

    public function saveDetalle_us_pa_us($request,$informeUs){

        foreach ($request->tabla_us_pa as $detalle_us_pa){


            $referencia_id = $this->saveReferencia($detalle_us_pa);

            $detalle_us_pa_us  = new DetalleUsPaUs;
            $detalle_us_pa_us->informe_us_id = $informeUs->id;
            $detalle_us_pa_us->detalle_us_pa_us_referencia_id = $referencia_id;
            $detalle_us_pa_us->diametro = $detalle_us_pa['diametro_us_pa'];
            $detalle_us_pa_us->elemento = $detalle_us_pa['elemento_us_pa'];
            $detalle_us_pa_us->soldador_p_id = $detalle_us_pa['soldadorP'];
            $detalle_us_pa_us->soldador_z_id = $detalle_us_pa['soldadorZ'];
            $detalle_us_pa_us->nro_indicacion = $detalle_us_pa['nro_indicacion_us_pa'];
            $detalle_us_pa_us->posicion_examen = $detalle_us_pa['posicion_examen_us_pa'];
            $detalle_us_pa_us->angulo_incidencia = $detalle_us_pa['angulo_incidencia_us_pa'];
            $detalle_us_pa_us->camino_sonico = $detalle_us_pa['camino_sonico_us_pa'];
            $detalle_us_pa_us->x = $detalle_us_pa['x_us_pa'];
            $detalle_us_pa_us->y = $detalle_us_pa['y_us_pa'];
            $detalle_us_pa_us->z = $detalle_us_pa['z_us_pa'];
            $detalle_us_pa_us->longitud = $detalle_us_pa['longitud_us_pa'];
            $detalle_us_pa_us->nivel_registro = $detalle_us_pa['nivel_registro_us_pa'];
            $detalle_us_pa_us->aceptable_sn = $detalle_us_pa['aceptable_sn_us_pa'];

            $detalle_us_pa_us->save();

        }

    }

    public function saveReferencia($detalle){

        if (($detalle['observaciones'])||
            ($detalle['path1']) ||
            ($detalle['path2']) ||
            ($detalle['path3']) ||
            ($detalle['path4'])){

              $detalle_us_pa_us_referencia                     = new DetallesUsPaUsReferencias;
              $detalle_us_pa_us_referencia->descripcion        = $detalle['observaciones'];
              $detalle_us_pa_us_referencia->path1              = $detalle['path1'];
              $detalle_us_pa_us_referencia->path2              = $detalle['path2'];
              $detalle_us_pa_us_referencia->path3              = $detalle['path3'];
              $detalle_us_pa_us_referencia->path4              = $detalle['path4'];
              $detalle_us_pa_us_referencia->save();

              return $detalle_us_pa_us_referencia->id;
           }
           else{
              return null;
           }

      }

      public function saveInforme_us_me($request,$informeUs){

        foreach ($request->tabla_me as $detalle_informe_us_me) {
            $informe_us_me  = new InformesUsMe;
            $informe_us_me->informe_us_id = $informeUs->id;
            $informe_us_me->umbral = $detalle_informe_us_me['umbral_me'];
            $informe_us_me->espesor_minimo = $detalle_informe_us_me['espesor_minimo_me'];
            $informe_us_me->elemento = $detalle_informe_us_me['elemento_me'];
            $informe_us_me->cantidad_posiciones = $detalle_informe_us_me['cantidad_posiciones_me'];
            $informe_us_me->cantidad_generatrices = $detalle_informe_us_me['cantidad_generatrices_me'];
            $informe_us_me->cantidad_generatrices_linea_pdf = $detalle_informe_us_me['cantidad_generatrices_linea_pdf_me'];
            $informe_us_me->save();
            

            $this->saveMediciones($informe_us_me->cantidad_generatrices,$informe_us_me->cantidad_posiciones,$detalle_informe_us_me['mediciones'],$informe_us_me);
        }
    }

    public function saveMediciones($cantidad_generatrices, $cantidad_posiciones, $mediciones, $informe_us_me){

        for ($x = 0; $x < $cantidad_generatrices +1; $x++) {
            for ($y = 1; $y <= $cantidad_posiciones; $y++) {
                $detalle_us_me = new DetalleUsMe;
                $generatriz = $mediciones[$x][0];
                $posicion = $mediciones[0][$y];
                $valor = $mediciones[$x][$y];
                $detalle_us_me->informe_us_me_id = $informe_us_me->id;
                $detalle_us_me->posicion = $posicion;
                $detalle_us_me->generatriz = $generatriz;
                if ($x < $cantidad_generatrices) {
                    $detalle_us_me->valor = $valor; 
                } else{
                    $detalle_us_me->accesorio_texto = $valor; 
                }
                $detalle_us_me->save();
            }
        }
    }

    public function edit($ot_id,$id)
    {
        $header_titulo = "Informe";
        $header_descripcion ="Editar";
        $metodo = 'US';
        $accion = 'edit';
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::where('id',$id)->with('planta')->first();
        $informe_us =InformesUs::where('informe_id',$informe->id)->first();
        $informe_material = Materiales::find($informe->material_id);
        $informe_material_accesorio = Materiales::find($informe->material2_id);
        $informe_tecnica = Tecnicas::find($informe->tecnica_id);
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
        if ($informe_solicitado_por == null){
            $informe_solicitado_por = new User();
        }
        $informe_diametroEspesor = $informe->diametro_espesor_id ? DiametrosEspesor::find($informe->diametro_espesor_id) : null ;
        $informe_diametro = $informe_diametroEspesor ? DiametroView::where('diametro',$informe_diametroEspesor->diametro)->first() : null;
        $informe_interno_equipo = internoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
        $documetacionesRepository = new DocumentacionesRepository;
        $informe_procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);
        $informe_norma_evaluacion = NormaEvaluaciones::find($informe->norma_evaluacion_id);
        $informe_norma_ensayo = NormaEnsayos::find($informe->norma_ensayo_id);
        $informe_ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $informe_estado_superficie = EstadosSuperficies::find($informe_us->estado_superficie_id);
        $informe_agente_acoplamiento = AgenteAcoplamientos::find($informe_us->agente_acoplamiento_id);

        $calibraciones  = $this->getCalibraciones($informe_us->id);
        $tabla_us_pa    = $this->getTabla_us_pa($informe_us->id);
        $tabla_me       = $this->getTabla_me($informe_us->id);

        if ($informe_material_accesorio == null)
               $informe_material_accesorio = new Materiales();

        $informe_ot_tipo_soldadura = OtTipoSoldaduras::join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
        ->where('ot_tipo_soldaduras.id',$informe->ot_tipo_soldadura_id)->with('tipoSoldadura')->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')->first();

        if ($informe_ot_tipo_soldadura == null)
                $informe_ot_tipo_soldadura = new OtTipoSoldaduras();

        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        if ($informe_diametroEspesor == null)
          $informe_diametroEspesor = new DiametrosEspesor();

        if ($informe_diametro == null)
          $informe_diametro = new DiametroView();

        // dd($informe_diametroEspesor,$informe_diametro);
        return view('informes.us.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_us',
                                                 'informe_diametro',
                                                 'informe_diametroEspesor',
                                                 'informe_tecnica',
                                                 'informe_material',
                                                 'informe_ot_tipo_soldadura',
                                                 'informe_material_accesorio',
                                                 'informe_interno_equipo',
                                                 'informe_procedimiento',
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',
                                                 'informe_estado_superficie',
                                                 'informe_agente_acoplamiento',
                                                 'calibraciones',
                                                 'tabla_us_pa',
                                                 'tabla_me',
                                                 'informe_modelos_3d',
                                                 'header_titulo',
                                                 'informe_solicitado_por',
                                                 'header_descripcion'));
    }

    public function getCalibraciones($informe_us_id){

        $calibraciones =  CalibracionesUs::
                             where('informe_us_id',$informe_us_id)
                            ->select('calibraciones_us.*')
                            ->with('palpador')
                            ->get();

        return $calibraciones;

    }

    public function getTabla_us_pa($informe_us_id){

        $tabla_us_pa =  DB::table('detalle_us_pa_us')
                            ->leftjoin('detalles_us_pa_us_referencias','detalles_us_pa_us_referencias.id','=','detalle_us_pa_us.detalle_us_pa_us_referencia_id')
                            ->where('informe_us_id',$informe_us_id)
                            ->selectRaw('detalle_us_pa_us.elemento as elemento_us_pa,
                                        detalle_us_pa_us.soldador_p_id as soldadorP,
                                        detalle_us_pa_us.soldador_z_id as soldadorZ,
                                        detalle_us_pa_us.diametro as diametro_us_pa,
                                        detalle_us_pa_us.nro_indicacion as nro_indicacion_us_pa,
                                        detalle_us_pa_us.posicion_examen as posicion_examen_us_pa,
                                        detalle_us_pa_us.angulo_incidencia as angulo_incidencia_us_pa,
                                        detalle_us_pa_us.camino_sonico as camino_sonico_us_pa,
                                        detalle_us_pa_us.x as x_us_pa,
                                        detalle_us_pa_us.y as y_us_pa,
                                        detalle_us_pa_us.z as z_us_pa,
                                        detalle_us_pa_us.longitud as longitud_us_pa ,
                                        detalle_us_pa_us.nivel_registro as nivel_registro_us_pa,
                                        detalle_us_pa_us.aceptable_sn as aceptable_sn_us_pa,
                                        detalles_us_pa_us_referencias.descripcion as observaciones,
                                        detalles_us_pa_us_referencias.path1 as path1,
                                        detalles_us_pa_us_referencias.path2 as path2,
                                        detalles_us_pa_us_referencias.path3 as path3,
                                        detalles_us_pa_us_referencias.path4 as path4')
                            ->get();

        return $tabla_us_pa;

    }

    public function getTabla_me($informe_us_id){

        $obj = new stdClass();
        $tabla_me = DB::table('informes_us_me')
                        ->where('informe_us_id',$informe_us_id)
                        ->selectRaw('informes_us_me.id,
                                    informes_us_me.cantidad_generatrices as cantidad_generatrices_me,
                                    informes_us_me.cantidad_posiciones as cantidad_posiciones_me,
                                    informes_us_me.cantidad_generatrices_linea_pdf as cantidad_generatrices_linea_pdf_me,
                                    informes_us_me.diametro as diametro_me,
                                    informes_us_me.elemento as elemento_me,
                                    informes_us_me.umbral as umbral_me,
                                    informes_us_me.espesor_minimo as espesor_minimo_me')
                                    
                        ->get();


        foreach ($tabla_me as $generatriz) {
            
            $obj = new stdClass();
            $cant_g = (int) $generatriz->cantidad_generatrices_me;
            $cant_p = (int) $generatriz->cantidad_posiciones_me;

            $mediciones = array();

            for ($g=0; $g < $cant_g ; $g++) {


                $posiciones = array();
                for ($p=0; $p < $cant_p; $p++){

                  array_push($posiciones,'');

                }
                array_push($mediciones,$posiciones);

            }

            $obj->mediciones = $mediciones;

            $generatriz->mediciones = $mediciones;

        }

        foreach ($tabla_me as $generatriz) {

            $detalle_us_me = DetalleUsMe::where('informe_us_me_id',$generatriz->id)->get();
            $cant_g = (int) $generatriz->cantidad_generatrices_me;
            $cant_p = (int) $generatriz->cantidad_posiciones_me;

            for ($y=0; $y < $cant_g * $cant_p; $y+=$cant_p) {
                $generatriz->mediciones[$y/$cant_p + 1][0] = $detalle_us_me[$y]->generatriz;
            }

            $generatriz->mediciones[$cant_g + 1][0] = 'ACCESORIO';
            
            for ($y=0; $y < $cant_p; $y++) {
               $generatriz->mediciones[0][$y +1 ] = $detalle_us_me[$y]->posicion;
            }

            for ($y = $cant_g * $cant_p; $y < ($cant_g * $cant_p) + $cant_p; $y++) {
                
                $texto_accesorio = isset($detalle_us_me[$y]) ? $detalle_us_me[$y]->accesorio_texto : null;
                $generatriz->mediciones[$cant_g + 1][($y - ($cant_g * $cant_p)) + 1] = $texto_accesorio;
            }

            for ($y= 0; $y < (count($detalle_us_me) - $cant_p); $y++) {

                $pos_g = (int) ceil(($y + 1)/$cant_p);
                $pos_p = (int) abs($y + 1 - ($cant_p * ($pos_g - 1)));
                $generatriz->mediciones[$pos_g][$pos_p] = $detalle_us_me[$y]->valor ? $detalle_us_me[$y]->valor : "";

            }
            array_shift($generatriz->mediciones);
        }
        

       return $tabla_me;

    }

    public function formarMediciones() {


    }

}
