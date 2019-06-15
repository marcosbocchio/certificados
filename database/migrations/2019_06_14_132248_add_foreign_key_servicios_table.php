<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios', function (Blueprint $table) {

            $table->bigInteger('unidades_medida_id')
                   ->unsigned()
                   ->after('descripcion');
            $table->foreign('unidades_medida_id')
                   ->references('id')
                   ->on('unidades_medidas');

            $table->bigInteger('metodo_ensayo_id')
                   ->unsigned()
                   ->after('unidades_medida_id');
            
            $table->foreign('metodo_ensayo_id')
                   ->references('id')
                   ->on('metodo_ensayos'); 
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicios', function (Blueprint $table) {

            $table->dropForeign(['unidades_medida_id']);
            $table->dropColumn('unidades_medida_id');

            $table->dropForeign(['metodo_ensayo_id']);
            $table->dropColumn('metodo_ensayo_id');
        });
    }
}
