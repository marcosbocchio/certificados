<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDefectosPosicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defectos_posicion', function (Blueprint $table) {
            
            $table->bigInteger('posicion_id')
                    ->unsigned()
                    ->after('id');
                   
            $table->foreign('posicion_id')
                   ->references('id')
                   ->on('posicion'); 
                   
            $table->bigInteger('defecto_ri_id')
                    ->unsigned()
                    ->after('posicion_id');
                   
            $table->foreign('defecto_ri_id')
                   ->references('id')
                   ->on('defectos_ri');           
         

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
        

            $table->dropForeign(['posicion_id']);
            $table->dropColumn('posicion_id');

            $table->dropForeign(['defecto_ri_id']);
            $table->dropColumn('defecto_ri_id');


        });
    }
}
