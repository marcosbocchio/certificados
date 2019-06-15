<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ots', function (Blueprint $table) {

            $table->bigInteger('cliente_id')
                   ->unsigned()
                   ->after('presupuesto');
                   
            $table->foreign('cliente_id')
                   ->references('id')
                   ->on('clientes');
            
            $table->bigInteger('contacto1_id')
                   ->unsigned()
                   ->after('cliente_id');
                   
            $table->foreign('contacto1_id')
                   ->references('id')
                   ->on('contactos');

            $table->bigInteger('contacto2_id')
                   ->unsigned()
                   ->nullable()
                   ->after('contacto1_id');
                   
            $table->foreign('contacto2_id')
                   ->references('id')
                   ->on('contactos');

            $table->bigInteger('user_id')
                   ->unsigned()
                   ->after('contacto2_id');
                   
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
        Schema::table('ots', function (Blueprint $table) {

            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');

            $table->dropForeign(['contacto1_id']);
            $table->dropColumn('contacto1_id');

            $table->dropForeign(['contacto2_id']);
            $table->dropColumn('contacto2_id');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

        });
    }
}
