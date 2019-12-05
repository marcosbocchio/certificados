<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleUsPaUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_us_pa_us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('elemento',10);
            $table->string('diametro',10);
            $table->integer('nro_indicacion');
            $table->string('posicion_examen',5);
            $table->string('angulo_incidencia',10);
            $table->string('camino_sonico',6);
            $table->integer('x');
            $table->integer('y');
            $table->integer('z');
            $table->integer('longitud');
            $table->string('nivel_registro',3);
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
        Schema::dropIfExists('detalle_us_pa_us');
    }
}
