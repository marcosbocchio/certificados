<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesUsMeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes_us_me', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('elemento',10);
            $table->integer('cantidad_posiciones');
            $table->integer('cantidad_generatrices');
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
        Schema::dropIfExists('informes_us_me');
    }
}
