<?php

namespace App\Repositories\Clientes;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Clientes;
use App\Contactos;

class ClientesRepository extends BaseRepository
{

  public function getModel()
  {
    return new Clientes;
  }

  public function store($request){


    $cliente = $this->getModel();  
    
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

  public function updateCliente($request,$id){

    $cliente = Clientes::find($id);     
   // $X = 1 / 0;
  
    DB::beginTransaction();
    try {
        $this->saveCliente($request,$cliente);       
        $this->updateContacto($request,$cliente);
        DB::commit(); 

      } catch (Exception $e) {
  
        DB::rollback();
        throw $e;      
        
      }

      // test //
      $contactos = Contactos::where('cliente_id',$cliente->id)->get();
      return $contactos;
      foreach ($contactos as $contacto) {

        return $contacto;
      break;
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

           // if (!$existe){
              Contactos::where('id',$contacto['id'])                     
                        ->delete();
           //   }
          }

          foreach ($request->contactos as $contacto_request) {

              $contacto_request_new = Contactos::firstOrCreate(
                  
                  ['cliente_id' => $cliente['id'],'nombre' => $contacto_request['nombre'],'cargo' => $contacto_request['cargo'],'tel' => $contacto_request['tel'],'email' => $contacto_request['email']],
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

}