<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InformeDzRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Ots;
use App\Informe;
use App\InformesDz;
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
use App\DetallesDz;
use App\EstadosSuperficies;
use App\UnidadesMedicionDureza;
use App\DetallesDzReferencias;
use App\OtUsuariosClientes;
use App\User;
use \stdClass;
use App\OtTipoSoldaduras;
use Exception as Exception;

class InformesDzController extends Controller
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
        $metodo = 'DZ';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $ot = Ots::findOrFail($ot_id);

        return view('informes.dz.index', compact('ot',
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
    public function store(InformeDzRequest $request,$EsRevision = false)
    {
        $informe  = new Informe;
        $informeDz  = new InformesDz;

        DB::beginTransaction();
        try {

          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe,$EsRevision);
          $informeDz = $this->saveinformeDz($request,$informe,$informeDz);

          $this->saveDetalle($request,$informeDz);

          DB::commit();

        } catch (Exception $e) {

          DB::rollback();
          throw $e;

        }

        return $informe;
    }

    public function saveInformeDz($request,$informe,$informeDz){
        $informeDz->informe_id = $informe->id;
        $informeDz->estado_superficie_id = $request->estado_superficie['id'];
        $informeDz->temperatura_material = $request->temperatura_material;
        $informeDz->unidad_medicion_dureza_id = $request->unidad_medicion_dureza['id'];

        $informeDz->save();

        return $informeDz;

      }

    public function saveDetalle($request,$informeDz){
        foreach ($request->detalles as $detalle){
            $referencia_id = $this->saveReferencia($detalle);
            $diametro = $detalle['diametro'];
            $espesor = $detalle['espesor'];
          $soldador = $detalle['soldador'];
          $detalleDz  = new DetallesDz;
          $detalleDz->informe_dz_id = $informeDz->id;
          $detalleDz->elemento = $detalle['elemento'];
          $detalleDz->soldador_id = $soldador['soldadores_id'];
          $detalleDz->material_base_der = $detalle['material_base_der'];
          $detalleDz->soldadura = $detalle['soldadura'];
          $detalleDz->material_base_izq = $detalle['material_base_izq'];
          $detalleDz->detalle_dz_referencia_id = $referencia_id;

          $detalleDz->espesor_especifico = null;
          $detalleDz->diametro_especifico = null;
          if (($diametro['diametro'] =='CHAPA') || ($diametro['diametro'] =='VARIOS')){

            $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro['diametro'])
                                                ->first();

            $detalleDz->diametro_espesor_id = $diametro_espesor['id'];


          }else{

              if (!isset($diametro['id'])){

                  $detalleDz->diametro_especifico = $diametro['diametro'];
              }

              if(!isset($espesor['id'])){

                  // Esta linea la pongo por un problema con vue que cuando edito un espesor no me lo convierte en objeto.
                  $detalleDz->espesor_especifico = isset($espesor['espesor']) ? $espesor['espesor'] : $espesor ;

                  $diametro_espesor = DiametrosEspesor::where('diametro',$diametro['diametro'])
                                                        ->first();
              }else {
                  $diametro_espesor = DiametrosEspesor::where('diametro',$diametro['diametro'])
                                                      ->where('espesor',$espesor['espesor'])
                                                      ->first();
              }

              $detalleDz->diametro_espesor_id = $diametro_espesor['id'];

          }

          $detalleDz->save();
        }

      }


      public function saveReferencia($detalle){
        if (($detalle['path1']) ||
            ($detalle['path2']) ||
            ($detalle['path3']) ||
            ($detalle['path4'])){

              $detalle_dz_referencia                     = new DetallesDzReferencias;
              $detalle_dz_referencia->descripcion        = $detalle['observaciones'];
              $detalle_dz_referencia->path1              = $detalle['path1'];
              $detalle_dz_referencia->path2              = $detalle['path2'];
              $detalle_dz_referencia->path3              = $detalle['path3'];
              $detalle_dz_referencia->path4              = $detalle['path4'];
              $detalle_dz_referencia->save();

              return $detalle_dz_referencia->id;
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
        $metodo = 'DZ';
        $accion = 'edit';
        $user = auth()->user();
        $ot = Ots::findOrFail($ot_id);
        $informe = Informe::where('id',$id)->with('planta')->first();
        $informe_dz =InformesDz::where('informe_id',$informe->id)->first();
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
        $informe_interno_equipo = internoEquipos::where('id',$informe->interno_equipo_id)->with('equipo')->first();
        $informe_estado_superficie = EstadosSuperficies::where('id',$informe_dz->estado_superficie_id)->first();
        $informe_unidad_medicion_dureza = UnidadesMedicionDureza::where('id',$informe_dz->unidad_medicion_dureza_id)->first();
        $informe_solicitado_por = User::where('id',$informe->solicitado_por)->first();
        if ($informe_solicitado_por == null){
            $informe_solicitado_por = new User();
        }
        $informe_detalle = $this->getDetalle($informe_dz->id);
        $informe_modelos_3d = (new \App\Http\Controllers\InformeModelos3dController)->getInformeModelos3d($id);

        return view('informes.dz.edit', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'informe',
                                                 'informe_dz',
                                                 'informe_material',
                                                 'informe_material_accesorio',
                                                 'informe_procedimiento',
                                                 'informe_norma_evaluacion',
                                                 'informe_norma_ensayo',
                                                 'informe_ejecutor_ensayo',
                                                 'informe_modelos_3d',
                                                 'header_titulo',
                                                 'informe_interno_equipo',
                                                 'informe_estado_superficie',
                                                 'informe_detalle',
                                                 'informe_unidad_medicion_dureza',
                                                 'informe_ot_tipo_soldadura',
                                                 'informe_solicitado_por',
                                                 'header_descripcion'));
    }

    public function getDetalle($id){

        $informe_detalles = DB::table('detalles_dz')
                               ->leftjoin('detalles_dz_referencias','detalles_dz_referencias.id','=','detalles_dz.detalle_dz_referencia_id')
                               ->where('detalles_dz.informe_dz_id',$id)
                               ->selectRaw('detalles_dz.elemento as elemento,
                                          detalles_dz.diametro_espesor_id as diametro_espesor_id,
                                          detalles_dz.espesor_especifico as espesor_especifico,
                                          detalles_dz.diametro_especifico as diametro_especifico,
                                          detalles_dz.soldador_id as soldador_id,
                                          detalles_dz.material_base_izq as material_base_izq,
                                          detalles_dz.soldadura as soldadura,
                                          detalles_dz.material_base_der as material_base_der,
                                          detalles_dz_referencias.descripcion as observaciones,
                                          detalles_dz_referencias.path1 as path1,
                                          detalles_dz_referencias.path2 as path2,
                                          detalles_dz_referencias.path3 as path3,
                                          detalles_dz_referencias.path4 as path4')
                                ->orderBy('detalles_dz.id','asc')
                                ->get();

        $this->addObjectSoldador($informe_detalles);
        $this->addObjectDiametro($informe_detalles);
        $this->addObjectEspesor($informe_detalles);
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
            if ($item->diametro_especifico){
                $obj = new stdClass();
                $obj->diametro = $item->diametro_especifico;
                $item->diametro = $obj;
            }
            else{
                $obj = new stdClass();
                $diametro = DiametrosEspesor::find($item->diametro_espesor_id);
                $obj = $diametro ;
                $item->diametro = $obj;
            }
        }
     }
     public function addObjectEspesor($items){
        foreach ($items as $item) {
            if ($item->espesor_especifico){
                $obj = new stdClass();
                $obj->espesor = $item->espesor_especifico;
                $item->espesor = $obj;
            }
            else {
                $obj = new stdClass();
                $espesor = DiametrosEspesor::find($item->diametro_espesor_id);
                $obj = $espesor ;
                $item->espesor = $obj;
                }
        }
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeDzRequest $request, $id){

        $EsRevision = (new \App\Http\Controllers\InformesController)->EsRevision($id);

        if($EsRevision){

           return $this->store($request,$EsRevision);

        }

       $informe  = Informe::find($id);
       $informeDz =InformesDz::where('informe_id',$informe->id)->first();

       DB::beginTransaction();
       try {

           $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
           $this->saveInformeDz($request,$informe,$informeDz);
           DetallesDz::where('informe_dz_id',$informeDz->id)->delete();
           $this->saveDetalle($request,$informeDz);
           DB::commit();

         } catch (Exception $e) {

           DB::rollback();
           throw $e;

         }

         return $informe;

     }
     public function getMedicionDureza()
     {
         return UnidadesMedicionDureza::All();
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
