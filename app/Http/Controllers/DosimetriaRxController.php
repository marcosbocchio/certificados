<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DosimetriaRxRequest;
use App\DosimetriaRx;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DosimetriaRxController extends Controller
{
    public function __construct()
    {
  
          $this->middleware(['role_or_permission:Sistemas|D_rx'],['only' => ['callView']]);  
    
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
        $header_titulo = "Dosimetria Rx";
        $header_descripcion ="Alta | Baja | Modificación";    
      
        $operador = auth()->user();
        return view('dosimetria.dosimetria_rx',compact('user','operador','header_titulo','header_descripcion'));

    }

    public function  getDosimetriaRx($year,$month){

        $disometrias = DB::select('CALL Dosimetria_rx(?,?)',array($year,$month));
        
         return $disometrias;
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
    public function store(DosimetriaRxRequest $request)
    {
        DB::beginTransaction();
        try
        {
        
            $this->deleteDosimetriaRx($request);  
            $this->saveDosimetriaRx($request);  
            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }     

    }


    public function deleteDosimetriaRx($request){

        $periodo_year = date('Y',strtotime($request->periodo)); 
        $periodo_month = date('m',strtotime($request->periodo)); 

        $dosimetria_operador = DosimetriaRx::whereRaw('YEAR(fecha) = ?',[$request->year])
                                            ->whereRaw('MONTH(fecha) = ?',[$request->month])
                                            ->delete();

    }

    public function saveDosimetriaRx($request){


        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        foreach ($request->dosimetria_rx as $dosimetria) {

            if($dosimetria['milisievert']) {

                $fecha = $request->year . '-' . $request->month . '-1';
              
                $dosimetria_operador = new DosimetriaRx;
                $dosimetria_operador->fecha = $fecha;
                $dosimetria_operador->operador_id = $dosimetria['operador_id'];
                $dosimetria_operador->user_id = $user_id;
                $dosimetria_operador->milisievert = $dosimetria['milisievert'];
                $dosimetria_operador->periodo =date('Y-m-d',strtotime($dosimetria['periodo'])); 
                $dosimetria_operador->save();

            }

        }

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
