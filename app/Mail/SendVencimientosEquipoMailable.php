<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVencimientosEquipoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $item;
    public $tipo_equipamiento;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item,$tipo_equipamiento)
    {
        $this->item  = $item;
        $this->tipo_equipamiento = $tipo_equipamiento;
        $this->subject = "Notificación : Vencimiento de documentación de EQUIPOS-".$tipo_equipamiento. " (". $item->titulo .")"  ;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.vencimientos_equipo');
    }
}
