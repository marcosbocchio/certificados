<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDocumentacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentaciones', function (Blueprint $table) {
            $table->bigInteger('metodo_ensayo_id')
                   ->unsigned()
                   ->nullable();
            $table->foreign('metodo_ensayo_id')
                   ->references('id')
                   ->on('metodo_ensayos');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documentaciones', function (Blueprint $table) {
            $table->dropForeign(['metodo_ensayo_id']);
            $table->dropColumn('metodo_ensayo_id');
      });
    }
}
