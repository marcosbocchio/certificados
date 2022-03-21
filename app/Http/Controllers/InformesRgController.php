<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InformeRgRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Ots;
use App\Informe;
use App\InformesRg;
use App\Materiales;
use App\DiametroView;
use App\Soldadores;
use App\DiametrosEspesor;
use App\NormaEvaluaciones;
use App\NormaEnsayos;
use App\InternoEquipos;
use App\DetallesRg;
use App\DetallesRgReferencias;
use \stdClass;
use App\User;
use App\OtTipoSoldaduras;
use Exception as Exception;

class InformesRgController extends Controller
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
        $metodo = 'RG';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $ot = Ots::findOrFail($ot_id);

        return view('informes.rg.index', compact('ot',
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
    public function store(InformeRgRequest $request,$EsRevision = false)
    {
        $informe  = new Informe;
        $informeRg  = new InformesRg;

        DB::beginTransaction();
        try {
          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe,$EsRevision);
          $informeCv = $this->saveinformeRg($request,$informe,$informeRg);

          $this->saveDetalle($request,$informeRg);

          DB::commit();

        } catch (Exception $e) {

          DB::rollback();
          throw $e;

        }

        return $informe;
    }

    public function saveInformeRg($request,$informe,$informeRg){
        Log::debug($informe);
        $informeRg->informe_id = $informe->id;
        $informeRg->recorrido_terminal = $request->recorrido_terminal;
        $informeRg->cut_off = $request->cut_off;
        $informeRg->rango_inicial = $request->rango_inicial;
        $informeRg->rango_final = $request->rango_final;
        $informeRg->save();

        return $informeRg;

      }

    public function saveDetalle($request,$informeRg){
        foreach ($request->detalles as $detalle){
            $referencia_id = $this->saveReferencia($detalle);
            $detalleRg  = new DetallesRg;
          $detalleRg->informe_rg_id = $informeRg->id;
          $detalleRg->elemento = $detalle['elemento'];
          $detalleRg->ra_a = $detalle['ra_a'];
          $detalleRg->ra_b = $detalle['ra_b'];
          $detalleRg->ra_c = $detalle['ra_c'];
          $detalleRg->detalle_rg_referencia_id = $referencia_id;
          $detalleRg->save();
        }

      }


      public function saveReferencia($detalle){
          Log::debug($detalle);
        if (($detalle['path1']) ||
            ($detalle['path2']) ||
            ($detalle['path3']) ||
            ($detalle['path4'])){

              $detalle_rg_referencia                     = new DetallesRgReferencias;
              $detalle_rg_referencia->descripcion        = $detalle['observaciones'];
              $detalle_rg_referencia->path1              = $detalle['path1'];
              $detalle_rg_referencia->path2              = $detalle['path2'];
              $detalle_rg_referencia->path3              = $detalle['path3'];
              $detalle_rg_referencia->path4              = $detalle['path4'];
              $detalle_rg_referencia->save();

              return $detalle_rg_referencia->id;
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
        $metodo = 'RG';
        $accion = 'edit';
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::where('id',$id)->with('planta')->first();
        $informe_rg =InformesRg::where('informe_id',$informe->id)->first();
        $informe_material = Materiales::find($informe->material_id);
        $documetacionesRepository = new DocumentacionesRepository;
        $informe_procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);
        $informe_norma_evaluacion = NormaEvaluaciones::find($informe->norma_evaluacion_id);
        $informe_norma_ensayo = NormaEnsayos::find($informe->norma_ensayo_id);
        $informe_ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $informe_material_accesorio = Materiales::find($informe->material2_id);
        if ($informe_material_accesorio == null){
            $informe_material_accesorio = new Materiales();
        }
        $informe_ot_tipo_soldadura = OtTipoSoldaduras::join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
        ->where('ot_tipo_soldaduras.id',$informe->ot_tipo_soldadura_id)->with('tipoSoldadura')->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')->first();
        if ($informe_ot_tipo_soldadura == null){
            $informe_ot_tipo_soldadura = new OtTipoSoldaduras();
        }
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
        if ($informe_solicitado_por == null){
            $informe_solicitado_por = new User();
        }
        $informe_detalle = $this->getDetalle($informe_rg->id);
        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        return view('informes.rg.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_rg',
                                                 'informe_material',
                                                 'informe_material_accesorio',
                                                 'informe_procedimiento',
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',
                                                 'informe_modelos_3d',
                                                 'header_titulo',
                                                 'informe_detalle',
                                                 'informe_ot_tipo_soldadura',
                                                 'informe_solicitado_por',
                                                 'header_descripcion'));
    }

    public function getDetalle($id){

        $informe_detalles = DB::table('detalles_rg')
                               ->leftjoin('detalles_rg_referencias','detalles_rg_referencias.id','=','detalles_rg.detalle_rg_referencia_id')
                               ->where('detalles_rg.informe_rg_id',$id)
                               ->selectRaw('detalles_rg.elemento as elemento,
                                          detalles_rg.ra_a as ra_a,
                                          detalles_rg.ra_b as ra_b,
                                          detalles_rg.ra_c as ra_c,
                                          detalles_rg_referencias.descripcion as observaciones,
                                          detalles_rg_referencias.path1 as path1,
                                          detalles_rg_referencias.path2 as path2,
                                          detalles_rg_referencias.path3 as path3,
                                          detalles_rg_referencias.path4 as path4')
                                ->orderBy('detalles_rg.id','asc')
                                ->get();

        return $informe_detalles;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeRgRequest $request, $id){

        $EsRevision = (new \App\Http\Controllers\InformesController)->EsRevision($id);

        if($EsRevision){

           return $this->store($request,$EsRevision);

        }

       $informe  = Informe::find($id);
       $informeRg =InformesRg::where('informe_id',$informe->id)->first();

       DB::beginTransaction();
       try {

           $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
           $this->saveInformeRg($request,$informe,$informeRg);
           DetallesRg::where('informe_rg_id',$informeRg->id)->delete();
           $this->saveDetalle($request,$informeRg);
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
