<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternoEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interno_equipos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nro_interno',5);
            $table->string('nro_serie',45)->nullable();
            $table->integer('voltaje')->nullable();
            $table->integer('amperaje')->nullable();
            $table->boolean('activo_sn')->default(null);
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
        Schema::dropIfExists('interno_equipos');
    }
}
