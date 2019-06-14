<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Contactos', function (Blueprint $table) {
          $table->bigInteger('cliente_id')
                 ->unsigned()
                 ->after('id');
          $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Contactos', function (Blueprint $table) {
          $table->dropForeign(['cliente_id']);
          $table->dropColumn('cliente_id');
        });
    }
}
