<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVencimientosDocumentacionMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Notificación : vencimientos de documentaciones.";
    public $fecha;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fecha)
    {
        $this->fecha  = $fecha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.vencimientos_documentaciones');
    }
}
