<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtProcedimientosPropiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_procedimientos_propios', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('ot_id')
                   ->references('id')
                   ->on('ots');
            
            $table->bigInteger('procedimientos_propio_id')
                   ->unsigned()
                   ->after('ot_id');
                   
            $table->foreign('procedimientos_propio_id')
                   ->references('id')
                   ->on('procedimientos_propios');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_procedimientos_propios', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['procedimientos_propio_id']);
            $table->dropColumn('procedimientos_propio_id');

        }); 
    }
}
