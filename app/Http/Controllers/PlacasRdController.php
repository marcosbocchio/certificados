<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlacaRequest;
use App\Informe;
use App\InformesRd;
use App\PlacasRd;
use Illuminate\Support\Facades\DB;

class PlacasRdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($informe_id)
    {
        $header_titulo = "Placas Informes";
        $header_descripcion ="Alta | Baja | Modificación";
        $accion = 'edit';
        $user = auth()->user();
        $informe = informe::findOrFail($informe_id);
        $placas_informe = $this->PlacasInforme($informe_id);


        return view('informe-placas.index',compact('informe_id',
                                                    'user',
                                                    'header_titulo',
                                                    'header_descripcion'));
    }

    public function PlacasInforme($informe_id){

        $placas = DB::table('placas_rd')
                    ->join('informes_rd','informes_rd.id','=','placas_rd.informe_rd_id')
                    ->join('informes','informes.id','=','informes_rd.informe_id')
                    ->where('informes.id',$informe_id)
                    ->select('placas_rd.*')
                    ->get();


        return $placas;


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


    public function store(PlacaRequest $request)

    {
        DB::beginTransaction();
        try {

            $informe_rd = InformesRd::where('informe_id',$request->informe_id)->first();
            $placa = new PlacasRd();
            $this->savePlacas($placa,$informe_rd,$request);
            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

            }

    }

    public function savePlacas($placa,$informe_rd,$request){

        $placa->informe_rd_id = $informe_rd->id;
        $placa->descripcion = $request->descripcion;
        $placa->path = $request->path;
        $placa->save();

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlacaRequest $request, $id)
    {
        DB::beginTransaction();
        try {

        $informe_rd = InformesRd::where('informe_id',$request->informe_id)->first();
        $placa = PlacasRd::findORfail($id);
        $this->savePlacas($placa,$informe_rd,$request);
        DB::commit();


    } catch (Exception $e) {

        DB::rollback();
        throw $e;

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $placas = PlacasRd::find($id);

        $placas->delete();
    }
}
