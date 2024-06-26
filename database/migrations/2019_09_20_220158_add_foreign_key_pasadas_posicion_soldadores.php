<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyPasadasPosicionSoldadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasadas_posicion', function (Blueprint $table) {
      
                   
            $table->bigInteger('soldadorz_id')
                   ->unsigned()
                   ->after('posicion_id');
                   
            $table->foreign('soldadorz_id')
                   ->references('id')
                   ->on('ot_soldadores');
            
            $table->bigInteger('soldadorl_id')
                   ->unsigned()
                   ->nullable()
                   ->after('soldadorz_id');
                   
            $table->foreign('soldadorl_id')
                   ->references('id')
                   ->on('ot_soldadores');

            $table->bigInteger('soldadorp_id')
                   ->unsigned()
                   ->nullable()
                   ->after('soldadorl_id');
                   
            $table->foreign('soldadorp_id')
                   ->references('id')
                   ->on('ot_soldadores');  
         

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
        $table->dropForeign(['soldadorz_id']);
        $table->dropColumn('soldadorz_id');

        $table->dropForeign(['soldadorl_id']);
        $table->dropColumn('soldadorl_id');

        $table->dropForeign(['soldadorp_id']);
        $table->dropColumn('soldadorp_id');
    }
}
