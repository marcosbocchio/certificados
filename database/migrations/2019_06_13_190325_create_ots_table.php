<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OTs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha_hora');
            $table->integer('numero');
            $table->string('proyecto',50);
            $table->integer('obra');
            $table->integer('presupuesto');
            $table->string('lugar',200);
            $table->string('ubicacion_geo')->nullable();
            $table->string('observaciones')->nullable();
            $table->enum('estado',['CARGANDO','EN PROGRESO','TERMINADA']);
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
        Schema::dropIfExists('ots');
    }
}
