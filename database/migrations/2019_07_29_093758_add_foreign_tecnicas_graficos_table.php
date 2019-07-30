<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignTecnicasGraficosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tecnicas_graficos', function (Blueprint $table) {

            $table->bigInteger('tecnica_id')
                ->unsigned()                             
                ->after('id');
                
            $table->foreign('tecnica_id')
                    ->references('id')
                    ->on('tecnicas');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tecnicas_graficos', function (Blueprint $table) {

            $table->dropForeign(['tecnica_id']);
            $table->dropColumn('tecnica_id');


        });
    }
}
