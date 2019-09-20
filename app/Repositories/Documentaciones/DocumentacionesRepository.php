<?php

namespace App\Repositories\Documentaciones;
use App\Repositories\BaseRepository;
use App\Documentaciones;
use App\UsuarioDocumentaciones;
use Illuminate\Support\Facades\DB;



class DocumentacionesRepository extends BaseRepository
{

  public function getModel()
  {
    return new Documentaciones;
  } 

  public function store($request)
  {

    $documento = $this->getModel();
   

    DB::beginTransaction();
    try {  

          $documento =  $this->saveDocumento($documento,$request);
        
          if ($request->tipo == 'USUARIO'){

            $usuarioDocumento = new UsuarioDocumentaciones;
            $this->saveUsuarioDocumento($documento,$usuarioDocumento,$request);    
          }

    DB::commit();

  } catch (Exception $e) {

    DB::rollback();
    throw $e;      
    
  }

  }

  public function updateDocumentacion($request, $id){

    $documento = Documentaciones::find($id);   

    DB::beginTransaction();

    try {
     
     $documento = $this->saveDocumento($documento,$request);

     if ($request->tipo == 'USUARIO'){

       $usuarioDocumento = UsuarioDocumentaciones::where('documentacion_id',$documento->id)->first();
       $this->saveUsuarioDocumento($documento,$usuarioDocumento,$request);

    }
    DB::commit(); 
      } catch (Exception $e) {

        DB::rollback();
        throw $e;      
        
      }
 
    return $documento;
  }

  public function saveDocumento($documento,$request){

    
    $fecha_caducidad =  date('Y-m-d',strtotime($request->fecha_caducidad));            
    $documento->tipo = $request->tipo;
    $documento->titulo = $request->titulo;
    $documento->descripcion = $request->descripcion;
    $documento->metodo_ensayo_id = $request->metodo_ensayo['id'];
    $documento->path = $request->path;
    $documento->save();

    return $documento ;
  }

  public function saveUsuarioDocumento($documento,$usuarioDocumento,$request){

    $fecha_caducidad =  date('Y-m-d',strtotime($request->fecha_caducidad));
    $usuarioDocumento->documentacion_id = $documento->id;
    $usuarioDocumento->user_id = $request->usuario['id'];      
    $usuarioDocumento->fecha_caducidad = $fecha_caducidad;
    $usuarioDocumento->save();

  }

}