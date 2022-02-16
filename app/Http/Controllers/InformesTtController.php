<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\InformesTt;
use App\Informe;
use App\DetallesTt;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Http\Requests\InformeTtRequest;
use Illuminate\Support\Facades\DB;
use Exception as Exception;
use Illuminate\Support\Facades\Log;

class InformesTtController extends Controller
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

    public function show($id)
    {
        $informe = Informe::where('id', $id)
                            ->with('ot.cliente')
                            ->with('ot.contratista')
                            ->with('planta')
                            ->with('material')
                            ->with('material2')
                            ->with('otTipoSoldadura')
                            ->with('NormaEnsayo')
                            ->with('NormaEvaluacion')
                            ->with('internoEquipo.equipo')
                            ->with('informeTt.detalle')
                            ->with('solicitadoPor')
                            ->first();

        $ejecutor_ensayo =(new OtOperariosController())->getEjecutorEnsayo($informe->ejecutor_ensayo_id);
        $documetacionesRepository = new DocumentacionesRepository;
        $procedimiento = (new DocumentacionesController($documetacionesRepository))->ProcedimientoInformeId($informe->procedimiento_informe_id);
        $informe->ejecutor_ensayo = $ejecutor_ensayo;
        $informe->procedimiento = $procedimiento;
        return $informe;
    }

    public function create($ot_id)
    {
        $metodo = 'TT';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $editMode = false;
        $ot = Ots::findOrFail($ot_id);
        $informe_id = 0;
        return view('informes.tt.index', compact('ot',
                                                 'metodo',
                                                 'informe_id',
                                                 'user',
                                                 'header_titulo',
                                                 'header_descripcion',
                                                 'editMode'));
    }

    public function store(InformeTtRequest $request,$EsRevision = false)
    {
        $informe  = new Informe;
        $informeTt  = new InformesTt;

        DB::beginTransaction();
        try {

          $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe,$EsRevision);
          $informeTt = $this->saveInformeTt($request,$informe,$informeTt);
          $this->saveDetalle($request,$informeTt);
          DB::commit();

        } catch (Exception $e) {

          DB::rollback();
          throw $e;

        }

        return $informe;
      }

      public function saveInformeTt($request,$informe,$informeTt) {

        log::debug("iamgen blob: ". json_encode($request->imgData));
        $informeTt->informe_id = $informe->id;
        $informeTt->temperatura_inicial = $request->temperatura_inicial;
        $informeTt->temperatura_subida = $request->temperatura_subida;
        $informeTt->temperatura_mantenimiento = $request->temperatura_mantenimiento;
        $informeTt->temperatura_enfriado = $request->temperatura_enfriado;
        $informeTt->temperatura_final = $request->temperatura_final;
        $informeTt->imagen_temp = $request->imgData;
        $informeTt->save();

        return $informeTt;

      }

    public function saveDetalle($request,$informeTt) {

    foreach ($request->detalle as $item) {

        $detalleTt = new DetallesTt;
        $detalleTt->elemento = $item['elemento'];
        $detalleTt->termocupla = $item['termocupla'];
        $detalleTt->informe_tt_id =  $informeTt->id;
        $detalleTt->save();
    }
    }


    public function edit($ot_id,$id)
    {
        $metodo = 'TT';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Editar";
        $editMode = true;
        $ot = Ots::findOrFail($ot_id);
        $informe_id = $id;
        return view('informes.tt.index', compact('ot',
                                                 'informe_id',
                                                 'metodo',
                                                 'user',
                                                 'header_titulo',
                                                 'header_descripcion',
                                                 'editMode'));    }

    public function update(InformeTtRequest $request, $id)
    {
        $EsRevision = (new \App\Http\Controllers\InformesController)->EsRevision($id);

        if($EsRevision){

           return $this->store($request,$EsRevision);

        }

       $informe  = Informe::find($id);
       $informeTt =InformesTt::where('informe_id',$informe->id)->first();

       DB::beginTransaction();
       try {

           $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
           $this->saveInformeTt($request,$informe,$informeTt);
           DetallesTt::where('informe_tt_id',$informeTt->id)->delete();
           $this->saveDetalle($request,$informeTt);
           DB::commit();

         } catch (Exception $e) {

           DB::rollback();
           throw $e;

         }

         return $informe;
    }

    public function destroy($id)
    {
        //
    }
}
