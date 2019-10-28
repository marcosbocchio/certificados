<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDetallesLpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalles_lp', function (Blueprint $table) {

            $table->bigInteger('informe_lp_id')
                    ->unsigned()                             
                    ->after('id');
                
            $table->foreign('informe_lp_id')
                    ->references('id')
                    ->on('informes_lp');
            
            $table->bigInteger('detalle_lp_referencia_id')
                    ->unsigned()   
                    ->nullable()                          
                    ->after('informe_lp_id');
                        
            $table->foreign('detalle_lp_referencia_id')
                   ->references('id')
                   ->on('detalles_lp_referencias');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalles_lp', function (Blueprint $table) {

            $table->dropForeign(['informe_lp_id']);
            $table->dropColumn('informe_lp_id');
            
            $table->dropForeign(['detalle_lp_referencia_id']);
            $table->dropColumn('detalle_lp_referencia_id');

        });
    }
}
