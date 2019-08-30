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

            $table->bigInteger('informe_pm_id')
                ->unsigned()                             
                ->after('id');
                
            $table->foreign('informe_pm_id')
                    ->references('id')
                    ->on('informes_pm');
           
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

            $table->dropForeign(['informe_pm_id']);
            $table->dropColumn('informe_pm_id');


        });
    }
}
