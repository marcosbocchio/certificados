<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtRiesgosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_riesgos', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('ot_id')
                   ->references('id')
                   ->on('ots');
            
            $table->bigInteger('riesgo_id')
                   ->unsigned()
                   ->after('ot_id');
                   
            $table->foreign('riesgo_id')
                   ->references('id')
                   ->on('riesgos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_riesgos', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['riesgo_id']);
            $table->dropColumn('riesgo_id');

        });
    }
}
