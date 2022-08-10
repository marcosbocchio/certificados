<?php

namespace App\Repositories\Documentaciones;
use App\Repositories\BaseRepository;
use App\Documentaciones;
use App\UsuarioDocumentaciones;
use App\OtProcedimientosPropios;
use Illuminate\Support\Facades\DB;
use App\InternoEquipoDocumentaciones;
use App\InternoFuenteDocumentaciones;
use App\VehiculoDocumentaciones;
use Illuminate\Support\Facades\Log;

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

            $usuario_documento = new UsuarioDocumentaciones;
            $this->saveUsuarioDocumento($documento,$usuario_documento,$request);
          }

          if ($request->tipo == 'PROCEDIMIENTO'){

            $ot_procedimieto_propio = new OtProcedimientosPropios;
            (new \App\Http\Controllers\OtProcedimientosPropiosController)->store($documento->id,$ot_procedimieto_propio,$request->ot['id']);
          }

          if ($request->tipo == 'EQUIPO'){

            $equipo_documento = new InternoEquipoDocumentaciones;
            $this->saveEquipoDocumento($documento,$equipo_documento,$request);
          }

          if ($request->tipo == 'FUENTE'){

            $fuente_documento = new InternoFuenteDocumentaciones;
            $this->saveFuenteDocumento($documento,$fuente_documento,$request);
          }

          if ($request->tipo == 'VEHICULO'){

            $vehiculo_documento = new VehiculoDocumentaciones;
            $this->saveVehiculoDocumento($documento,$vehiculo_documento,$request);
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

            $usuario_documento = UsuarioDocumentaciones::where('documentacion_id',$documento->id)->first();
            $usuario_documento = $usuario_documento ? $usuario_documento : new UsuarioDocumentaciones;
            $this->saveUsuarioDocumento($documento,$usuario_documento,$request);

          }

          if ($request->tipo == 'PROCEDIMIENTO'){

            $ot_procedimieto_propio = OtProcedimientosPropios::where('documentacion_id',$documento->id)->first();
            (new \App\Http\Controllers\OtProcedimientosPropiosController)->store($documento->id,$ot_procedimieto_propio,$request->ot['id']);
          }

          if ($request->tipo == 'EQUIPO'){

            $equipo_documento = InternoEquipoDocumentaciones::where('documentacion_id',$documento->id)->first();
            $this->saveEquipoDocumento($documento,$equipo_documento,$request);
          }

          if ($request->tipo == 'FUENTE'){

            $fuente_documento = InternoFuenteDocumentaciones::where('documentacion_id',$documento->id)->first();
            $this->saveFuenteDocumento($documento,$fuente_documento,$request);
          }

          if ($request->tipo == 'VEHICULO'){

            $vehiculo_documento = VehiculoDocumentaciones::where('documentacion_id',$documento->id)->first();
            $this->saveVehiculoDocumento($documento,$vehiculo_documento,$request);

          }


    DB::commit();
      } catch (Exception $e) {

        DB::rollback();
        throw $e;

      }

    return $documento;
  }

  public function saveDocumento($documento,$request){

    $fecha_caducidad = $request->fecha_caducidad ? date('Y-m-d',strtotime($request->fecha_caducidad)) : null;
    $documento->tipo = $request->tipo;
    $documento->titulo = $request->titulo;
    $documento->descripcion = $request->descripcion;
    $documento->metodo_ensayo_id = $request->metodo_ensayo['id'] !=0 ? $request->metodo_ensayo['id'] : null;
    $documento->path = $request->path;
    $documento->fecha_caducidad = $fecha_caducidad;

    $documento->save();

    return $documento ;
  }

  public function saveUsuarioDocumento($documento,$usuario_documento,$request){

    $usuario_documento->documentacion_id = $documento->id;
    $usuario_documento->user_id = $request->usuario['id'];
    $usuario_documento->tipo_documentacion_usuario_id = $request->tipo_documento_usuario['id'];
    $usuario_documento->save();

  }

  public function saveEquipoDocumento($documento,$equipo_documento,$request){
    Log::debug('request: '. json_encode($request->all())); 
    $equipo_documento->documentacion_id = $documento->id;
    $equipo_documento->interno_equipo_id = $request->interno_equipo['id'];
    $equipo_documento->certificado_verificacion_sn = $request['certificado_verificacion_sn'];
    $equipo_documento->interno_equipo_user_id = $request->user_dosimetro['id'];
    $equipo_documento->save();

  }

  public function saveFuenteDocumento($documento,$fuente_documento,$request){

    $fuente_documento->documentacion_id = $documento->id;
    $fuente_documento->interno_fuente_id = $request->interno_fuente['id'];
    $fuente_documento->save();

  }

  public function saveVehiculoDocumento($documento,$vehiculo_documento,$request){

    $vehiculo_documento->documentacion_id = $documento->id;
    $vehiculo_documento->vehiculo_id = $request->vehiculo['id'];
    $vehiculo_documento->save();

  }

}
