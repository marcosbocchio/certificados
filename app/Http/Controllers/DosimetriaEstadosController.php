<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DosimetriaEstadosRequest;
use App\DosimetriaEstados;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\OperadorPeriodoRx;
use App\EstadosOperadorRx;
use \stdClass;

class DosimetriaEstadosController extends Controller
{

    public function __construct()
    {
  
          $this->middleware(['role_or_permission:Super Admin|D_estados']);  
    
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
        $header_titulo = "Dosimetria Estados";
        $header_descripcion ="Alta | Baja | Modificación";    
      
        $operador = auth()->user();
        return view('dosimetria.estados',compact('user','operador','header_titulo','header_descripcion'));

    }

    public function  getDosimetriaEstados($year,$month){

        $disometrias_estados = DB::select('CALL DosimetriaEstados(?,?)',array($year,$month));

        foreach ($disometrias_estados as $item) {

           $estado_operador_rx = EstadosOperadorRx::find($item->estado_id);
           $obj = new stdClass();
           $obj = $estado_operador_rx;
           $item->estado =  $obj;
            
        }
        
         return $disometrias_estados;
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
    public function store(DosimetriaEstadosRequest $request)
    {
      
        DB::beginTransaction();
        try
        {
            $this->deleteDosimetriaEstados($request);  
            $this->saveEstado($request);  
           
            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }    
         
    }


    public function deleteDosimetriaEstados($request){

        $periodo_year = date('Y',strtotime($request->year)); 
        $periodo_month = date('m',strtotime($request->month)); 

        $dosimetria_operador = DosimetriaEstados::whereRaw('YEAR(fecha) = ?',[$request->year])
                                                  ->whereRaw('MONTH(fecha) = ?',[$request->month])
                                                  ->delete();

    }

    public function saveEstado($request){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        foreach ($request->dosimetria_estados as $estado) {
            
            
            if(($estado['estado']) || $estado['fecha_envio']) {
                
                $fecha = $request->year . '-' . $request->month . '-1';
                $dosimetria_estado = new DosimetriaEstados;
                
                $dosimetria_estado->operador_id = $estado['operador_id'];
                $dosimetria_estado->fecha = $fecha;  
                if($estado['estado']){

                    $dosimetria_estado->estado_id = $estado['estado']['id']; 

                }
                $dosimetria_estado->fecha_envio = date('Y-m-d',strtotime($estado['fecha_envio']));
                $dosimetria_estado->user_id = $user_id;
                $dosimetria_estado->save();    

                if($estado['estado']['baja_sn']){

                    $baja = date('Y-m',strtotime($dosimetria_estado->fecha)) . -1;
                    $operadorPeriodoRx = OperadorPeriodoRx::where('operador_id',$estado['operador_id'])->orderBy('id','desc')->limit(1)->first();
                    $operadorPeriodoRx->baja = $baja;
                    $operadorPeriodoRx->save();

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
