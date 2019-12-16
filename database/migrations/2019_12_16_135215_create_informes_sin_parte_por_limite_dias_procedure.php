<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesSinPartePorLimiteDiasProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
                        CREATE PROCEDURE `InfomesSinPartePorLimiteDias`(IN `pOt_id` BIGINT, IN `pLimite_dias` INT)
                        SELECT 
                        
                        *
                            
                        FROM 
                        
                        informes 
                        
                        WHERE
                        informes.parte_id IS NULL AND 
                        DATEDIFF(CURDATE() , informes.fecha)  > pLimite_dias AND 
                        informes.ot_id=pOt_id";

        DB::unprepared("DROP procedure IF EXISTS InfomesSinPartePorLimiteDias");
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
