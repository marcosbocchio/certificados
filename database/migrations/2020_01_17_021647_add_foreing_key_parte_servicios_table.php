<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingKeyParteServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parte_servicios', function (Blueprint $table) {
            
            $table->bigInteger('parte_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('parte_id')
                ->references('id')
                ->on('partes');

            $table->bigInteger('servicio_id')
                ->unsigned()
                ->after('parte_id');

            $table->foreign('servicio_id')
                ->references('id')
                ->on('servicios');

                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parte_servicios', function (Blueprint $table) { 

            $table->dropForeign(['parte_id']);
            $table->dropColumn('parte_id');

            $table->dropForeign(['servicio_id']);
            $table->dropColumn('servicio_id');

        });
    }
}
