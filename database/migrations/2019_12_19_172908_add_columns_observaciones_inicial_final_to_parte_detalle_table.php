<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsObservacionesInicialFinalToParteDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parte_detalles', function (Blueprint $table) {
            
            $table->string('observaciones_original',250)
                ->nullable()
                ->after('nro_final');

            $table->string('observaciones_final',250)
                ->nullable()
                ->after('observaciones_original');
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parte_detalles', function (Blueprint $table) {
           
            $table->dropColumn(['observaciones_original']);      
            $table->dropColumn(['observaciones_final']);      
        });
    }
}
