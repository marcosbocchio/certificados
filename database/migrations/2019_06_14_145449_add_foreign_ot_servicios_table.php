<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_servicios', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('ot_id')
                   ->references('id')
                   ->on('ots');

            $table->bigInteger('servicio_id')
                   ->unsigned()
                   ->after('ot_id');
                   
            $table->foreign('servicio_id')
                   ->references('id')
                   ->on('servicios');

            $table->bigInteger('norma_ensayo_id')
                   ->unsigned()
                   ->nullable()
                   ->after('servicio_id');
                   
            $table->foreign('norma_ensayo_id')
                   ->references('id')
                   ->on('norma_ensayos');
            
            $table->bigInteger('norma_evaluacion_id')
                   ->unsigned()
                   ->nullable()
                   ->after('norma_ensayo_id');
                   
            $table->foreign('norma_evaluacion_id')
                   ->references('id')
                   ->on('norma_evaluaciones');
            
            $table->bigInteger('ot_referencia_id')
                   ->unsigned()
                   ->nullable()
                   ->after('norma_evaluacion_id');
                   
            $table->foreign('ot_referencia_id')
                   ->references('id')
                   ->on('ot_referencias');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_servicios', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['servicio_id']);
            $table->dropColumn('servicio_id');
            
            $table->dropForeign(['norma_ensayo_id']);
            $table->dropColumn('norma_ensayo_id');

            $table->dropForeign(['norma_evaluacion_id']);
            $table->dropColumn('norma_evaluacion_id');

            $table->dropForeign(['ot_referencia_id']);
            $table->dropColumn('ot_referencia_id');

        }); 
    }
}
