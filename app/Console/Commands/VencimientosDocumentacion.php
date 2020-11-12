<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVencimientosDocumentacionMailable;
use App\Documentaciones;
use App\Alarmas;

class VencimientosDocumentacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:VencimientosDocumentacion';

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
        $alarmas = Alarmas::all();

        $alarma = $this->BuscarAlarma($alarmas,'USUARIO');
        $this->EnviarMailVencimientosUsuarios($alarma);

        //    Log::debug("Usuarios con documentacion vencida: " . $item->name . ' - DOCUMENTO:' . $item->tipo . '->' . $item->titulo);
        //    Mail::to('marcosbocchio@gmail.com')->send(new SendVencimientosDocumentacionMailable($item));
        //    Mail::to('bocchio_marcos@gmail.com')->send(new SendVencimientosDocumentacionMailable($item));


    }

    public function EnviarMailVencimientosUsuarios($alarma){

        $usuarios_vencidos = $this->VencimientosUsuarios($alarma->aviso1,$alarma->aviso2);

        foreach ($usuarios_vencidos as $item) {

            Log::debug("Usuarios con documentacion vencida: " . $item->name . ' - DOCUMENTO:' . $item->tipo . '->' . $item->titulo);

        }

    }


    public function VencimientosUsuarios($aviso1,$aviso2){

        return Documentaciones::join('usuario_documentaciones','documentaciones.id','=','usuario_documentaciones.documentacion_id')
                                      ->join('users','users.id','=','usuario_documentaciones.user_id')
                                      ->whereRaw('DATEDIFF(now(),documentaciones.fecha_caducidad) = ? or DATEDIFF(now(),documentaciones.fecha_caducidad) = ?',[$aviso1,$aviso2])
                                      ->select('users.name','documentaciones.tipo','documentaciones.titulo')
                                      ->get();


    }



    public function BuscarAlarma($alarmas,$tipo){

        foreach ($alarmas as $alarma) {

            if($alarma->tipo == $tipo){

                return $alarma;

            }

        }

        return false;

     }


}
