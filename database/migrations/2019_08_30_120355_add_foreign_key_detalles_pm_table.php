<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDetallesPmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalles_pm', function (Blueprint $table) {

            $table->bigInteger('detalle_pm_referencia_id')
                ->unsigned()   
                ->nullable()                          
                ->after('informe_pm_id');
                
            $table->foreign('detalle_pm_referencia_id')
                    ->references('id')
                    ->on('detalles_pm_referencias');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalles_pm', function (Blueprint $table) {

            $table->dropForeign(['detalle_pm_referencia_id']);
            $table->dropColumn('detalle_pm_referencia_id');


        });
    }
}
