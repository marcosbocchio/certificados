<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyProcedimentosPropiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procedimientos_propios', function (Blueprint $table) {
            $table->bigInteger('documentaciones_id')
                   ->unsigned();
            $table->foreign('documentaciones_id')
                   ->references('id')
                   ->on('documentaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procedimientos_propios', function (Blueprint $table) {
            $table->dropForeign(['documentaciones_id']);
            $table->dropColumn('documentaciones_id');
        });
    }
}
