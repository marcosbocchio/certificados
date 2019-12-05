<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDetalleUsPaUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_us_pa_us', function (Blueprint $table) {
            
            $table->bigInteger('informe_us_id')
                  ->unsigned()
                  ->after('id');

            $table->foreign('informe_us_id')
                ->references('id')
                ->on('informes_us');
                
            $table->bigInteger('detalle_us_pa_us_referencia_id')
                ->unsigned()
                ->nullable()
                ->after('informe_us_id');

            $table->foreign('detalle_us_pa_us_referencia_id')
                ->references('id')
                ->on('detalles_us_pa_us_referencias');
      
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_us_pa_us', function (Blueprint $table) { 

           $table->dropForeign(['informe_us_id']);
           $table->dropColumn('informe_us_id');

           $table->dropForeign(['detalle_us_pa_us_referencia_id']);
           $table->dropColumn('detalles_us_pa_us_referencia_id');
  

        });
    }
}
