<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha');
            $table->string('tipo_servicio',8);
            $table->timestamps();
            $table->string('horario',5);
            $table->boolean('movilidad_propia_sn');
            $table->string('patente',10)->nullable();
            $table->float('km_inicial')->nullable();
            $table->float('km_final')->nullable();
            $table->string('observaciones')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partes');
    }
}
