<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyRemitoInternoEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remito_interno_equipos', function (Blueprint $table) {
            
            $table->bigInteger('remito_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('remito_id')
                ->references('id')
                ->on('remitos');

            $table->bigInteger('interno_equipo_id')
                    ->unsigned()
                    ->after('remito_id');

            $table->foreign('interno_equipo_id')
                  ->references('id')
                  ->on('interno_equipos');  
                  
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remito_interno_equipos', function (Blueprint $table) {

            $table->dropForeign(['remito_id']);
            $table->dropColumn('remito_id');

            $table->dropForeign(['interno_equipo_id']);
            $table->dropColumn('interno_equipo_id');
        });
    }
}
