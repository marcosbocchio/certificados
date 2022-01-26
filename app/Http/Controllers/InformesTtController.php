<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\InformesTt;
use App\Informe;
use App\DetallesTt;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $metodo = 'TT';
        $user = auth()->user();
        $header_titulo = "Informe";
        $header_descripcion ="Crear";
        $editMode = false;
        $ot = Ots::findOrFail($ot_id);
        return view('informes.tt.index', compact('ot',
                                                 'metodo',
                                                 'user',
                                                 'header_titulo',
                                                 'header_descripcion',
                                                 'editMode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$EsRevision = false)
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

        $informeTt->informe_id = $informe->id;
        $informeTt->temperatura_inicial = $request->temperatura_inicial;
        $informeTt->temperatura_subida = $request->temperatura_subida;
        $informeTt->temperatura_mantenimiento = $request->temperatura_mantenimiento;
        $informeTt->temperatura_enfriado = $request->temperatura_enfriado;
        $informeTt->temperatura_final = $request->temperatura_final;
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



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        //
    }
}
