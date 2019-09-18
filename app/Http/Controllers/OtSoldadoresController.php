<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ots;
use App\OtSoldadores;

class OtSoldadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $header_titulo = "Soldadores OT";
        $header_descripcion ="Alta | Baja | Modificación";      
        $accion = 'edit';      
        $user = auth()->user()->name;

        $ot_soldadores = $this->getSoldadoresOt($id);
        $ot = Ots::find($id);

        return view('ot-soldadores.index',compact('ot',
                                        'ot_soldadores',                                   
                                        'user',                                       
                                        'header_titulo',
                                        'header_descripcion'));
    }

    public function getSoldadoresOt($ot_id){

            return DB::table('soldadores')
                        ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')
                        ->where('ot_soldadores.ot_id',$ot_id)
                        ->select('soldadores.*')
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

                $ot = $request->ot;             
                $ot_soldadores = OtSoldadores::where('ot_id',$ot['id'])->get();

                foreach ($ot_soldadores as $ot_soldador) {
                  $existe = false;
                    foreach ($request->soldadores as $soldador) {

                        if( ($ot_soldador['soldadores_id'] == $soldador['id'])){
                          $existe = true;
                        }
                  
                    }

                  if (!$existe){
                    OtSoldadores::where('ot_id',$ot['id'])
                                 ->where('soldadores_id',$ot_soldador['soldadores_id'])
                                 ->delete();
                    }
                }
         
               foreach ($request->soldadores as $soldador) {

                    $ot_soldadores_update = OtSoldadores::firstOrCreate(
                        
                       ['ot_id' => $ot['id'],'soldadores_id' => $soldador['id']],
                       ['ot_id' => $ot['id'],'soldadores_id' => $soldador['id']]

                    );
       
                $ot_soldadores_update->save();

              
              } 
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }     
   
    }

    public function SoldadoresOt($ot_id){

        return DB::table('soldadores')
                   ->join('ot_soldadores','ot_soldadores.soldadores_id','=','soldadores.id')  
                   ->where('ot_soldadores.ot_id',$ot_id)
                   ->select('soldadores.*')
                   ->get();

    }

    public function OtSoldadoresTotal($ot_id){


        return OtSoldadores::where('ot_id',$ot_id)->count(); 

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
