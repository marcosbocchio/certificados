<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetodosTrabajoPmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodos_trabajo_pm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',20);
            $table->boolean('requiere_vehiculo_aditivo_sn');       
            $table->float('concentracion_min');
            $table->float('concentracion_max');
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
        Schema::dropIfExists('metodos_trabajo_pm');
    }
}
