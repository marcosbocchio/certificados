<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCantOriginalFinalToParteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parte_detalles', function (Blueprint $table) {
           
            $table->integer('cant_original')
                    ->nullable()
                    ->after('nro_final');

            $table->integer('cant_final')
                    ->nullable()
                    ->after('cant_original');
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
            
            $table->dropColumn(['cant_original']);      
            $table->dropColumn(['cant_final']);      
        });
    }
}
