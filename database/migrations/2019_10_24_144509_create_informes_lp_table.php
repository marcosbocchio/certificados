<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesLpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes_lp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_penetrante',12);
            $table->integer('tiempo_penetracion');
            $table->string('limpieza_previa',20)->nullable();
            $table->string('limpieza_intermedia',20)->nullable();
            $table->string('limpieza_final',20)->nullable();
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
        Schema::dropIfExists('informes_lp');
    }
}
