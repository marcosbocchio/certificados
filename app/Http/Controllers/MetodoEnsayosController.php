<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\Repositories\MetodoEnsayos\MetodoEnsayosRepository;
use App\MetodoEnsayos;
use App\User;

class MetodoEnsayosController extends Controller
{

    Protected $metodoEnsayo;

    public function __construct(MetodoEnsayosRepository $metodoEnsayosRepository)
    {
      $this->metodoEnsayo = $metodoEnsayosRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  $this->metodoEnsayo->getAll();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function otMetodosEnsayo($id){

        $metodo_ensayos = DB::select('select metodo_ensayos.metodo from 

                                            servicios 
                                            inner join ot_servicios on
                                            ot_servicios.servicio_id = servicios.id
                                            inner join metodo_ensayos on
                                            metodo_ensayos.id = servicios.metodo_ensayo_id
                                            inner join ots on
                                            ots.id = ot_servicios.ot_id
                                            where
                                            ots.id = :id
                                            
                                            group by 
                                            metodo_ensayos.metodo',['id' => $id ]);

        $metodo_ensayos = Collection::make($metodo_ensayos);

        return $metodo_ensayos;
    } 


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
        //
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
