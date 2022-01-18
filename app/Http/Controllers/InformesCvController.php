<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InformeCvRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Ots;
use App\Informe;
use App\InformesCv;
use App\Materiales;
use App\DiametroView;
use App\Soldadores;
use App\DiametrosEspesor;
use App\NormaEvaluaciones;
use App\Campanas;
use App\Bombas;
use App\NormaEnsayos;
use App\InternoEquipos;
use App\TipoLiquidos;
use App\AplicacionesLp;
use App\DetallesCv;
use App\MetodosTrabajoLp;
use App\DetallesCvReferencias;
use \stdClass;
use App\OtTipoSoldaduras;
use Exception as Exception;

class InformesCvController extends Controller
{

    public function __construct()
    {
        $this->middleware('ddppi')->only('create');
        $this->middleware(['role_or_permission:Sistemas|T_informes_edita'],['only' => ['create','edit']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $metodo = 'CV';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $ot = Ots::findOrFail($ot_id);

        return view('informes.cv.index', compact('ot',
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
    public function store(InformeCvRequest $request,$EsRevision = false)
    {
        $informe  = new Informe;
        $informeCv  = new InformesCv;

        DB::beginTransaction();
        try {

          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe,$EsRevision);
          $informeCv = $this->saveinformeCv($request,$informe,$informeCv);

          $this->saveDetalle($request,$informeCv);

          DB::commit();

        } catch (Exception $e) {

          DB::rollback();
          throw $e;

        }

        return $informe;
    }

    public function saveInformeCv($request,$informe,$informeCv){
        $informeCv->informe_id = $informe->id;
        $informeCv->campana_id = $request->campana['id'];
        $informeCv->presion_max_manometro = $request->campana['presion_max_manometro'];
        $informeCv->presion_trabajo_min = $request->campana['presion_trabajo_min'];
        $informeCv->presion_trabajo_max = $request->campana['presion_trabajo_max'];
        $informeCv->alto = $request->campana['alto'];
        $informeCv->ancho = $request->campana['ancho'];
        $informeCv->profundidad = $request->campana['profundidad'];
        $informeCv->bomba_id = $request->bomba['id'];
        $informeCv->caudal = $request->bomba['caudal'];
        $informeCv->voltaje = $request->bomba['voltaje'];
        $informeCv->extension_ensayo = $request->extension_ensayo;
        $informeCv->liquido = $request->liquido;
        $informeCv->aplicacion_id = $request->modo_aplicacion['id'];
        $informeCv->estado_producto = $request->estado_producto;

        $informeCv->save();

        return $informeCv;

      }

    public function saveDetalle($request,$informeCv){
        foreach ($request->detalles as $detalle){
            $referencia_id = $this->saveReferencia($detalle);

          $diametro = $detalle['diametro'];
          $soldador = $detalle['soldador'];
          $detalleCv  = new DetallesCv;
          $detalleCv->informe_cv_id = $informeCv->id;
          $detalleCv->elemento = $detalle['elemento'];
          $diametro_base = DiametrosEspesor::where('diametro',$diametro['diametro'])->first();
          $detalleCv->diametro_id = $diametro_base['id'];
          $detalleCv->soldador_id = $soldador['soldadores_id'];
          $detalleCv->aceptable_sn = $detalle['aceptable_sn'];
          $detalleCv->detalle_cv_referencia_id = $referencia_id;
          $detalleCv->save();
        }

      }


      public function saveReferencia($detalle){
          Log::debug($detalle);
        if (($detalle['path1']) ||
            ($detalle['path2']) ||
            ($detalle['path3']) ||
            ($detalle['path4'])){

              $detalle_cv_referencia                     = new DetallesCvReferencias;
              $detalle_cv_referencia->descripcion        = $detalle['observaciones'];
              $detalle_cv_referencia->path1              = $detalle['path1'];
              $detalle_cv_referencia->path2              = $detalle['path2'];
              $detalle_cv_referencia->path3              = $detalle['path3'];
              $detalle_cv_referencia->path4              = $detalle['path4'];
              $detalle_cv_referencia->save();

              return $detalle_cv_referencia->id;
           }
           else{
              return null;
           }

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
    public function edit($ot_id,$id)
    {
        $header_titulo = "Informe";
        $header_descripcion ="Editar";
        $metodo = 'CV';
        $accion = 'edit';
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::findOrFail($id);
        $informe_cv =InformesCv::where('informe_id',$informe->id)->first();
        $informe_material = Materiales::find($informe->material_id);
        $documetacionesRepository = new DocumentacionesRepository;
        $informe_procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);
        $informe_norma_evaluacion = NormaEvaluaciones::find($informe->norma_evaluacion_id);
        $informe_norma_ensayo = NormaEnsayos::find($informe->norma_ensayo_id);
        $informe_ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $informe_campana = Campanas::find($informe_cv->campana_id);
        $informe_bomba = Bombas::find($informe_cv->bomba_id);
        $informe_material_accesorio = Materiales::find($informe->material2_id);
        if ($informe_material_accesorio == null){
            $informe_material_accesorio = new Materiales();
        }
        $informe_ot_tipo_soldadura = OtTipoSoldaduras::join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
        ->where('ot_tipo_soldaduras.id',$informe->ot_tipo_soldadura_id)->with('tipoSoldadura')->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')->first();
        if ($informe_ot_tipo_soldadura == null){
            $informe_ot_tipo_soldadura = new OtTipoSoldaduras();
        }
        $informe_detalle = $this->getDetalle($informe_cv->id);
        $informe_modo_aplicacion = AplicacionesLp::find($informe_cv->aplicacion_id);
        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        return view('informes.cv.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_cv',
                                                 'informe_material',
                                                 'informe_material_accesorio',
                                                 'informe_procedimiento',
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',
                                                 'informe_modelos_3d',
                                                 'header_titulo',
                                                 'informe_campana',
                                                 'informe_bomba',
                                                 'informe_detalle',
                                                 'informe_modo_aplicacion',
                                                 'informe_ot_tipo_soldadura',
                                                 'header_descripcion'));
    }

    public function getDetalle($id){

        $informe_detalles = DB::table('detalles_cv')
                               ->leftjoin('detalles_cv_referencias','detalles_cv_referencias.id','=','detalles_cv.detalle_cv_referencia_id')
                               ->where('detalles_cv.informe_cv_id',$id)
                               ->selectRaw('detalles_cv.elemento as elemento,
                                          detalles_cv.soldador_id as soldador_id,
                                          detalles_cv.aceptable_sn as aceptable_sn,
                                          detalles_cv_referencias.descripcion as observaciones,
                                          detalles_cv.diametro_id as diametro_id,
                                          detalles_cv_referencias.path1 as path1,
                                          detalles_cv_referencias.path2 as path2,
                                          detalles_cv_referencias.path3 as path3,
                                          detalles_cv_referencias.path4 as path4')
                                ->orderBy('detalles_cv.id','asc')
                                ->get();

        $this->addObjectSoldador($informe_detalles);
        $this->addObjectDiametro($informe_detalles);
        return $informe_detalles;
    }

    public function addObjectSoldador($items){
        foreach ($items as $item) {
            $obj = new stdClass();
            $soldador = Soldadores::find($item->soldador_id);
            $soldador->soldadores_id = $item->soldador_id;
            $obj = $soldador;
            $item->soldador = $obj;
        }
     }

     public function addObjectDiametro($items){
        foreach ($items as $item) {
            $obj = new stdClass();
            $diametro = DiametrosEspesor::find($item->diametro_id);
            $obj = $diametro ;
            $item->diametro = $obj;
        }
     }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeCvRequest $request, $id){

        $EsRevision = (new \App\Http\Controllers\InformesController)->EsRevision($id);

        if($EsRevision){

           return $this->store($request,$EsRevision);

        }

       $informe  = Informe::find($id);
       $informeCv =InformesCv::where('informe_id',$informe->id)->first();

       DB::beginTransaction();
       try {

           $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
           $this->saveInformeCv($request,$informe,$informeCv);
           DetallesCv::where('informe_cv_id',$informeCv->id)->delete();
           $this->saveDetalle($request,$informeCv);
           DB::commit();

         } catch (Exception $e) {

           DB::rollback();
           throw $e;

         }

         return $informe;

     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
