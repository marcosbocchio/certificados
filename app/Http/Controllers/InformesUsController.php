<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;

class InformesUsController extends Controller
{

    public function create($ot_id)
    {
        $metodo = 'US';    
        $user = auth()->user()->name;
        $header_titulo = "Informe";
        $header_descripcion ="Crear";         
        $ot = Ots::findOrFail($ot_id);      

        return view('informes.us.index', compact('ot',
                                                 'metodo',
                                                 'user',                                              
                                                 'header_titulo',
                                                 'header_descripcion'));
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
