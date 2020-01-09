<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyEstadosOperadorRxToDosimetriaEstadoRxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dosimetria_estados', function (Blueprint $table) {            


            $table->bigInteger('estado_id')
                ->unsigned()
                ->after('fecha');

            $table->foreign('estado_id')
                ->references('id')
                ->on('estados_operador_rx');

        
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dosimetria_estados', function (Blueprint $table) {
           
            $table->dropForeign(['estado_id']);
            $table->dropColumn('estado_id');
        });
    }
}
