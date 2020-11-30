<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDemoraFechasUsuarioMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $user;
    public $fechas_demoras;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$fechas_demoras)
    {

        $this->fechas_demoras  = $fechas_demoras;
        $this->user  = $user;
        $this->subject = "Notificación : Demora carga dosimetría (". $user->name .")"  ;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.demora_fechas_dosimetria');
    }
}
