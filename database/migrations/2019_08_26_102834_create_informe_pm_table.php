<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformePmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes_pm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('voltaje');
            $table->integer('amperaje');
            $table->string('vehiculo',20)->nullable();
            $table->string('aditivo',20)->nullable();
            $table->float('concentracion');  
            $table->boolean('desmagnetizacion_sn')->defaul(0);  
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
        Schema::dropIfExists('informe_pm');
    }
}
