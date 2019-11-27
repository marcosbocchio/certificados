<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyCalibracionesUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calibraciones_us', function (Blueprint $table) {
            
            $table->bigInteger('informe_us_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('informe_us_id')
                ->references('id')
                ->on('informes_us');
                
            $table->bigInteger('palpador_id')
                ->unsigned()
                ->after('id');

            $table->foreign('palpador_id')
                ->references('id')
                ->on('palpadores');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calibraciones_us', function (Blueprint $table) { 

            $table->dropForeign(['informe_us_id']);
            $table->dropColumn('informe_us_id');

            $table->dropForeign(['palpador_id']);
            $table->dropColumn('palpador_id');

        });
    }
}
