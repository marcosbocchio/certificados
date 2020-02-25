<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificadoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificado_productos', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->integer('placas_original')->nullable();
            $table->integer('placas_final')->nullable();
            $table->string('cm',10)->nullable();
            $table->integer('costuras_original')->nullable();
            $table->integer('costuras_final')->nullable();
            $table->string('pulgadas',10)->nullable();
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
        Schema::dropIfExists('certificado_productos');
    }
}
