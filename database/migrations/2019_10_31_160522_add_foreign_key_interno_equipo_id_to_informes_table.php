<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInternoEquipoIdToInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes', function (Blueprint $table) {
            
            $table->bigInteger('interno_equipo_id')
                    ->unsigned()
                    ->after('diametro_espesor_id');

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
        Schema::table('informes', function (Blueprint $table) {

            $table->dropForeign(['interno_equipo_id']);
            $table->dropColumn('interno_equipo_id');
        });
    }
}
