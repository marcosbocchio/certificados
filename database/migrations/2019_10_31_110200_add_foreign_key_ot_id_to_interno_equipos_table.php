<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyOtIdToInternoEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interno_equipos', function (Blueprint $table) {
            
            $table->bigInteger('ot_id')
                    ->unsigned()   
                    ->nullable()
                    ->after('id');
                
            $table->foreign('ot_id')
                    ->references('id')
                    ->on('ots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interno_equipos', function (Blueprint $table) {
           
            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');
        });
    }
}
