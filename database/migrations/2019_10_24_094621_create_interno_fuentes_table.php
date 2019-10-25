<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternoFuentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interno_fuentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nro_serie',45);
            $table->boolean('activo_sn')->default(null);
            $table->float('curie')->nullable();
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
        Schema::dropIfExists('interno_fuentes');
    }
}
