<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternoEquipos;
use Illuminate\Support\Facades\Log;
use App\Documentaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\VehiculoDocumentaciones;

class QrController extends Controller
{

    public function __construct()
    {

      $this->middleware(['role_or_permission:Sistemas|QR_interno_equipos'],['only' => ['callViewInternoEquipo']]);

    }

    public function callViewInternoEquipo() {

        $user = auth()->user();
        $header_titulo = "QR Interno Equipos";
        $header_descripcion ="";
        return view('qr.interno-equipos',compact('user','header_titulo','header_descripcion'));        

    }

    public function intEquipoDoc($interno_equipo_id) {

      $user = auth()->user();
      $header_titulo = "Interno Equipo Documentación";
      $header_descripcion ="";
      return view('qr.interno-equipos-documentacion',compact('user','header_titulo','header_descripcion','interno_equipo_id'));   

    }

    public function getInternoEquipos($tipo_equipamiento_id, $search) {
        
      $tipo_equipamiento_id = $tipo_equipamiento_id !== 'null' ? $tipo_equipamiento_id : '0';
      $filtro = $search !== 'null' ? $search : '';

      return InternoEquipos::with('equipo.metodoEnsayos')
                            ->with('equipo.tipoEquipamiento')                                          
                            ->with('internoFuente.fuente')
                            ->whereRaw('0 = ?',array($tipo_equipamiento_id))
                            ->orWhereHas('equipo.tipoEquipamiento', function ($q) use($tipo_equipamiento_id) {
                              $q->WhereRaw('tipos_equipamiento.id = ?',array($tipo_equipamiento_id));
                            })                                                       
                            ->selectRaw('interno_equipos.*,CONVERT(nro_interno,UNSIGNED) as nro_interno_numeric' )
                            ->orderby('nro_interno_numeric','ASC')
                            ->Filtro($filtro)                            
                            ->get();
    }

    public function getDocIntEquipos($interno_equipo_id) {

      $documentacion = Documentaciones::join('interno_equipo_documentaciones','interno_equipo_documentaciones.documentacion_id','=','documentaciones.id')
                                        ->join('interno_equipos','interno_equipos.id','=','interno_equipo_documentaciones.interno_equipo_id')
                                        ->where('interno_equipo_documentaciones.interno_equipo_id',$interno_equipo_id)
                                        ->select('documentaciones.*','interno_equipos.nro_interno','interno_equipos.nro_serie')
                                        ->get();

      return $documentacion;
    }
}
