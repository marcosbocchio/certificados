<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTipoSoladurasJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('juntas', function (Blueprint $table) {

            $table->bigInteger('tipo_soldadura_id')
                   ->unsigned()
                   ->nullable()
                   ->after('id');
                   
            $table->foreign('tipo_soldadura_id')
                   ->references('id')
                   ->on('tipo_soldaduras');      
         

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

            $table->dropForeign(['tipo_soldadura_id']);
            $table->dropColumn('tipo_soldadura_id');


        });
    }
}
