<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InformeImportadosRequest;
use App\InformesImportados;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class InformesImportadosController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformeImportadosRequest $request)
    {
              
        $informe_importados  = new InformesImportados;  

        DB::beginTransaction();
        try {          
        
          $this->saveInformeImportados($request,$informe_importados);
       
          DB::commit(); 
    
        } catch (Exception $e) {
    
          DB::rollback();
          throw $e;      
          
        }
    }

    public function saveInformeImportados($request,$informe_importados){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $informe_importados->ot_id = $request->ot_id;
        $informe_importados->metodo_ensayo_id = $request->metodo_ensayo['id'];
        $informe_importados->fecha =date('Y-m-d',strtotime($request->fecha)); 
        $informe_importados->numero = $request->numero;
        $informe_importados->prefijo = $request->prefijo;
        $informe_importados->observaciones = $request->observaciones;
        $informe_importados->path = $request->path;
        $informe_importados->ejecutor_ensayo_id = $request->ejecutor_ensayo['id'];
        $informe_importados->user_id = $user_id;
        $informe_importados->save();
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
        
        return InformesImportados::where('id',$id)
                                  ->with('metodo_ensayo')
                                  ->with('ejecutorEnsayo')
                                  ->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeImportadosRequest $request, $id)
    {
                      
        $informe_importados =InformesImportados::find($id);

        DB::beginTransaction();
        try {          
        
          $this->saveInformeImportados($request,$informe_importados);
       
          DB::commit(); 
    
        } catch (Exception $e) {
    
          DB::rollback();
          throw $e;      
          
        }
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
