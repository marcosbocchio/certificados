<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtSoldadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_soldadores', function (Blueprint $table) {
        
            $table->bigInteger('ot_id')
                    ->unsigned()
                    ->after('id');
                    
            $table->foreign('ot_id')
                    ->references('id')
                    ->on('ots');

           $table->bigInteger('soldadores_id')
                    ->unsigned()
                    ->after('ot_id');
                    
            $table->foreign('soldadores_id')
                    ->references('id')
                    ->on('soldadores');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_soldadores', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['soldadores_id']);
            $table->dropColumn('soldadores_id');


        });
    }
}
