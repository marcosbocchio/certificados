<?php

namespace App\Repositories\Documentaciones;
use App\Repositories\BaseRepository;
use App\Documentaciones;
use App\UsuarioDocumentaciones;


class DocumentacionesRepository extends BaseRepository
{

  public function getModel()
  {
    return new Documentaciones;
  }

  public function store( $request)
  {

    $documento = $this->getModel();

    if ($request->tipo == 'U'){

      $fecha_caducidad =  date('Y-m-d',strtotime($request->fecha_caducidad));
      
      $documento->tipo = $request->tipo;
      $documento->titulo = $request->titulo;
      $documento->descripcion = $request->descripcion;
      $documento->path = $request->path;
      $documento->save();

      $usuarioDocumento = new UsuarioDocumentaciones;

      $usuarioDocumento->documentacion_id = $documento->id;
      $usuarioDocumento->user_id = $request->usuario_id;
      $usuarioDocumento->metodo_ensayo_id = $request->metodo_ensayo_id;
      $usuarioDocumento->fecha_caducidad = $fecha_caducidad;
      $usuarioDocumento->save();
    }
    else{

      $documento->tipo = $request->tipo;
      $documento->titulo = $request->titulo;
      $documento->descripcion = $request->descripcion;
      $documento->path = $request->path;
      $documento->save();


    }

  }

  public function delete($id){

   
    $documento = $this->getModel();    
    $usuarioDocumento = new UsuarioDocumentaciones;

    $usuarioDocumento->where('documentacion_id',$id);
    $usuarioDocumento->delete();

    
    $documento->find($id); 
    $documento->delete();


  }

}