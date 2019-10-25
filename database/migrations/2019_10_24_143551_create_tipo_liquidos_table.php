<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoLiquidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_liquidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo',15);
            $table->string('marca',10);
            $table->boolean('penetrante_sn')->default(null);
            $table->boolean('revelador_sn')->default(null);
            $table->boolean('removedor_sn')->default(null);
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
        Schema::dropIfExists('tipo_liquidos');
    }
}
