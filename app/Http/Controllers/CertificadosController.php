<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpers;
use App\Ots;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Certificados;
class CertificadosController extends Controller
{

    public function __construct()
    {
  
        $this->middleware(['role_or_permission:Super Admin|T_certif_acceder'],['only' => ['index']]);  
        $this->middleware(['role_or_permission:Super Admin|T_certif_edita'],['only' => ['create','store','update','edit']]);  
    
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ot_id)
    {
        $user = auth()->user();
        $header_titulo = "Certificados";
        $header_descripcion ="Crear";         
        $ot = Ots::findOrFail($ot_id);      

        return view('certificados.index', compact('ot',                                            
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

    public function GenerarNumeroCertificado(){

        return DB::table('certificados')                  
                    ->orderBy('certificados.numero', 'DESC')   
                    ->limit(1) 
                    ->selectRaw('certificados.numero + 1 as numero_certificado')                    
                    ->get();  

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
