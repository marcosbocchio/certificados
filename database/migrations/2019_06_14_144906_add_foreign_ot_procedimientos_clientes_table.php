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
        Schema::table('ot_procedimientos_clientes', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
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
        Schema::table('ot_procedimientos_clientes', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

        }); 
    }
}
