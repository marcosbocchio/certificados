<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use App\Repositories\Clientes\ClientesRepository;
use App\Clientes;
use Illuminate\Support\Facades\DB;
use App\Contactos;
use App\User;
use App\Provincias;


class ClientesController extends Controller
{

    Protected $clientes;

    public function __construct(ClientesRepository $clientesRepository)
    {

     $this->middleware(['role_or_permission:Super Admin|M_clientes']);  
      $this->clientes = $clientesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  Clientes::with('contactos')->with('localidad')->get();
        foreach ($clientes as $cliente) {

            $provincia = Provincias::find($cliente->localidad['provincia_id']);
            $cliente->provincia = $provincia;
        }

        return $clientes;
    }

    public function paginate(Request $request){

        $clientes =  Clientes::with('contactos')->with('localidad')->orderBy('id','DESC')->paginate(10);
        foreach ($clientes as $cliente) {

            $provincia = Provincias::find($cliente->localidad['provincia_id']);
            $cliente->provincia = $provincia;
        }

        return $clientes;

    }

    public function callView()
    {   
        $user = auth()->user();
        $header_titulo = "Clientes";
        $header_descripcion ="Alta | Baja | Modificación";      
        return view('clientes',compact('user','header_titulo','header_descripcion'));

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
    public function store(ClienteRequest $request)
    {  
        $this->clientes->store($request) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Clientes::find($id);
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
    public function update(ClienteRequest $request, $id)
    {      
        $this->clientes->updateCliente($request,$id) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        DB::beginTransaction();
         try { 

                Contactos::where('cliente_id',$id)->delete();
                $cliente = Clientes::find($id);    
                $cliente->delete();
                DB::commit(); 

            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
    }
}
