<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosimetriaOperadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosimetria_operador', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha');
            $table->integer('microsievert');
            $table->string('observaciones','250')->nullable();
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
        Schema::dropIfExists('dosimetria_operador');
    }
}
