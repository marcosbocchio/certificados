<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspesoresDiametroProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        $procedure = "
                        CREATE PROCEDURE `EspesoresDiametro`(IN `diametro_code` varchar(10))
                                        
                        SELECT * FROM diametros_espesor 
                        where 
                        diametro = replace(replace(diametro_code,'b','/'),'s', ' ')        
                ";

DB::unprepared("DROP procedure IF EXISTS EspesoresDiametro");
DB::unprepared($procedure);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()    {
        
    }
}
