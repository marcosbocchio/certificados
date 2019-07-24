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
            
            $table->bigInteger('procedimiento_informe_id')
                    ->unsigned()
                    ->after('gasoducto_sn');
                   
            $table->foreign('procedimiento_informe_id')
                   ->references('id')
                   ->on('procedimientos_informes');
            
            $table->bigInteger('material_id')
                   ->unsigned()
                   ->after('procedimiento_informe_id');
                   
            $table->foreign('material_id')
                   ->references('id')
                   ->on('materiales');

            $table->bigInteger('diametro_espesor_id')
                   ->unsigned()
                   ->nullable()
                   ->after('material_id');
                   
            $table->foreign('diametro_espesor_id')
                   ->references('id')
                   ->on('diametros_espesor');

            $table->bigInteger('equipo_id')
                    ->unsigned()
                    ->after('espesor_chapa');
                   
            $table->foreign('equipo_id')
                   ->references('id')
                   ->on('equipos');
            
            $table->bigInteger('fuente_id')
                   ->unsigned()
                   ->after('equipo_id');
                   
            $table->foreign('fuente_id')
                   ->references('id')
                   ->on('fuentes');

            $table->bigInteger('tipo_pelicula_id')
                   ->unsigned()
                   ->after('foco');
                   
            $table->foreign('tipo_pelicula_id')
                   ->references('id')
                   ->on('tipo_peliculas');
            
            $table->bigInteger('ici_id')
                   ->unsigned()
                   ->after('pos_pos');
                   
            $table->foreign('ici_id')
                   ->references('id')
                   ->on('icis');

            $table->bigInteger('norma_evaluacion_id')
                   ->unsigned()
                   ->after('distancia_fuente_pelicula');
                   
            $table->foreign('norma_evaluacion_id')
                   ->references('id')
                   ->on('norma_evaluaciones');
        
            $table->bigInteger('norma_ensayo_id')
                   ->unsigned()
                   ->after('norma_evaluacion_id');
                   
            $table->foreign('norma_ensayo_id')
                   ->references('id')
                   ->on('norma_ensayos');

            $table->bigInteger('tecnica_id')
                   ->unsigned()
                   ->after('norma_ensayo_id');
                   
            $table->foreign('tecnica_id')
                   ->references('id')
                   ->on('tecnicas');

                   

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

            $table->dropForeign(['procedimiento_informe_id']);
            $table->dropColumn('procedimiento_informe_id');

            $table->dropForeign(['material_id']);
            $table->dropColumn('material_id');

            $table->dropForeign(['diametro_espesor_id']);
            $table->dropColumn('diametro_espesor_id');

            $table->dropForeign(['equipo_id']);
            $table->dropColumn('equipo_id');

            $table->dropForeign(['fuente_id']);
            $table->dropColumn('fuente_id');

            $table->dropForeign(['tipo_pelicula_id']);
            $table->dropColumn('tipo_pelicula_id');

            $table->dropForeign(['ici_id']);
            $table->dropColumn('ici_id');

            $table->dropForeign(['norma_evaluacion_id']);
            $table->dropColumn('norma_evaluacion_id');

            $table->dropForeign(['norma_ensayo_id']);
            $table->dropColumn('norma_ensayo_id');

            $table->dropForeign(['tecnica_id']);
            $table->dropColumn('tecnica_id');

        }); 
    }
}
