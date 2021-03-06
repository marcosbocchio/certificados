<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTrazabilidadFuenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trazabilidad_fuente', function (Blueprint $table) {

            $table->bigInteger('interno_equipo_id')
                    ->unsigned()                  
                    ->after('id');
            
            $table->foreign('interno_equipo_id')
                    ->references('id')
                    ->on('interno_equipos');

            $table->bigInteger('interno_fuente_id')
                    ->unsigned()                  
                    ->after('interno_equipo_id');
            
            $table->foreign('interno_fuente_id')
                    ->references('id')
                    ->on('interno_fuentes');

            $table->bigInteger('user_id')
                    ->unsigned()                  
                    ->after('curie');
            
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trazabilidad_fuente', function (Blueprint $table) {
          
            $table->dropForeign(['interno_fuente_id']);
            $table->dropColumn('interno_fuente_id'); 

            $table->dropForeign(['interno_equipo_id']);
            $table->dropColumn('interno_equipo_id'); 
            
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id'); 


        });
    }
}
