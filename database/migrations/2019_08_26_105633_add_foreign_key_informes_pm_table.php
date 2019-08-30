<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInformesPmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_pm', function (Blueprint $table) {

            $table->bigInteger('informe_id')
                ->unsigned()                             
                ->after('id');
                
            $table->foreign('informe_id')
                    ->references('id')
                    ->on('informes');

            $table->bigInteger('metodo_trabajo_pm_id')
                    ->unsigned()                             
                    ->after('informe_id');
                    
            $table->foreign('metodo_trabajo_pm_id')
                    ->references('id')
                    ->on('metodos_trabajo_pm');

            $table->bigInteger('tipo_magnetizacion_id')
                    ->unsigned()                             
                    ->after('concentracion');
                    
            $table->foreign('tipo_magnetizacion_id')
                    ->references('id')
                    ->on('tipos_magnetizacion');

            $table->bigInteger('corriente_magnetizacion_id')
                    ->unsigned()                             
                    ->after('tipo_magnetizacion_id');
                    
            $table->foreign('corriente_magnetizacion_id')
                    ->references('id')
                    ->on('corrientes');

           $table->bigInteger('corriente_desmagnetizacion_id')
                    ->unsigned()                             
                    ->after('corriente_magnetizacion_id');
                    
            $table->foreign('corriente_desmagnetizacion_id')
                    ->references('id')
                    ->on('corrientes');

            $table->bigInteger('color_particula_id')
                    ->unsigned()                             
                    ->after('corriente_desmagnetizacion_id');
                    
            $table->foreign('color_particula_id')
                    ->references('id')
                    ->on('color_particulas');
            
            $table->bigInteger('iluminacion_id')
                    ->unsigned()                             
                    ->after('color_particula_id');
                    
            $table->foreign('iluminacion_id')
                    ->references('id')
                    ->on('iluminaciones');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes_pm', function (Blueprint $table) {

            $table->dropForeign(['informe_id']);
            $table->dropColumn('informe_id');

            $table->dropForeign(['metodo_trabajo_pm_id']);
            $table->dropColumn('metodo_trabajo_pm_id');

            $table->dropForeign(['tipo_magnetizacion_id']);
            $table->dropColumn('tipo_magnetizacion_id');

            $table->dropForeign(['corriente_magnetizacion_id']);
            $table->dropColumn('corriente_magnetizacion_id');

            $table->dropForeign(['corriente_desmagnetizacion_id']);
            $table->dropColumn('corriente_desmagnetizacion_id');

            $table->dropForeign(['color_particula_id']);
            $table->dropColumn('color_particula_id');

            $table->dropForeign(['iluminacion_id']);
            $table->dropColumn('iluminacion_id');


        });
    }
}
