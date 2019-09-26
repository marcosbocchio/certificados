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
        $this->saveContacto($request['contacto1'],$cliente);
        $this->saveContacto($request['contacto2'],$cliente);
        $this->saveContacto($request['contacto3'],$cliente);

        DB::commit(); 

      } catch (Exception $e) {
  
        DB::rollback();
        throw $e;      
        
      }
   

  }

  public function updateCliente($request,$id){

    $cliente = Clientes::find($id);     
    
    DB::beginTransaction();
    try {
        $this->saveCliente($request,$cliente);       
        $this->updateContacto($request['contacto1'],$cliente);
        $this->updateContacto($request['contacto2'],$cliente);
        $this->updateContacto($request['contacto3'],$cliente);
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
  $cliente->save();

  }


  public function updateContacto($contacto_request,$cliente){   

    if(isset($contacto_request['id'])) {

        $contacto = Contactos::find($contacto_request['id']);

        if($contacto_request['nombre'] == ''){

          $contacto->delete();

        }else{
      
        $contacto->nombre = $contacto_request['nombre'];
        $contacto->cargo = $contacto_request['cargo'];
        $contacto->tel = $contacto_request['tel'];
        $contacto->email = $contacto_request['email'];
        $contacto->save();
      }

    }else {
        $this->saveContacto($contacto_request,$cliente);
    }  

  }

  
  public function saveContacto($contacto_request,$cliente){
   

    if ($contacto_request['nombre'] != ''){
  
          $contacto = new Contactos;
          $contacto->cliente_id = $cliente->id;
          $contacto->nombre = $contacto_request['nombre'];
          $contacto->cargo = $contacto_request['cargo'];
          $contacto->tel = $contacto_request['tel'];
          $contacto->email = $contacto_request['email'];
          $contacto->save();
      }
    
    } 
}