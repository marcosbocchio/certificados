<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DosimetriaOperador;

class DosimetriaOperadorController extends Controller
{
    public function __construct()
    {
  
          $this->middleware(['role_or_permission:Super Admin|D_operador'],['only' => ['callView']]);  
    
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
          $header_titulo = "Dosimetria Operador";
          $header_descripcion ="Alta | Baja | Modificación";    
        
          $operador = auth()->user();
          return view('dosimetria.dosimetria_operador',compact('user','operador','header_titulo','header_descripcion'));
  
      }

    public function  getDosimetriaOperador($operador_id,$year,$month){        

        $disometrias = DosimetriaOperador::whereRaw('YEAR(fecha) = ?',[$year])
                                        ->whereRaw('MONTH(fecha) = ?',[$month])
                                        ->where('operador_id',$operador_id)
                                        ->selectRaw('id,DAY(fecha) as day,microsievert, observaciones,created_at')
                                        ->orderBy('day','ASC')
                                        ->get();
    
         $dias = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
    
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
    public function store(Request $request)
    {

        DB::beginTransaction();
        try
        {
        
          //  $this->deleteDosimetriaOperador($request);  
            $this->saveDosimetriaOperador($request);  
            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }     

    }

    public function getDosimetriaOperadores(){
        
        return User::whereNull('cliente_id')
                   ->whereNotNull('film')
                   ->get();
    }

    public function deleteDosimetriaOperador($request){


        $dosimetria_operador = DosimetriaOperador::whereRaw('YEAR(fecha) = ?',[$request->year])
                                ->whereRaw('MONTH(fecha) = ?',[$request->month])
                                ->where('operador_id',$request->operador['id'])
                                ->delete();

    }

    public function saveDosimetriaOperador($request){


        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        foreach ($request->dosimetria_operadores as $dosimetria) {

            $fecha = $request->year . '-' . $request->month . '-' . $dosimetria['day'];
            $item = DosimetriaOperador::where('id',$dosimetria['id'])
                                        ->first();
            
            if(!$item){
        
                if($dosimetria['microsievert']) {

                    $dosimetria_operador = new DosimetriaOperador;
                    $dosimetria_operador->fecha = $fecha;
                    $dosimetria_operador->operador_id = $request->operador['id'];
                    $dosimetria_operador->user_id = $user_id;
                    $dosimetria_operador->microsievert = $dosimetria['microsievert'];
                    $dosimetria_operador->observaciones = $dosimetria['observaciones'];
                    $dosimetria_operador->save();

                }

            }else{

                if($dosimetria['microsievert']){

                    $item->microsievert = $dosimetria['microsievert'];
                    $item->observaciones = $dosimetria['observaciones'];
                    $item->user_id = $user_id;
                    $item->save();

                }else{

                    $item->delete();
                }

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
