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
        Log::debug("Alarna dosimetria: " . $alarma);

        if($alarma->activo_sn){

            $usuarios_dias_demorados = $this->VencimientosDosimetria($alarma->aviso1,$alarma->aviso2);
            $ids_usuarios_con_demora = $this->getIdsUsuarioDemoras($usuarios_dias_demorados);
            $receptores_a_avisar =  (new \App\Http\Controllers\AlarmaReceptorController)->BuscarReceptores('DOSIMETRIA');


            foreach ($ids_usuarios_con_demora as $item_id) {

                $fechas_demoras = $this->getFechasDemorasUsuario($usuarios_dias_demorados,$item_id);
                $user = User::find($item_id);
                Mail::to($user->email)->send(new SendDemoraFechasUsuarioMailable($user,$fechas_demoras));
                  (new \App\Http\Controllers\NotificacionesController)->storeDosimetria($user->id,$user,$fechas_demoras);
                foreach ($receptores_a_avisar as $receptor) {

                    Mail::to($receptor->email)->send(new SendDemoraFechasUsuarioMailable($user,$fechas_demoras));
                    (new \App\Http\Controllers\NotificacionesController)->storeDosimetria($receptor->id,$user,$fechas_demoras);
                }
            }

        //  $this->EnviarMailVencimientosUsuarios($usuarios_vencidos);
            foreach ($usuarios_dias_demorados as $item) {

               Log::debug("Documentacion dosimetria: " . $item->id . ' / ' . $item->name. ' / ' . $item->Date);

            }

            foreach ($ids_usuarios_con_demora as $item) {

                Log::debug("Documentacion dosimetria usuarios ids: " . $item);

             }

       }


    }

    public function VencimientosDosimetria($aviso1,$aviso2){

         return  DB::select('CALL DosimetriaFechasDemoradasUsuarios(?)',array($aviso2));

    }

    public function getIdsUsuarioDemoras($usuarios_dias_demorados){


        $array_temp = [];

        foreach ($usuarios_dias_demorados as $item) {

            $array_temp[] = $item->id;

        }

        return array_unique($array_temp);

   }

   public function getFechasDemorasUsuario($usuarios_dias_demorados,$user__id){

        $array_temp = [];

        foreach ($usuarios_dias_demorados as $item) {

            if ($item->id == $user__id)
                $array_temp[] = $item->Date;

        }

        return $array_temp;

   }


}
