<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInternoFuenteIdToInformesRiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_ri', function (Blueprint $table) {

            $table->bigInteger('interno_fuente_id')
                   ->unsigned()
                   ->nullable()
                   ->after('informe_id');
                   
            $table->foreign('interno_fuente_id')
                   ->references('id')
                   ->on('interno_fuentes');
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

            $table->dropForeign(['interno_fuente_id']);
            $table->dropColumn('interno_fuente_id');
        });
    }
}
