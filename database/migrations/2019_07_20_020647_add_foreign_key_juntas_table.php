<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('juntas', function (Blueprint $table) {

            $table->bigInteger('informe_ri_id')
                   ->unsigned()
                   ->after('codigo');
                   
            $table->foreign('informe_ri_id')
                   ->references('id')
                   ->on('informes_ri');      
         

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('juntas', function (Blueprint $table) {

            $table->dropForeign(['informe_ri_id']);
            $table->dropColumn('informe_ri_id');


        });
    }
}
