<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesUsReferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_us_pa_us_referencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion',500)->nullable();
            $table->string('path1')->nullable();
            $table->string('path2')->nullable();
            $table->string('path3')->nullable();
            $table->string('path4')->nullable();

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
        Schema::dropIfExists('detalles_us_pa_us_referencias');
    }
}
