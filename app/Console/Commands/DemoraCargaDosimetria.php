<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendDemoraFechasUsuarioMailable;
use App\User;
use App\Documentaciones;
use App\Alarmas;
use App\AlarmaReceptor;
use App\ParametrosGenerales;

class DemoraCargaDosimetria extends Command
{

    protected $signature = 'command:DemoraCargaDosimetria';

    protected $description = 'Envía un correo a los usuarios con demora en la carga de datos en dosimetría';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function handle()
    {
        DB::enableQueryLog();
        Log::debug("Esto se ejecuto como tarea automatica de dosimetria: " . date("F j, Y, g:i a"));
        $alarmas = Alarmas::all();
        $alarma =  (new \App\Http\Controllers\AlarmasController)->BuscarAlarma($alarmas,'DOSIMETRIA');
        $dias_ultima_notificacion = CalcularDiasEntreFechas($alarma->fecha_ejecucion);
        Log::debug("Dias ultima notificacion dosimetria: " . $dias_ultima_notificacion . " periodo notificacion : " . $alarma->aviso1);
        $parametro_general = ParametrosGenerales::where('codigo','DOSIMETRIA')->first();
        Log::debug("Alarna dosimetria: " . $alarma);

        if( ($alarma->activo_sn) && ($dias_ultima_notificacion == $alarma->aviso1 || $dias_ultima_notificacion > $alarma->aviso1)){

            (new \App\Http\Controllers\AlarmasController)->setFechaEjecucion($alarma);
            $usuarios_dias_demorados = $this->VencimientosDosimetria($parametro_general->valor,$alarma->aviso2);
            $ids_usuarios_con_demora = $this->getIdsUsuarioDemoras($usuarios_dias_demorados);
            $receptores_a_avisar =  (new \App\Http\Controllers\AlarmaReceptorController)->BuscarReceptores('DOSIMETRIA');


            foreach ($ids_usuarios_con_demora as $item_id) {

                Log::debug('item_id usuario con demora' . $item_id);

                $fechas_demoras = $this->getFechasDemorasUsuario($usuarios_dias_demorados,$item_id);
                $user = User::find($item_id);
                if($user->notificar_por_mail_sn){
                    Mail::to($user->email)->send(new SendDemoraFechasUsuarioMailable($user,$fechas_demoras));
                    sleep(10);
                }
                if($user->notificar_por_web_sn){
                    (new \App\Http\Controllers\NotificacionesController)->storeDosimetria($user->id,$user,$fechas_demoras);
                }
                foreach ($receptores_a_avisar as $receptor) {

                    if($receptor->notificar_por_mail_sn){
                        Mail::to($receptor->email)->send(new SendDemoraFechasUsuarioMailable($user,$fechas_demoras));
                        sleep(10);
                    }
                    if($receptor->notificar_por_web_sn){
                        (new \App\Http\Controllers\NotificacionesController)->storeDosimetria($receptor->id,$user,$fechas_demoras);
                    }
                }
            }

            foreach ($usuarios_dias_demorados as $item) {

               Log::debug("Documentacion dosimetria: " . $item->id . ' / ' . $item->name. ' / ' . $item->fecha_demora);

            }

            foreach ($ids_usuarios_con_demora as $item) {

                Log::debug("Documentacion dosimetria usuarios ids: " . $item);

             }

       }


    }

    public function VencimientosDosimetria($fecha_inicio_control,$aviso2){

         return  DB::select('CALL DosimetriaFechasDemoradasUsuarios(?,?)',array($fecha_inicio_control,$aviso2));

    }

    public function getIdsUsuarioDemoras($usuarios_dias_demorados){


        $array_temp = [];

        foreach ($usuarios_dias_demorados as $item) {

            $array_temp[] = $item->id;

        }

        return array_unique($array_temp);

   }

   public function getFechasDemorasUsuario($usuarios_dias_demorados,$user_id){

        $array_temp = [];

        foreach ($usuarios_dias_demorados as $item) {

            if ($item->id == $user_id)
                $array_temp[] = $item->fecha_demora;

        }

        return $array_temp;

   }


}
