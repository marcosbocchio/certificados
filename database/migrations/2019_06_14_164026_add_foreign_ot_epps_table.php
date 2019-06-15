<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignOtEppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_epps', function (Blueprint $table) {

            $table->bigInteger('ot_id')
                   ->unsigned()
                   ->after('id');
                   
            $table->foreign('ot_id')
                   ->references('id')
                   ->on('ots');
            
            $table->bigInteger('epp_id')
                   ->unsigned()
                   ->after('ot_id');
                   
            $table->foreign('epp_id')
                   ->references('id')
                   ->on('epps');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_epps', function (Blueprint $table) {

            $table->dropForeign(['ot_id']);
            $table->dropColumn('ot_id');

            $table->dropForeign(['epp_id']);
            $table->dropColumn('epp_id');

        });
    }
}
