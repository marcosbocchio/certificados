<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOperadorPeriodoRxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operador_periodo_rx', function (Blueprint $table) {
            
            $table->bigInteger('operador_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('operador_id')
                ->references('id')
                ->on('users');

            $table->bigInteger('user_id')
                ->unsigned()
                ->after('baja');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operador_periodo_rx', function (Blueprint $table) { 

            $table->dropForeign(['operador_id']);
            $table->dropColumn('operador_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

        });
    }
}
