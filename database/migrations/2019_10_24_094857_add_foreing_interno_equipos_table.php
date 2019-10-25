<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingInternoEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interno_equipos', function (Blueprint $table) {

            $table->bigInteger('equipo_id')
                    ->unsigned()                  
                    ->after('id');
            
            $table->foreign('equipo_id')
                    ->references('id')
                    ->on('equipos');

            $table->bigInteger('interno_fuente_id')
                    ->unsigned()
                    ->nullable()
                    ->after('equipo_id');
            
            $table->foreign('interno_fuente_id')
                    ->references('id')
                    ->on('interno_fuentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interno_equipos', function (Blueprint $table) {
            
            $table->dropForeign(['equipo_id']);
            $table->dropColumn('equipo_id');
            
            $table->dropForeign(['interno_fuente_id']);
            $table->dropColumn('interno_fuente_id');


        });
    }
}
