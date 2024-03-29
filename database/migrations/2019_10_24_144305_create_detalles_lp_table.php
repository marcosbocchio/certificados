<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesLpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_lp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pieza',10);
            $table->integer('cm')->nullable();
            $table->string('detalle');
            $table->boolean('aceptable_sn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_lp');
    }
}
