<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyPosicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posicion', function (Blueprint $table) {

            $table->bigInteger('junta_id')
                   ->unsigned()
                   ->after('id');
                   
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
        Schema::table('posicion', function (Blueprint $table) {

            $table->dropForeign(['junta_id']);
            $table->dropColumn('junta_id');


        });
    }
}
