<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtCalidadPlacasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('OT_calidad_placas', function (Blueprint $table) {

            $table->bigInteger('OT_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('OT_id')
                   ->references('id')
                   ->on('ots');
            
            $table->bigInteger('tipo_pelicula_id')
                   ->unsigned()
                   ->after('OT_id');
                   
            $table->foreign('tipo_pelicula_id')
                   ->references('id')
                   ->on('tipo_peliculas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('OT_calidad_placas', function (Blueprint $table) {

            $table->dropForeign(['OT_id']);
            $table->dropColumn('OT_id');

            $table->dropForeign(['tipo_pelicula_id']);
            $table->dropColumn('tipo_pelicula_id');

        }); 
    }
}
