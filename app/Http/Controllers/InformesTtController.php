<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\InformesTt;
use Exception as Exception;
use Illuminate\Support\Facades\Log;

class InformesTtController extends Controller
{
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
