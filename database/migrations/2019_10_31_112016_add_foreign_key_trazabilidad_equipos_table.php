<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTrazabilidadEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trazabilidad_equipo', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                    ->unsigned()   
                    ->nullable()                   
                    ->after('id');
            
            $table->foreign('ot_id')
                    ->references('id')
                    ->on('ots');

            $table->bigInteger('interno_equipo_id')
                    ->unsigned()                  
                    ->after('ot_id');
            
            $table->foreign('interno_equipo_id')
                    ->references('id')
                    ->on('interno_equipos');


            $table->bigInteger('user_id')
                    ->unsigned()                  
                    ->after('interno_equipo_id');
            
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
        Schema::table('trazabilidad_equipo', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id'); 
          
            $table->dropForeign(['interno_equipo_id']);
            $table->dropColumn('interno_equipo_id'); 
            
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id'); 


        });
    }
}
