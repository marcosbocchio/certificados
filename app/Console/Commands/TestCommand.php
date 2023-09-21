<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Str;
use ZipArchive;
use Illuminate\Support\Facades\Response;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:task_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando se ejecuta cada un minuto y escribe fecha/hora en el log ';

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
        Log::debug("Esto se ejecuto como tarea automatica xx : " . date("F j, Y, g:i a"));
    }
}
