<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SoldadorRequest;
use Illuminate\Support\Facades\DB;
use App\Soldadores;
use App\Clientes;

class SoldadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->name;      
        $header_titulo = "Soldadores ";
        $header_descripcion ="Alta | Baja | Modificación";        
     
        return view('soldadores',compact('user','header_titulo','header_descripcion'));
       
    }

    public function SoldadoresCliente($id){

        return Soldadores::where('cliente_id',$id)->get();

    }

    public function paginate(Request $request,$id){

        return Soldadores::where('cliente_id',$id)->orderBy('id','DESC')->paginate(10);
    }

    public function callView($cliente_id)
    {   
        $user = auth()->user()->name; 
        $cliente = Clientes::findOrFail($cliente_id);
        $header_titulo = "Soldadores del Cliente ". $cliente->nombre_fantasia;
        $header_descripcion ="Alta | Baja | Modificación";          
        $modelo = 'soldadores/cliente/'.$cliente_id;
        return view('soldadores-cliente',compact('user','header_titulo','header_descripcion','modelo'));

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
    public function store(SoldadorRequest $request)
    {
        $soldador = new Soldadores;   

        DB::beginTransaction();
        try { 

            $soldador->cliente_id = $request['cliente_id'];
            $this->saveSoldador($request,$soldador);
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
    public function update(SoldadorRequest $request, $id)
    {
        $soldador = Soldadores::find($id);     
    
        DB::beginTransaction();
        try {
            $this->saveSoldador($request,$soldador);
            DB::commit(); 
    
          } catch (Exception $e) {
      
            DB::rollback();
            throw $e;      
            
          }
    }

    public function saveSoldador($request,$soldador){
        
        $soldador->codigo = $request['codigo'];
        $soldador->nombre = $request['nombre'];
        $soldador->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $soldador = Soldadores::find($id);
        $soldador->delete();
    }
}
