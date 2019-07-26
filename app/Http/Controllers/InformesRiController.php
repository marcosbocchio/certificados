<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\Repositories\InformesRi\InformesRiRepository;
use App\Http\Requests\InformeRiRequest;

class InformesRiController extends Controller
{
    Protected $informesRi;

    public function __construct(InformesRiRepository $informesRiRepository)
    {
      $this->informesRi = $informesRiRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $metodo = 'RI';
      //  $editmode = false;      
        $user = auth()->user()->name;
        $header_titulo = "Informe ";
        $header_descripcion ="RI";  

        $ot = Ots::findOrFail($ot_id);      

        return view('informes.ri.index', compact('ot',
                                                 'metodo',
                                                 'user',                                              
                                                 'header_titulo',
                                                 'header_descripcion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformeRiRequest $request)
    {
        return $this->informesRi->store($request);
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
