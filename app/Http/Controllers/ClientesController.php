<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use Illuminate\Support\Collection as Collection;
use App\Clientes;
use Illuminate\Support\Facades\DB;
use App\Contactos;
use App\User;
use App\Provincias;


class ClientesController extends Controller
{   

    public function __construct()
    {

     $this->middleware(['role_or_permission:Super Admin|M_clientes'],['only' => ['callView']]);    
     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  Clientes::with('contactos')->with('localidad')->orderBy('nombre_fantasia','ASC')->get();
        foreach ($clientes as $cliente) {

            $provincia = Provincias::find($cliente->localidad['provincia_id']);
            $cliente->provincia = $provincia;
        }

        return $clientes;
    }

    public function paginate(Request $request){

        $filtro = $request->search;
        $clientes =  Clientes:: with('contactos')
                               ->with('localidad.provincia')                                
                                ->Filtro($filtro)
                                ->orderBy('id','DESC')
                                ->paginate(10);        

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
        $cliente = new Clientes;  
    
        DB::beginTransaction();
        try { 
    
            $this->saveCliente($request,$cliente);
            $this->updateContacto($request,$cliente);     
    
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
        $cliente = Clientes::find($id);   
  
          
         DB::beginTransaction();
         try {
             $this->saveCliente($request,$cliente);       
             $this->updateContacto($request,$cliente);
             DB::commit(); 
     
           } catch (Exception $e) {
       
             DB::rollback();
             throw $e;      
             
           }
        }
        

    public function saveCliente($request,$cliente){

        $cliente->codigo = $request['codigo'];
        $cliente->nombre_fantasia = $request['nombre'];
        $cliente->razon_social = $request['razon_social'];
        $cliente->tel = $request['tel'];
        $cliente->email = $request['email'];
        $cliente->direccion  =$request['direccion'];
        $cliente->cp = $request['cp'];
        $cliente->localidad_id = $request['localidad']['id'];
        $cliente->path = $request['path'];
        $cliente->save();
      
        }
      
      
        public function updateContacto($request,$cliente){ 
          
            
          $contactos = Contactos::where('cliente_id',$cliente->id)->get();
            
         
            DB::beginTransaction();
            try
            {
              
                foreach ($contactos as $contacto) {
                  $existe = false;
                  foreach ($request->contactos as $contacto_request) {
      
                     if(isset($contacto_request['id'])){
      
                          if( ($contacto['id'] == $contacto_request['id'])){
      
                            $existe = true;
                            
                          }
                      }
                    }
      
                  if (!$existe){
                    Contactos::where('id',$contacto['id'])                     
                              ->delete();
                    }
                }
      
                foreach ($request->contactos as $contacto_request) {
      
                    $contacto_request_new = Contactos::updateOrCreate(
                        
                        ['nombre' => $contacto_request['nombre']],
                        ['cliente_id' => $cliente['id'],'nombre' => $contacto_request['nombre'],'cargo' => $contacto_request['cargo'],'tel' => $contacto_request['tel'],'email' => $contacto_request['email']]
      
                    );
      
                $contacto_request_new->save();
          
                 } 
      
          DB::commit();
          }catch(\Exception $e)
          {
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

    /* Esta funcion devuelve el cliente de un usuario, si es usuario Enod devuelve todos los clientes */
    public function getClientesOperador($user_id){

      $user = User::findOrfail($user_id);

      if ($user->cliente_id){

        return Clientes::where('id',$user->cliente_id)->get();      
       
      }else{

        return Clientes::all();
        
      }

    }
}
