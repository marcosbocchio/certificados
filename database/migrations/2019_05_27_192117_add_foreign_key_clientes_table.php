<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Clientes', function (Blueprint $table) {
            $table->bigInteger('partido_id')
                  ->unsigned();
            $table->foreign('partido_id')
                  ->references('id')
                  ->on('partidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Clientes', function (Blueprint $table) {
             $table->dropForeign(['partido_id']);
             $table->dropColumn('partido_id');
        });
    }
}
