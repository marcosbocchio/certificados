<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parte_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('costura_original')->nullable();
            $table->integer('costura_final')->nullable();
            $table->string('pulgadas_original',5)->nullable();
            $table->string('pulgadas_final',5)->nullable();
            $table->float('placas_original')->nullable();
            $table->float('placas_final')->nullable();   
            $table->string('cm_original',15)->nulllable();
            $table->string('cm_final',15)->nulllable();
            $table->string('pieza_original',10)->nullable();
            $table->string('pieza_final',10)->nullable();   
            $table->integer('nro_original')->nullable();   
            $table->integer('nro_final')->nullable(); 
            $table->float('metros_lineales')->nullable();    
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
        Schema::dropIfExists('parte_detalles');
    }
}
