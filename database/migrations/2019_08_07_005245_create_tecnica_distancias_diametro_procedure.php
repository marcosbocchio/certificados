<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTecnicaDistanciasDiametroProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
                        CREATE PROCEDURE `TecnicaDistanciasDiametro`(IN `id` BIGINT, IN `diametro_code` varchar(10))
                                        
                        SELECT * FROM tecnica_distancias 
                        where 
                        diametro = replace(replace(diametro_code,'b','/'),'s', ' ') COLLATE utf8mb4_unicode_ci and
                        tecnica_id = id        
                ";

        DB::unprepared("DROP procedure IF EXISTS TecnicaDistanciasDiametro");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     
    }
}
