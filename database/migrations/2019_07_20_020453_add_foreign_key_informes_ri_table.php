<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInformesRiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_ri', function (Blueprint $table) {

            $table->bigInteger('informe_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('informe_id')
                   ->references('id')
                   ->on('informes');                       

            
            $table->bigInteger('fuente_id')
                   ->unsigned()
                   ->after('informe_id');
                   
            $table->foreign('fuente_id')
                   ->references('id')
                   ->on('fuentes');

            $table->bigInteger('tipo_pelicula_id')
                   ->unsigned()
                   ->after('fuente_id');
                   
            $table->foreign('tipo_pelicula_id')
                   ->references('id')
                   ->on('tipo_peliculas');
            
            $table->bigInteger('ici_id')
                   ->unsigned()
                   ->after('tipo_pelicula_id');
                   
            $table->foreign('ici_id')
                   ->references('id')
                   ->on('icis');          

                   

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes_ri', function (Blueprint $table) {

            $table->dropForeign(['informe_id']);
            $table->dropColumn('informe_id');

            $table->dropForeign(['tipo_pelicula_id']);
            $table->dropColumn('tipo_pelicula_id');

            $table->dropForeign(['ici_id']);
            $table->dropColumn('ici_id');

            $table->dropForeign(['fuente_id']);
            $table->dropColumn('fuente_id');

        }); 
    }
}
