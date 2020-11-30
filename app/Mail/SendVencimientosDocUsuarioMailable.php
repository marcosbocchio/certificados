<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVencimientosDocUsuarioMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $item;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item  = $item;
        $this->subject = "Notificación : Vencimiento de documentación de usuarios (". $item->titulo .")"  ;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.vencimientos_doc_usuario');
    }
}
