<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnKvMaToInformeRiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('informes_ri', function (Blueprint $table) {

            $table->integer('kv')
                   ->nullable() 
                   ->after('interno_fuente_id');                  

            $table->integer('ma')
                    ->nullable() 
                   ->after('kv');            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes_ri', function (Blueprint $table) {

            $table->dropColumn('kv');
            $table->dropColumn('ma');
        });
    }
}
