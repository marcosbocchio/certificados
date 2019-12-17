<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesImportadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes_importados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha');
            $table->integer('numero');
            $table->string('prefijo',10)->nullable();  
            $table->string('path')->nullable();
            $table->string('observaciones',250)->nullable();
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
        Schema::dropIfExists('informes_importados');
    }
}
