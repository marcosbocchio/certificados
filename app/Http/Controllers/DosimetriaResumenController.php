<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class DosimetriaResumenController extends Controller
{
    public function __construct()
    {
  
        $this->middleware(['role_or_permission:Super Admin|D_resumen']);  
    
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

    public function callView()
    {   
        $user = auth()->user(); 
        $header_titulo = "Dosimetria Resumen";
        $header_descripcion ="Resumen Anual";    
      
        $operador = auth()->user();
        return view('dosimetria.resumen',compact('user','operador','header_titulo','header_descripcion'));

    }

    public function getResumen($year){

        
        $list_of_ids = '0';
        $resumen = DB::select('CALL DosimetriaResumen(?,?)',array($year,$list_of_ids));   
        return $resumen;

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
