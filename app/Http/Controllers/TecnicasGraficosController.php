<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TecnicasGraficos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

class TecnicasGraficosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
       return $Tecnica_graficos = TecnicasGraficos::where('tecnica_id',$id)->get();
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
        $tecnica = DB::table('tecnicas')
                    ->join('tecnicas_graficos','tecnicas_graficos.tecnica_id','=','tecnicas.id')
                    ->where('tecnicas_graficos.id',$id)
                    ->select('tecnicas.*','tecnicas_graficos.path','tecnicas_graficos.id as grafico_id')
                    ->first();
        $tecnica->path = '/'.$tecnica->path;
        return  $tecnica = Collection::make($tecnica); 

     
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
