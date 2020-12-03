<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ots;
use App\OtSoldadores;
use App\Soldadores;
use App\OtUsuariosClientes;
use Illuminate\Support\Facades\Log;

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
        $user = auth()->user();

        $ot_soldadores = $this->getSoldadoresOt($id);
        $ot_usuarios_cliente = $this->getUsuariosCliente($id);
        $ot = Ots::find($id);

        return view('ot-soldadores.index',compact('ot',
                                        'ot_soldadores',
                                        'ot_usuarios_cliente',
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

    public function getUsuariosCliente($ot_id){

        return DB::table('users')
                    ->join('ot_usuarios_clientes','ot_usuarios_clientes.user_id','=','users.id')
                    ->where('ot_usuarios_clientes.ot_id',$ot_id)
                    ->select('users.*')
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
               // Usuarios Cliente

                $ot_usuarios_cliente = OtUsuariosClientes::where('ot_id',$ot['id'])->get();

                foreach ($ot_usuarios_cliente as $ot_usuario_cliente) {
                    $existe = false;
                      foreach ($request->usuarios_cliente as $usuario_cliente) {

                          if( ($ot_usuario_cliente['user_id'] == $usuario_cliente['id'])){
                            $existe = true;
                          }

                      }

                    if (!$existe){
                        OtUsuariosClientes::where('ot_id',$ot['id'])
                                   ->where('user_id',$ot_usuario_cliente['user_id'])
                                   ->delete();
                      }
                  }

                  foreach ($request->usuarios_cliente as $usuario_cliente) {

                      $ot_usuarios_cliente_update = OtUsuariosClientes::firstOrCreate(

                         ['ot_id' => $ot['id'],'user_id' => $usuario_cliente['id']],
                         ['ot_id' => $ot['id'],'user_id' => $usuario_cliente['id']]

                      );

                  $ot_usuarios_cliente_update->save();

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
                   ->select('soldadores.codigo','soldadores.nombre','ot_soldadores.*')
                   ->get();

    }

    public function OtSoldadoresTotal($ot_id){


        return OtSoldadores::where('ot_id',$ot_id)->count();

    }

    public function ImportarSoldadores(Request $request,$ot_id,$cliente_id){


        DB::beginTransaction();

        try {

            $soldadores_importados = $request->input('soldadores_importados');

            foreach ($soldadores_importados as $codigo_soldador) {

                Log::debug("Var request ImportarSoldadores :" . $codigo_soldador);

                if($codigo_soldador){

                        $soldador = Soldadores::firstOrCreate(

                            ['codigo' => $codigo_soldador,'cliente_id' => $cliente_id],['codigo' => $codigo_soldador,'cliente_id' => $cliente_id,'nombre'  =>'nn']
                        );

                    /*    Log::debug("Este es el soldador de la importacion :" . $soldador);

                        $soldador = Soldadores::where('cliente_id',$cliente_id)
                                                ->where('codigo',$codigo_soldador)
                                                ->first();
                    */
                        $soldador_id = $soldador->id;

                        $ot_soldador = OtSoldadores::firstOrCreate(

                            ['ot_id' => $ot_id,'soldadores_id' => $soldador_id],['ot_id' => $ot_id,'soldadores_id' => $soldador_id]
                        );
                 }
            }

            DB::commit();

       } catch (Exception $e) {

            DB::rollback();
            throw $e;

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
