<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServicioStoreRequest;
use App\Http\Requests\ServicioUpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Servicios;
use App\User;

class ServiciosController extends Controller
{
    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|M_servicios'],['only' => ['callView']]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Servicios::with('metodoEnsayos')
                           ->with('unidadMedidas')
                           ->orderBy('abreviatura','ASC')
                           ->get();
    }

    public function paginate(Request $request){

        $filtro = $request->search;
        return  Servicios::with('metodoEnsayos')
                            ->with('unidadMedidas')
                            ->Filtro($filtro)
                            ->orderBy('abreviatura','ASC')
                            ->paginate(10);
    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Servicios";
        $header_descripcion ="Alta | Baja | Modificación";
        return view('servicios',compact('user','header_titulo','header_descripcion'));

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
    public function store(ServicioStoreRequest $request)
    {
        $servicio = new Servicios;

        DB::beginTransaction();
        try {

            $this->saveServicio($request,$servicio);
            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

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
    public function update(ServicioUpdateRequest $request, $id)
    {

        $servicio = Servicios::find($id);

        DB::beginTransaction();
        try {
            $this->saveServicio($request,$servicio);
            DB::commit();

          } catch (Exception $e) {

            DB::rollback();
            throw $e;

          }
    }

    public function saveServicio($request,$servicio){

        $servicio->descripcion = $request['descripcion'];
        $servicio->unidades_medida_id = $request['unidad_medida']['id'];
        $servicio->metodo_ensayo_id = $request['metodo_ensayo']['id'];
        $servicio->abreviatura = strtoupper($request['abreviatura']);
        $servicio->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicio = Servicios::find($id);
        $servicio->delete();
    }
}
