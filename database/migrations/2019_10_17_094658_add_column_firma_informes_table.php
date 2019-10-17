<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFirmaInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes', function (Blueprint $table) {

            $table->bigInteger('firma')
                    ->unsigned()
                    ->nullable()
                    ->after('parte_id');
            
            $table->foreign('firma')
                    ->references('id')
                    ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes', function (Blueprint $table) {
            
            $table->dropForeign(['firma']);
            $table->dropColumn('firma');        


        });
    }
}
