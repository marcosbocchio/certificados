<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\OtOperarios;

class OtOperariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $header_titulo = "Operadores OT";
        $header_descripcion ="Alta | Baja | Modificación";      
        $accion = 'edit';      
        $user = auth()->user()->name;

        
        //$ot_operarios = OtOperarios::where('ot_id',$id)->with('user')->get();   
        $users_ot_operarios = DB::table('users')
                                  ->join('ot_operarios','users.id','=','ot_operarios.user_id')
                                  ->join('ots','ot_operarios.ot_id','=','ots.id')  
                                  ->where('ots.id',$id)
                                  ->select('users.*')
                                  ->get();
 

        return view('ot-operarios.index',compact('id',
                                        'users_ot_operarios',                                   
                                        'user',                                       
                                        'header_titulo',
                                        'header_descripcion'));

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

     
        try
        {

                $ot_id = $request->ot_id;
                OtOperarios::where('ot_id',$ot_id)->delete();      

               foreach ( $request->operarios as $operario) {
                
                $ot_operarios                            = new OtOperarios;
                $ot_operarios->ot_id                     = $request->ot_id;
                $ot_operarios->user_id                   = $operario['id'];
                $ot_operarios->save();

            }  
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }     
   
      
      
    }

    public function users(){

        
        return User::whereNull('cliente_id')->get();

    }

    public function OtOperadoresTotal($ot_id){


        return OtOperarios::where('ot_id',$ot_id)->count(); 

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
