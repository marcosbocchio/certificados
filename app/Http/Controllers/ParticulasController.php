<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Particulas;
use App\MetodosTrabajoPm;
class ParticulasController extends Controller
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

    public function getParticulasMetodoTrabajoPm($metodo_trabajo_pm_id){

        $metodo_trabajo = MetodosTrabajoPm::find($metodo_trabajo_pm_id);

        $q='';

        switch ($metodo_trabajo->codigo) {

            case 'Húmedo-Visible':
                $q = $q . 'humeda_visible = 1';
                break;

            case 'Húmedo-Fluorescente':
                $q = $q . 'humeda_fluorescente = 1';
                break;

            case 'Seco-Visible':
                $q = $q . 'seca_visible = 1';
                break;
    
            case 'Seco- Fluorescente':
                $q = $q . 'seca_fluorescente = 1';
            break;        
            }

        $particulas = Particulas::whereRaw($q)
                                ->with('color')
                                ->get();


        return  $particulas;
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
