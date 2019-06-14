<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyPartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Partidos', function (Blueprint $table) {
            $table->bigInteger('provincia_id')
                  ->unsigned()
                  ->after('partido');
            $table->foreign('provincia_id')
                  ->references('id')
                  ->on('provincias');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Partidos', function (Blueprint $table) {
          $table->dropForeign(['provincia_id']);
          $table->dropColumn('provincia_id');
        });
    }
}
