<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiametroViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("                        
                        CREATE OR REPLACE 
                        ALGORITHM = UNDEFINED                        
                        SQL SECURITY DEFINER
                    VIEW `diametros_view` AS
                        SELECT DISTINCT
                            `diametros_espesor`.`diametro` AS `diametro`,
                            REPLACE(REPLACE(`diametros_espesor`.`diametro`,
                                    '/',
                                    'b'),
                                ' ',
                                's') AS `diametro_code`
                        FROM
                            `diametros_espesor`
                ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(" DROP VIEW diametros_view ");


    
    }
}
