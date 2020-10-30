<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVencimientosDocumentacionMailable;
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
        $fecha = date("F j, Y, g:i a");
        Mail::to('marcosbocchio@gmail.com')->send(new SendVencimientosDocumentacionMailable($fecha));
    }
}
