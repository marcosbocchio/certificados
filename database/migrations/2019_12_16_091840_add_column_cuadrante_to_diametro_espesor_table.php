<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCuadranteToDiametroEspesorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diametros_espesor', function (Blueprint $table) {

            $table->string('cuadrante',10)
                   ->nullable()
                   ->after('espesor');
              });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diametros_espesor', function (Blueprint $table) {
           
            $table->dropColumn(['cuadrante']);      

        });
    }
}
