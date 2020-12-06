<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVencimientosDocUsuarioMailable;
use App\Mail\SendVencimientosGeneralMailable;
use App\Mail\SendVencimientosFuenteMailable;
use App\Mail\SendVencimientosEquipoMailable;
use App\Mail\SendVencimientosProcedimientosMailable;
use App\Mail\SendVencimientosVehiculosMailable;

use App\Documentaciones;
use App\Alarmas;
use App\AlarmaReceptor;
Use App\User;

class VencimientosDocumentaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:VencimientosDocumentaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un correo a los usuarios que tengan documentaciones próximas a vencer (días parametrizables)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::enableQueryLog();
        Log::debug("Se ejecutó la tarea");
        $alarmas = Alarmas::all();

        /* USUARIOS */
        $alarma =  (new \App\Http\Controllers\AlarmasController)->BuscarAlarma($alarmas,'USUARIO');
        if($alarma->activo_sn){

            $usuarios_vencidos = $this->VencimientosUsuarios($alarma->aviso1,$alarma->aviso2);
            $this->EnviarMailVencimientosUsuarios($usuarios_vencidos);
            Log::debug("Documentacion usuario: " . $usuarios_vencidos);

        }

        /* GENERALES */
        $alarma =  (new \App\Http\Controllers\AlarmasController)->BuscarAlarma($alarmas,'GENERAL');
        if($alarma->activo_sn){

            $general_vencidos = $this->VencimientosGeneral($alarma->aviso1,$alarma->aviso2);
            $this->EnviarMailVencimientosSoloReceptores($general_vencidos,'GENERAL');
            Log::debug("Documentacion general: " . $general_vencidos);
        }

        /* FUENTES */
        $alarma =  (new \App\Http\Controllers\AlarmasController)->BuscarAlarma($alarmas,'FUENTES');
        if($alarma->activo_sn){

            $fuentes_vencidos = $this->VencimientosFuentes($alarma->aviso1,$alarma->aviso2);
            $this->EnviarMailVencimientosSoloReceptores($fuentes_vencidos,'FUENTES');
            Log::debug("Documentacion fuentes: " . $fuentes_vencidos);
        }


        /* EQUIPOS */
        $alarma =  (new \App\Http\Controllers\AlarmasController)->BuscarAlarma($alarmas,'EQUIPOS');
        if($alarma->activo_sn){

            $equipos_vencidos = $this->VencimientosEquipos($alarma->aviso1,$alarma->aviso2);
            $this->EnviarMailVencimientosSoloReceptores($equipos_vencidos,'EQUIPOS');
            Log::debug("Documentacion equipos: " . $equipos_vencidos);
        }

        /* PROCEDIMIENTOS */
        $alarma =  (new \App\Http\Controllers\AlarmasController)->BuscarAlarma($alarmas,'PROCEDIMIENTOS');
        if($alarma->activo_sn){

            $procedimientos_vencidos = $this->VencimientosProcedimientos($alarma->aviso1,$alarma->aviso2);
            $this->EnviarMailVencimientosSoloReceptores($procedimientos_vencidos,'PROCEDIMIENTOS');
            Log::debug("Documentacion procedimientos: " . $procedimientos_vencidos);
        }

       /* VEHICULOS */
       $alarma =  (new \App\Http\Controllers\AlarmasController)->BuscarAlarma($alarmas,'VEHICULOS');

       if($alarma->activo_sn){

           $vehiculos_vencidos = $this->VencimientosVehiculos($alarma->aviso1,$alarma->aviso2);
           $this->EnviarMailVencimientosSoloReceptores($vehiculos_vencidos,'VEHICULOS');
           Log::debug("Documentacion vehiculos: " . $vehiculos_vencidos);
        }


    }


    public function VencimientosUsuarios($aviso1,$aviso2){

        return Documentaciones::join('usuario_documentaciones','documentaciones.id','=','usuario_documentaciones.documentacion_id')
                                        ->join('users','users.id','=','usuario_documentaciones.user_id')
                                        ->whereRaw('users.notificar_doc_vencida_sn = 1 and (DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ? or DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ?)',[$aviso1,$aviso2])
                                        ->select('users.id as user_id','users.name','documentaciones.tipo','documentaciones.titulo','users.email','documentaciones.fecha_caducidad','documentaciones.id as documentacion_id')
                                        ->get();

    }

    public function EnviarMailVencimientosUsuarios($usuarios_vencidos){


        foreach ($usuarios_vencidos as $item) {

            Log::debug("Usuarios con documentacion vencida: " . $item->name . ' - DOCUMENTO:' . $item->tipo . '->' . $item->titulo);

            Mail::to($item->email)->send(new SendVencimientosDocUsuarioMailable($item));
            sleep(10);
            (new \App\Http\Controllers\NotificacionesController)->store($item->user_id,$item);
            $receptores_a_avisar =  (new \App\Http\Controllers\AlarmaReceptorController)->BuscarReceptores('USUARIO');
            foreach ($receptores_a_avisar as $receptor) {

                Log::debug("Usuarios receptor: " . $receptor->name . ' - DOCUMENTO:' . $item->tipo . '->' . $item->titulo);

                Mail::to($receptor->email)->send(new SendVencimientosDocUsuarioMailable($item));
                sleep(10);
                (new \App\Http\Controllers\NotificacionesController)->store($receptor->id,$item);
            }
        }

    }

    public function VencimientosGeneral($aviso1,$aviso2){

        return Documentaciones::whereRaw('tipo = "INSTITUCIONAL"   and (DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ? or DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ?)',[$aviso1,$aviso2])
                                ->select('documentaciones.tipo','documentaciones.titulo','documentaciones.fecha_caducidad','documentaciones.id as documentacion_id')
                                ->get();

    }

    public function VencimientosFuentes($aviso1,$aviso2){

        return Documentaciones::join('interno_fuente_documentaciones','documentaciones.id','=','interno_fuente_documentaciones.documentacion_id')
                                ->join('interno_fuentes','interno_fuentes.id','=','interno_fuente_documentaciones.interno_fuente_id')
                                ->join('fuentes','fuentes.id','=','interno_fuentes.fuente_id')
                                ->whereRaw('DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ? or DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ?',[$aviso1,$aviso2])
                                ->select('interno_fuentes.nro_serie','fuentes.codigo','documentaciones.tipo','documentaciones.titulo','documentaciones.fecha_caducidad','documentaciones.id as documentacion_id')
                                ->get();

    }

    public function VencimientosEquipos($aviso1,$aviso2){

        return Documentaciones::join('interno_equipo_documentaciones','documentaciones.id','=','interno_equipo_documentaciones.documentacion_id')
                                ->join('interno_equipos','interno_equipos.id','=','interno_equipo_documentaciones.interno_equipo_id')
                                ->join('equipos','equipos.id','=','interno_equipos.equipo_id')
                                ->whereRaw('DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ? or DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ?',[$aviso1,$aviso2])
                                ->select('interno_equipos.nro_serie','interno_equipos.nro_interno','equipos.codigo','documentaciones.tipo','documentaciones.titulo','documentaciones.fecha_caducidad','documentaciones.id as documentacion_id')
                                ->get();

    }

    public function VencimientosProcedimientos($aviso1,$aviso2){

        return Documentaciones::whereRaw('tipo = "PROCEDIMIENTO GENERAL"   and (DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ? or DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ?)',[$aviso1,$aviso2])
                                ->select('documentaciones.tipo','documentaciones.titulo','documentaciones.fecha_caducidad','documentaciones.id as documentacion_id')
                                ->get();

    }

    public function VencimientosVehiculos($aviso1,$aviso2){

        return Documentaciones::join('vehiculo_documentaciones','documentaciones.id','=','vehiculo_documentaciones.documentacion_id')
                                ->join('vehiculos','vehiculos.id','=','vehiculo_documentaciones.vehiculo_id')
                                ->whereRaw('DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ? or DATEDIFF(documentaciones.fecha_caducidad,DATE(now())) = ?',[$aviso1,$aviso2])
                                ->select('vehiculos.patente','vehiculos.marca','vehiculos.modelo','vehiculos.tipo as tipo_vehiculo','documentaciones.tipo','documentaciones.descripcion','documentaciones.titulo','documentaciones.fecha_caducidad','documentaciones.id as documentacion_id')
                                ->get();

    }


    public function EnviarMailVencimientosSoloReceptores($doc_vencidos,$tipo){


        $receptores_a_avisar =  (new \App\Http\Controllers\AlarmaReceptorController)->BuscarReceptores($tipo);

        foreach ($doc_vencidos as $item) {

            foreach ($receptores_a_avisar as $receptor) {

                Log::debug($tipo ." receptor: " . $receptor->name . ' - DOCUMENTO:' . $item->tipo . '->' . $item->titulo);

                switch ($item->tipo) {

                    case 'INSTITUCIONAL':

                        Mail::to($receptor->email)->send(new SendVencimientosGeneralMailable($item));
                        break;

                    case 'FUENTE':
                        Mail::to($receptor->email)->send(new SendVencimientosFuenteMailable($item));
                        break;

                    case 'EQUIPO':
                        Mail::to($receptor->email)->send(new SendVencimientosEquipoMailable($item));
                        break;

                    case 'PROCEDIMIENTO GENERAL':
                         Mail::to($receptor->email)->send(new SendVencimientosProcedimientosMailable($item));
                        break;

                    case 'VEHICULO':
                          Mail::to($receptor->email)->send(new SendVencimientosVehiculosMailable($item));
                           break;


                    default:
                        # code...
                        break;

                }

                sleep(10);


                (new \App\Http\Controllers\NotificacionesController)->store($receptor->id,$item);
            }

        }

    }


}
