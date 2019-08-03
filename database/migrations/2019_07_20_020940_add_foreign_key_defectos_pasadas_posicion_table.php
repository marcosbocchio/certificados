<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDefectosPasadasPosicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defectos_pasadas_posicion', function (Blueprint $table) {
            
                   
            $table->bigInteger('defecto_ri_id')
                    ->unsigned()
                    ->after('id');
                   
            $table->foreign('defecto_ri_id')
                   ->references('id')
                   ->on('defectos_ri');  
                   
            $table->bigInteger('pasada_posicion_id')
                    ->unsigned()
                    ->after('defecto_ri_id');
                   
            $table->foreign('pasada_posicion_id')
                   ->references('id')
                   ->on('pasadas_posicion');
         

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defectos_posicion', function (Blueprint $table) {
        

            $table->dropForeign(['defecto_ri_id']);
            $table->dropColumn('defecto_ri_id');

            $table->dropForeign(['pasada_posicion_id']);
            $table->dropColumn('pasada_posicion_id');


        });
    }
}
