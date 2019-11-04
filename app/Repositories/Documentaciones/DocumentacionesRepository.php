<?php

namespace App\Repositories\Documentaciones;
use App\Repositories\BaseRepository;
use App\Documentaciones;
use App\UsuarioDocumentaciones;
use App\OtProcedimientosPropios;
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

          if ($request->tipo == 'PROCEDIMIENTO'){

            $ot_procedimieto_propio = new OtProcedimientosPropios;
            (new \App\Http\Controllers\OtProcedimientosPropiosController)->store($documento->id,$ot_procedimieto_propio,$request->ot_id);
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

    if ($request->tipo == 'PROCEDIMIENTO'){

      $ot_procedimieto_propio = OtProcedimientosPropios::where('documentacion_id',$documento->id)->first();
      (new \App\Http\Controllers\OtProcedimientosPropiosController)->store($documento->id,$ot_procedimieto_propio,$request->ot_id); 
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

    $fecha_caducidad = $request->fecha_caducidad ? date('Y-m-d',strtotime($request->fecha_caducidad)) : null;

    $usuarioDocumento->documentacion_id = $documento->id;
    $usuarioDocumento->user_id = $request->usuario['id'];      
    $usuarioDocumento->fecha_caducidad = $fecha_caducidad;
    $usuarioDocumento->save();

  }

  /*
  public function saveProcedimientoPropio($documento,$ot_procedimieto_propio,$request){
    

    $ot_procedimieto_propio->documentacion_id = $documento->id;
    $ot_procedimieto_propio->ot_id = $request->ot_id;   
    $ot_procedimieto_propio->save();

  }
*/
}