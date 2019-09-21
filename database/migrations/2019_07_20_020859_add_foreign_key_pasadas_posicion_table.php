<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyPasadasPosicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasadas_posicion', function (Blueprint $table) {

            $table->bigInteger('posicion_id')
                   ->unsigned()
                   ->after('numero');
                   
            $table->foreign('posicion_id')
                   ->references('id')
                   ->on('posicion');   
        
         

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasadas_posicion', function (Blueprint $table) {

            $table->dropForeign(['posicion_id']);
            $table->dropColumn('posicion_id');

        });
    }
}
