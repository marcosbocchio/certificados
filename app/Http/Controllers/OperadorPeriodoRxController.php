<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OperadorPeriodoRx;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OperadorPeriodoRxController extends Controller
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

    public function callView()
    {      

        $user = auth()->user(); 
        $header_titulo = "Activación Operador";
        $header_descripcion ="";    
      
        $operador = auth()->user();
        return view('dosimetria.operador_periodo_rx',compact('user','operador','header_titulo','header_descripcion'));

    }

    public function getOperadorPeriodos($id){

        return OperadorPeriodoRx::where('operador_id',$id)
                                  ->orderBy('alta','asc')
                                  ->SelectRaw('CONCAT(MONTH(alta),"-",YEAR(alta)) as alta,CONCAT(MONTH(baja),"-",YEAR(baja)) as baja,id,operador_id,user_id')
                                  ->get();
     
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
       
        DB::beginTransaction();
        try
        {           
            $this->savePeriodo($request);  
           
            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }  
    
    }

    public function savePeriodo($request){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        $operador_periodo = new OperadorPeriodoRx;
        $operador_periodo->operador_id = $request->operador['id'];
        $operador_periodo->alta = date('Y-m-d',strtotime($request->fecha));
        $operador_periodo->user_id = $user_id;
        $operador_periodo->save();

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
