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
        Schema::create('ots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha');
            $table->integer('numero')->unique();
            $table->string('proyecto',50);
            $table->integer('obra')->nullable();
            $table->integer('presupuesto')->unique();
            $table->string('lugar',200);
            $table->string('lat',100)->nullable();
            $table->string('lon',100)->nullable();
            $table->string('observaciones',250)->nullable();
            $table->datetime('fecha_hora_estimada_ensayo');
            $table->enum('estado',['EDITANDO','ACTIVA','CERRADA']);
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
