<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('ot_id')
                   ->references('id')
                   ->on('ots');

            $table->bigInteger('procedimiento_informe_id')
                   ->unsigned()
                   ->after('ot_id');
                  
           $table->foreign('procedimiento_informe_id')
                  ->references('id')
                  ->on('ot_procedimientos_propios');
                  
          $table->bigInteger('diametro_espesor_id')
                  ->unsigned()
                  ->nullable()
                  ->after('procedimiento_informe_id');
                  
           $table->foreign('diametro_espesor_id')
                  ->references('id')
                  ->on('diametros_espesor');          
            
            $table->bigInteger('metodo_ensayo_id')
                    ->unsigned()
                    ->after('diametro_espesor_id');
                   
            $table->foreign('metodo_ensayo_id')
                   ->references('id')
                   ->on('metodo_ensayos');
            
            $table->bigInteger('norma_evaluacion_id')
                   ->unsigned()
                   ->after('metodo_ensayo_id');
                   
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
                   ->nullable()
                   ->after('norma_ensayo_id');
                   
            $table->foreign('tecnica_id')
                   ->references('id')
                   ->on('tecnicas');
            
            $table->bigInteger('user_id')
                   ->unsigned()
                   ->after('tecnica_id');
                   
            $table->foreign('user_id')
                   ->references('id')
                   ->on('users');

            $table->bigInteger('ejecutor_ensayo_id')
                   ->unsigned()
                   ->after('user_id');
                   
            $table->foreign('ejecutor_ensayo_id')
                   ->references('id')
                   ->on('ot_operarios');
              
           $table->bigInteger('material_id')
                   ->unsigned()
                   ->after('ejecutor_ensayo_id');
                   
            $table->foreign('material_id')
                   ->references('id')
                   ->on('materiales');              
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['metodo_ensayo_id']);
            $table->dropColumn('metodo_ensayo_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['ejecutor_ensayo_id']);
            $table->dropColumn('ejecutor_ensayo_id');

            $table->dropForeign(['material_id']);
            $table->dropColumn('material_id');

            $table->dropForeign(['procedimiento_informe_id']);
            $table->dropColumn('procedimiento_informe_id');

            $table->dropForeign(['diametro_espesor_id']);
            $table->dropColumn('diametro_espesor_id');           

            $table->dropForeign(['norma_ensayo_id']);
            $table->dropColumn('norma_ensayo_id');

            $table->dropForeign(['tecnica_id']);
            $table->dropColumn('tecnica_id');  
            
            $table->dropForeign(['procedimiento_informe_id']);
            $table->dropColumn('procedimiento_informe_id');

            $table->dropForeign(['equipo_id']);
            $table->dropColumn('equipo_id');

          

        });
    }
}
