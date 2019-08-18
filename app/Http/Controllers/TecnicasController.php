<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tecnicas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

class TecnicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  return Tecnicas::with(['Graficos'])->get();

      $tecnicas = DB::select(' select
                                tecnicas.id,
                                tecnicas.codigo,
                                tecnicas.descripcion,
                                CONCAT("/",path) as path,                                
                                tecnicas_graficos.id as grafico_id
                                
                                from tecnicas
                                inner join tecnicas_graficos on
                                tecnicas.id = tecnicas_graficos.tecnica_id');

     $tecnicas = Collection::make($tecnicas);                                
     return $tecnicas;
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
