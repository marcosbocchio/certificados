<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtProcedimientosClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('OT_procedimientos_clientes', function (Blueprint $table) {

            $table->bigInteger('OT_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('OT_id')
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
        Schema::table('OT_procedimientos_clientes', function (Blueprint $table) {

            $table->dropForeign(['OT_id']);
            $table->dropColumn('OT_id');

        }); 
    }
}
