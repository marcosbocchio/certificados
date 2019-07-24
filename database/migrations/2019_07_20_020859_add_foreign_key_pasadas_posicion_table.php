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

            $table->bigInteger('junta_id')
                   ->unsigned()
                   ->after('numero');
                   
            $table->foreign('junta_id')
                   ->references('id')
                   ->on('juntas');      
         

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

            $table->dropForeign(['junta_id']);
            $table->dropColumn('junta_id');


        });
    }
}
