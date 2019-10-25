<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInformesLpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_lp', function (Blueprint $table) {

            $table->bigInteger('informe_id')
                ->unsigned()                             
                ->after('id');
                
            $table->foreign('informe_id')
                    ->references('id')
                    ->on('informes');

            $table->bigInteger('metodo_trabajo_lp_id')
                    ->unsigned()                             
                    ->after('informe_id');
                    
            $table->foreign('metodo_trabajo_lp_id')
                    ->references('id')
                    ->on('metodos_trabajo_lp');

            $table->bigInteger('penetrante_tipo_liquido')
                    ->unsigned()                             
                    ->after('tipo_penetrante');
                    
            $table->foreign('penetrante_tipo_liquido')
                    ->references('id')
                    ->on('tipo_liquidos');

            $table->bigInteger('penetrante_aplicacion_lp_id')
                    ->unsigned()                             
                    ->after('penetrante_tipo_liquido');
                    
            $table->foreign('penetrante_aplicacion_lp_id')
                    ->references('id')
                    ->on('aplicaciones_lp');          

            $table->bigInteger('revelador_tipo_liquido')
                    ->unsigned()                             
                    ->after('penetrante_aplicacion_lp_id');
                    
            $table->foreign('revelador_tipo_liquido')
                    ->references('id')
                    ->on('tipo_liquidos');
            
            $table->bigInteger('revelador_aplicacion_lp_id')
                    ->unsigned()                             
                    ->after('revelador_tipo_liquido');
                    
            $table->foreign('revelador_aplicacion_lp_id')
                    ->references('id')
                    ->on('aplicaciones_lp');
            
            $table->bigInteger('removedor_tipo_liquido')
                    ->unsigned()                             
                    ->after('revelador_aplicacion_lp_id');
                    
            $table->foreign('removedor_tipo_liquido')
                    ->references('id')
                    ->on('tipo_liquidos');
            
            $table->bigInteger('removedor_aplicacion_lp_id')
                    ->unsigned()                             
                    ->after('removedor_tipo_liquido');
                    
            $table->foreign('removedor_aplicacion_lp_id')
                    ->references('id')
                    ->on('aplicaciones_lp');

            $table->bigInteger('iluminacion_id')
                    ->unsigned()                             
                    ->after('removedor_aplicacion_lp_id');
                    
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
        Schema::table('informes_lp', function (Blueprint $table) {
          
            $table->dropForeign(['informe_id']);
            $table->dropColumn('informe_id');
            
            $table->dropForeign(['metodo_trabajo_lp_id']);
            $table->dropColumn('metodo_trabajo_lp_id');  

            $table->dropForeign(['penetrante_tipo_liquido']);
            $table->dropColumn('penetrante_tipo_liquido');  

            $table->dropForeign(['penetrante_aplicacion_lp_id']);
            $table->dropColumn('penetrante_aplicacion_lp_id');  

            $table->dropForeign(['revelador_tipo_liquido']);
            $table->dropColumn('revelador_tipo_liquido');  

            $table->dropForeign(['revelador_aplicacion_lp_id']);
            $table->dropColumn('revelador_aplicacion_lp_id');  

            $table->dropForeign(['removedor_tipo_liquido']);
            $table->dropColumn('removedor_tipo_liquido');  

            $table->dropForeign(['removedor_aplicacion_lp_id']);
            $table->dropColumn('removedor_aplicacion_lp_id');  

            $table->dropForeign(['iluminacion_id']);
            $table->dropColumn('iluminacion_id');  


        });
    }
}
