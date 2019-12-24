<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGetObraInformes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
                    CREATE DEFINER=`root`@`localhost` PROCEDURE `getObraInforme`(IN informe_id BIGINT(20) , IN importado_sn TINYINT(1) )
                    BEGIN
                    
                    IF(importado_sn) THEN
                        
                        SELECT informes_importados.obra FROM informes_importados WHERE informes_importados.id = informe_id;
                        
                    ELSE
                    
                        SELECT informes.obra FROM informes WHERE informes.id = informe_id ;
                    END IF;
                    
                    END  
                ";

        DB::unprepared("DROP procedure IF EXISTS getObraInforme");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
