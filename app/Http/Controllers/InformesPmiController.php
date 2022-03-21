<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InformePmiRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Ots;
use App\Informe;
use App\InformesPmi;
use App\Materiales;
use App\DiametroView;
use App\Soldadores;
use App\DiametrosEspesor;
use App\NormaEvaluaciones;
use App\NormaEnsayos;
use App\InternoEquipos;
use App\DetallesPmi;
use \stdClass;
use App\User;
use App\OtTipoSoldaduras;
use Exception as Exception;

class InformesPmiController extends Controller
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
        $metodo = 'PMI';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $ot = Ots::findOrFail($ot_id);

        return view('informes.pmi.index', compact('ot',
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
    public function store(InformePmiRequest $request,$EsRevision = false)
    {
        $informe  = new Informe;
        $informePmi  = new InformesPmi;

        DB::beginTransaction();
        try {

          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe,$EsRevision);
          $informePmi = $this->saveinformePmi($request,$informe,$informePmi);

          $this->saveDetalle($request,$informePmi);

          DB::commit();

        } catch (Exception $e) {

          DB::rollback();
          throw $e;

        }

        return $informe;
    }

    public function saveinformePmi($request,$informe,$informePmi){
        $informePmi->informe_id = $informe->id;
        $informePmi->estado_superficie = $request->estado_superficie;
        $informePmi->path = $request->path;
        $informePmi->save();

        return $informePmi;

      }

    public function saveDetalle($request,$informePmi){
        foreach ($request->detalles as $detalle){

          $material = $detalle['material'];
          $detallePmi  = new DetallesPmi;
          $detallePmi->informe_pmi_id = $informePmi->id;
          $detallePmi->muestra = $detalle['muestra'];
          $detallePmi->pieza = $detalle['pieza'];
          $detallePmi->material_id = $material['id'];
          $detallePmi->save();
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
        $metodo = 'PMI';
        $accion = 'edit';
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::where('id',$id)->with('planta')->first();
        $informe_pmi =InformesPmi::where('informe_id',$informe->id)->first();
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
        $interno_equipo = InternoEquipos::where('id',$informe->interno_equipo_id)->first();
        $informe_ot_tipo_soldadura = OtTipoSoldaduras::join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
        ->where('ot_tipo_soldaduras.id',$informe->ot_tipo_soldadura_id)->with('tipoSoldadura')->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')->first();
        if ($informe_ot_tipo_soldadura == null){
            $informe_ot_tipo_soldadura = new OtTipoSoldaduras();
        }
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
        if ($informe_solicitado_por == null){
            $informe_solicitado_por = new User();
        }
        $informe_detalle = $this->getDetalle($informe_pmi->id);
        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        return view('informes.pmi.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_pmi',
                                                 'informe_material',
                                                 'informe_material_accesorio',
                                                 'informe_procedimiento',
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',
                                                 'informe_modelos_3d',
                                                 'header_titulo',
                                                 'interno_equipo',
                                                 'informe_detalle',
                                                 'informe_ot_tipo_soldadura',
                                                 'informe_solicitado_por',
                                                 'header_descripcion'));
    }

    public function getDetalle($id){

        $informe_detalles = DB::table('detalles_pmi')
                               ->where('detalles_pmi.informe_pmi_id',$id)
                               ->selectRaw('detalles_pmi.muestra as muestra,
                                          detalles_pmi.pieza as pieza,
                                          detalles_pmi.material_id as material_id')
                                ->orderBy('detalles_pmi.id','asc')
                                ->get();

        $this->addObjectMaterial($informe_detalles);
        return $informe_detalles;
    }


     public function addObjectMaterial($items){
        foreach ($items as $item) {
            $obj = new stdClass();
            $material = Materiales::find($item->material_id);
            $obj = $material ;
            $item->material = $obj;
        }
     }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformePmiRequest $request, $id){

        $EsRevision = (new \App\Http\Controllers\InformesController)->EsRevision($id);

        if($EsRevision){

           return $this->store($request,$EsRevision);

        }

       $informe  = Informe::find($id);
       $informePmi =InformesPmi::where('informe_id',$informe->id)->first();

       DB::beginTransaction();
       try {

           $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
           $this->saveinformePmi($request,$informe,$informePmi);
           DetallesPmi::where('informe_pmi_id',$informePmi->id)->delete();
           $this->saveDetalle($request,$informePmi);
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
