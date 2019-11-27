<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDetalleUsMeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_us_me', function (Blueprint $table) {
            
            $table->bigInteger('informe_us_me_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('informe_us_me_id')
                ->references('id')
                ->on('informes_us_me');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_us_me', function (Blueprint $table) { 

            $table->dropForeign(['informe_us_me_id']);
            $table->dropColumn('informe_us_me_id');

        });
    }
}
