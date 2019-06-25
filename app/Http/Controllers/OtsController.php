<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Ots\OtsRepository;
use Illuminate\Support\Collection as Collection;
use App\Ots;
use App\Clientes;
use Illuminate\Support\Facades\DB;
use App\OtServicios;
use App\User;

class OtsController extends Controller
{
    Protected $ot;

    public function __construct(OtsRepository $otRepository)
    {
      $this->ot = $otRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accion = 'create';      
        $user = auth()->user()->name;
        $ot = new Ots(); 
        $cliente = new Clientes();
        $ot_servicios = new OtServicios();
        return view('ots.index', compact('user','ot','cliente','ot_servicios','accion'));
        
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
    public function store(Request $request)
    {
        return $request;
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
        $accion = 'edit';      
        $user = auth()->user()->name;
        $ot = $this->ot->find($id);
        $cliente = Clientes::find($ot->cliente_id);
        
      
        $ot_servicios = DB::select('select 
                                    servicios.descripcion as servicio,
                                    norma_ensayos.descripcion as norma_ensayo,
                                    norma_evaluaciones.descripcion as norma_evaluacion,
                                    ot_servicios.cantidad as cantidad_servicios,
                                    ot_servicios.cant_max_placas as cantidad_placas
                                    
                                    from ot_servicios
                                    inner join servicios on 
                                    servicios.id = ot_servicios.servicio_id
                                    inner join norma_ensayos on
                                    norma_ensayos.id = ot_servicios.norma_ensayo_id
                                    inner join norma_evaluaciones on
                                    norma_evaluaciones.id = ot_servicios.norma_evaluacion_id
                                    inner join ots on
                                    ot_servicios.ot_id=ots.id and
                                    ots.id=:id',['id' => $ot->id ]);
      
        $ot_servicios = Collection::make($ot_servicios);      
        return view('ots.index',compact('ot','cliente','user','ot_servicios','accion'));
    }

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
