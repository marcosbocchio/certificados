<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoraCargaDosimetria extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DemoraCargaDosimetria';

    /**
     * The console command description.
     *
     * @var string
     */
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
