<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspesorTubosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Espesor_tubos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('diametro','5');
            $table->float('distancia_fuente_peliculas','6','2');
            $table->float('espesor','6','2');
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
        Schema::dropIfExists('espesor_tubos');
    }
}
